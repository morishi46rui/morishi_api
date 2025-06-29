<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\UseCases\Address\AddressCsvUploadAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Address', description: 'Address関連処理')]
class AddressController extends Controller
{
    #[OA\Post(
        path: '/address/upload',
        tags: ['Address'],
        summary: 'AddressCSVアップロード',
        description: 'CSVファイルをアップロードしてAddressデータを更新します。',
        operationId: 'uploadAddressCsv',
    )]
    #[OA\RequestBody(
        description: 'CSVファイルを含むリクエストボディ',
        required: true,
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                type: 'object',
                required: ['file'],
                properties: [
                    new OA\Property(
                        property: 'file',
                        type: 'string',
                        format: 'binary',
                        description: 'CSVファイル（都道府県・市区町村・住所情報）'
                    ),
                ]
            )
        )
    )]
    #[OA\Response(
        response: '200',
        description: '成功',
        content: new OA\JsonContent(ref: '#/components/schemas/addressUploadResponse')
    )]
    public function upload(AddressCsvUploadAction $action, Request $request): JsonResponse
    {
        $response = $action($request);

        return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
