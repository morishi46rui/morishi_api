<?php

declare(strict_types=1);

namespace App\UseCases\Address;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;
use RuntimeException;
use Throwable;

#[OA\Schema(
    schema: 'addressUploadResponse',
    type: 'object',
    description: 'アドレスデータのアップロード結果',
    required: ['message'],
    properties: [
        new OA\Property(
            property: 'message',
            description: 'サンプルメッセージ',
            type: 'string',
            example: 'Addressデータが更新されました'
        ),
    ]
)]
class AddressCsvUploadAction
{
    public function __invoke(Request $request): array
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $path = $request->file('file')->storeAs('uploads', 'uploaded.csv', 'local');
        $fullPath = storage_path('app/' . $path);

        $handle = fopen($fullPath, 'r');
        if (! $handle) {
            Log::error("ファイルを開けませんでした: {$fullPath}");
            throw new RuntimeException('ファイルを開けませんでした');
        }

        $filter = stream_filter_append($handle, 'convert.iconv.SJIS-win/UTF-8');
        if (! $filter) {
            Log::error('文字エンコーディングフィルターの追加に失敗しました');
        }
        fgetcsv($handle); // ヘッダー除去

        $batchSize = 1000;
        $batch = [];
        $processedCount = 0;

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $batch[] = $row;

                if (count($batch) >= $batchSize) {
                    $this->processBatch($batch);
                    $processedCount += count($batch);
                    $batch = [];

                    gc_collect_cycles();
                    Log::info("処理済み件数: {$processedCount}");
                }
            }

            if (! empty($batch)) {
                $this->processBatch($batch);
                $processedCount += count($batch);
            }

            Log::info("全処理完了: {$processedCount}件");
        } catch (Throwable $e) {
            Log::error('アップロード処理中にエラーが発生: ' . $e->getMessage());
            throw $e;
        } finally {
            fclose($handle);
        }

        return ['message' => "Addressデータが更新されました（{$processedCount}件処理）"];
    }

    private function processBatch(array $batch): void
    {
        DB::beginTransaction();

        try {
            $prefectures = [];
            $cities = [];
            $addresses = [];

            foreach ($batch as $row) {
                [$prefCode, $prefName, $cityCode, $cityName, $addressCode, $addressName, $lat, $lng] = $row;

                $prefectures[(int) $prefCode] = $prefName;
                $cities[(int) $cityCode] = ['name' => $cityName, 'pref_code' => (int) $prefCode];
                $addresses[(int) $addressCode] = [
                    'name' => $addressName,
                    'latitude' => (float) $lat,
                    'longitude' => (float) $lng,
                    'city_code' => (int) $cityCode,
                ];
            }

            foreach ($prefectures as $code => $name) {
                DB::table('prefectures')->updateOrInsert(
                    ['code' => $code],
                    ['name' => $name, 'updated_at' => now(), 'created_at' => now()]
                );
            }

            $prefectureIds = DB::table('prefectures')
                ->whereIn('code', array_keys($prefectures))
                ->pluck('id', 'code')
                ->toArray();

            foreach ($cities as $code => $cityData) {
                $prefId = $prefectureIds[$cityData['pref_code']] ?? null;
                if (! $prefId) {
                    throw new RuntimeException("都道府県IDが見つかりません: {$cityData['pref_code']}");
                }

                DB::table('cities')->updateOrInsert(
                    ['code' => $code],
                    [
                        'name' => $cityData['name'],
                        'prefecture_id' => $prefId,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            $cityIds = DB::table('cities')
                ->whereIn('code', array_keys($cities))
                ->pluck('id', 'code')
                ->toArray();

            foreach ($addresses as $code => $addressData) {
                $cityId = $cityIds[$addressData['city_code']] ?? null;
                if (! $cityId) {
                    throw new RuntimeException("市区町村IDが見つかりません: {$addressData['city_code']}");
                }

                DB::table('addresses')->updateOrInsert(
                    ['code' => $code],
                    [
                        'name' => $addressData['name'],
                        'latitude' => $addressData['latitude'],
                        'longitude' => $addressData['longitude'],
                        'city_id' => $cityId,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
