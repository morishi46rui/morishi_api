<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Str;

class CaseConverter
{
    /**
     * 連想配列のキーをスネークケースに変換
     *
     * @param array<string, mixed> $data 変換する連想配列
     * @return array<string, mixed> スネークケースに変換された連想配列
     */
    public static function toSnakeCaseKeys(array $data): array
    {
        return self::convertKeys($data, [Str::class, 'snake']);
    }

    /**
     * 連想配列のキーをキャメルケースに変換
     *
     * @param array<string, mixed> $data 変換する連想配列
     * @return array<string, mixed> キャメルケースに変換された連想配列
     */
    public static function toCamelCaseKeys(array $data): array
    {
        return self::convertKeys($data, [Str::class, 'camel']);
    }

    /**
     * 共通化されたキー変換処理
     *
     * @param array<string, mixed> $data 変換する連想配列
     * @param callable $convertFunction 変換関数
     * @return array<string, mixed> 変換された連想配列
     */
    private static function convertKeys(array $data, callable $convertFunction): array
    {
        return collect($data)
            ->mapWithKeys(fn ($value, $key) => [$convertFunction($key) => $value])
            ->all();
    }
}
