<?php

declare(strict_types=1);

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: '400',
    title: 'Bad Request',
    required: [],
    properties: [
        new OA\Property(
            property: 'code',
            type: 'integer',
            example: 400
        ),
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Bad Request'
        ),
    ]
)]
#[OA\Schema(
    schema: '401',
    title: 'Unauthorized',
    required: [],
    properties: [
        new OA\Property(
            property: 'code',
            type: 'integer',
            example: 401
        ),
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Unauthorized'
        ),
    ]
)]
#[OA\Schema(
    schema: '403',
    title: 'Forbidden',
    required: [],
    properties: [
        new OA\Property(
            property: 'code',
            type: 'integer',
            example: 403
        ),
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Forbidden'
        ),
    ]
)]
#[OA\Schema(
    schema: '404',
    title: 'Not Found',
    required: [],
    properties: [
        new OA\Property(
            property: 'code',
            type: 'integer',
            example: 404
        ),
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Not Found'
        ),
    ]
)]
#[OA\Schema(
    schema: '422',
    title: 'Unprocessable Entity Error',
    required: [],
    properties: [
        new OA\Property(
            property: 'code',
            type: 'integer',
            example: 422
        ),
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Validation Error'
        ),
        new OA\Property(
            property: 'errors',
            type: 'object',
            additionalProperties: new OA\AdditionalProperties(
                type: 'array',
                items: new OA\Items(type: 'string')
            ),
            example: [
                'field1' => ['Error message 1', 'Error message 2'],
                'field2' => ['Error message 3'],
            ]
        ),
    ]
)]

#[OA\Schema(
    schema: '201',
    type: 'object',
    title: '201 Created',
    required: [],
    properties: [
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'OK'
        ),
    ]
)]

#[OA\Response(
    response: '400',
    description: 'bad request',
    content: new OA\JsonContent(ref: '#/components/schemas/400')
)]
#[OA\Response(
    response: '401',
    description: 'unauthorized',
    content: new OA\JsonContent(ref: '#/components/schemas/401')
)]
#[OA\Response(
    response: '403',
    description: 'forbidden',
    content: new OA\JsonContent(ref: '#/components/schemas/403')
)]
#[OA\Response(
    response: '404',
    description: 'not found',
    content: new OA\JsonContent(ref: '#/components/schemas/404')
)]
#[OA\Response(
    response: '422',
    description: 'unprocessable entity',
    content: new OA\JsonContent(ref: '#/components/schemas/422')
)]
#[OA\Response(
    response: '201',
    description: 'created',
    content: new OA\JsonContent(ref: '#/components/schemas/201')
)]
class ErrorResponse
{
}
