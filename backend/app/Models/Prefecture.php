<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'prefecture',
    title: 'Prefecture',
    type: 'object',
    description: 'Prefecture',
    properties: [
        new OA\Property(property: 'id', type: 'string', description: 'ID（Sqid）', example: 'DzP3tWWwjsIT'),
        new OA\Property(property: 'code', type: 'integer', description: '都道府県コード', example: 28),
        new OA\Property(property: 'name', type: 'string', description: '都道府県名', example: '兵庫県'),
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
class Prefecture extends BaseModel
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
