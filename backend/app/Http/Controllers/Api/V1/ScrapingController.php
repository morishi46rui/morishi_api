<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\UseCases\Scraping\ScrapePageAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Scraping', description: 'スクレイピングAPI')]
class ScrapingController extends Controller
{
    #[OA\Get(
        path: '/scrape',
        tags: ['Scraping'],
        summary: '指定URLのH2タイトルを抽出',
        description: 'Guzzle + DomCrawler を使用して対象ページから h2 タグを抽出します',
        operationId: 'scrapePage',
        parameters: [
            new OA\Parameter(
                name: 'url',
                description: '対象URL',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uri')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'スクレイピング結果',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'url',
                            type: 'string',
                            example: 'https://example.com'
                        ),
                        new OA\Property(
                            property: 'titles',
                            type: 'array',
                            items: new OA\Items(type: 'string'),
                            example: ['見出し1', '見出し2']
                        )
                    ]
                )
            ),
            new OA\Response(response: '400', ref: '#/components/responses/400'),
        ]
    )]
    public function __invoke(Request $request, ScrapePageAction $action): JsonResponse
    {
        $url = $request->query('url');

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['message' => 'Invalid URL'], 400);
        }

        try {
            $result = $action($url);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error scraping page: ' . $e->getMessage()], 500);
        }
    }
}
