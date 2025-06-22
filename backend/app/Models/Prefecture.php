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
        new OA\Property(property: 'name', type: 'string', description: '都道府県名', example: '兵庫県'),
        new OA\Property(property: 'code', type: 'string', description: '都道府県コード', example: '28'),
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
