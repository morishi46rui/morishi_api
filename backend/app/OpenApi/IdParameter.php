<?php

declare(strict_types=1);

namespace App\OpenApi;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: 'idParameter',
    name: 'id',
    in: 'query',
    required: true,
    description: 'id',
    schema: new OA\Schema(
        type: 'integer'
    )
)]

class IdParameter extends FormRequest
{
    // バリデーションルールやその他のメソッドをここに定義
}
