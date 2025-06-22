<?php

declare(strict_types=1);

namespace App\Models;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'prefecture',
    title: 'Prefecture',
    type: 'object',
    description: 'Prefecture',
    properties: [
        new OA\Property(property: 'id', type: 'string', description: 'ID（Sqid）', example: 'DzP3tWWwjsIT'),
    ]
)]
class Prefecture extends BaseModel
{
    //
}
