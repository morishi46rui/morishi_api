<?php

declare(strict_types=1);

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'morishi API',
    version: '0.1',
    description: 'morishi API',
    contact: new OA\Contact(email: 'morishi@example.com')
)]
#[OA\Server(
    url: 'http://localhost:8000/api/v1',
    description: 'Localhost API Server'
)]
class OpenApi
{
}
