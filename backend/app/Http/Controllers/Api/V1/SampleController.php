<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\UseCases\Sample\SampleAction;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Sample', description: 'サンプル')]
class SampleController extends Controller
{
    #[OA\Get(
        path: '/sample',
        tags: ['Sample'],
        summary: 'サンプル',
        description: 'サンプル',
        operationId: 'getSample'
    )]
    #[OA\Response(
        response: '200',
        description: 'サンプルのレスポンス',
        content: new OA\JsonContent(
            required: ['sample'],
            properties: [
                new OA\Property(
                    property: 'sample',
                    description: 'サンプル',
                    type: 'integer',
                    example: 1
                ),
            ]
        )
    )]
    public function index(SampleAction $action): JsonResponse
    {
        return response()->json($action(), 200, [], JSON_UNESCAPED_UNICODE);
    }
}
