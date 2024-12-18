<?php

declare(strict_types=1);

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: 'Authorization',
    name: 'Authorization',
    in: 'header',
    required: true,
    description: 'SanctumのBearerトークン',
    schema: new OA\Schema(
        type: 'string',
        example: 'Bearer your_token_here',
    )
)]

class RequestHeader
{
}
