<?php

declare(strict_types=1);

namespace App\Models;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'city',
    title: 'City',
    type: 'object',
    description: 'City',
    properties: [
        new OA\Property(property: 'id', type: 'string', description: 'ID（Sqid）', example: 'DzP3tWWwjsIT'),
        new OA\Property(property: 'code', type: 'integer', description: '市区町村コード', example: 28101),
        new OA\Property(property: 'name', type: 'string', description: '市区町村名', example: '神戸市'),
        new OA\Property(
            property: 'deletedAt',
            type: 'string',
            format: 'date-time',
            description: '削除日時(UTC)',
            example: '2024-01-01T00:00:00.000Z'
        ),
        new OA\Property(
            property: 'createdAt',
            type: 'string',
            format: 'date-time',
            description: '作成日時(UTC)',
            example: '2024-01-01T00:00:00.000Z'
        ),
        new OA\Property(
            property: 'updatedAt',
            type: 'string',
            format: 'date-time',
            description: '更新日時(UTC)',
            example: '2024-01-01T00:00:00.000Z'
        ),
    ]
)]
class City extends BaseModel
{
    //
}
