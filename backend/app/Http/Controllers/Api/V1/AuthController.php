<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\UseCases\Auth\LoginAction;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Auth', description: '認証')]
class AuthController extends Controller
{
    #[OA\Post(
        path: '/login',
        tags: ['Auth'],
        summary: 'ログイン',
        description: 'ログイン',
        operationId: 'login',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/loginRequest'
            )
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'ログイン成功',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/loginResponse'
                )
            ),
            new OA\Response(response: '401', ref: '#/components/responses/401'),
            new OA\Response(response: '404', ref: '#/components/responses/404'),
            new OA\Response(response: '422', ref: '#/components/responses/422'),
        ]
    )]
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $response = $action($credentials);

        return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
