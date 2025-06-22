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
    ]
)]
class City extends BaseModel
{
    //
}
