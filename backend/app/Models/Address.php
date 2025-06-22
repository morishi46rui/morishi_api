<?php

declare(strict_types=1);

namespace App\Models;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'address',
    title: 'Address',
    type: 'object',
    description: 'Address',
    properties: [
        new OA\Property(property: 'id', type: 'string', description: 'ID（Sqid）', example: 'DzP3tWWwjsIT'),
        new OA\Property(property: 'code', type: 'string', description: '大字町丁目コード', example: '281010001001'),
        new OA\Property(property: 'name', type: 'string', description: '大字町丁目名', example: '御影一丁目'),
        new OA\Property(property: 'latitude', type: 'number', format: 'float', description: '緯度', example: 34.720175),
        new OA\Property(property: 'longitude', type: 'number', format: 'float', description: '経度', example: 135.249919),
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
class Address extends BaseModel
{
    protected $fillable = ['code', 'name', 'latitude', 'longitude', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
