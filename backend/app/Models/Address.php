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
    ]
)]
class Address extends BaseModel
{
    //
}
