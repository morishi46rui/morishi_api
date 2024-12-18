<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\UseCases\Auth\LoginAction;
use App\UseCases\Auth\LogoutAction;
use App\UseCases\Auth\RegisterAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Auth', description: 'ユーザー認証')]
class AuthController extends Controller
{
    #[OA\Post(
        path: '/login',
        tags: ['Auth'],
        summary: 'ログイン',
        description: 'メールアドレスとパスワードでログイン',
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
            new OA\Response(response: '422', ref: '#/components/responses/422'),
        ]
    )]
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $response = $action($credentials);

        return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
    }

    #[OA\Post(
        path: '/logout',
        tags: ['Auth'],
        summary: 'ログアウト',
        description: '現在のセッションを終了し、トークンを削除します',
        operationId: 'logout',
        security: [['sanctum_token' => []]],
        responses: [
            new OA\Response(
                response: '200',
                description: 'ログアウト成功',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/logoutResponse'
                )
            ),
            new OA\Response(response: '401', ref: '#/components/responses/401'),
        ]
    )]
    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        $response = $action($request);

        return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
    }

    #[OA\Post(
        path: '/register',
        tags: ['Auth'],
        summary: 'アカウント新規作成',
        description: '新しいユーザーアカウントを作成',
        operationId: 'register',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/registerRequest'
            )
        ),
    )]
    #[OA\Response(
        response: '201',
        description: 'アカウント新規作成成功',
        content: new OA\JsonContent(
            ref: '#/components/schemas/registerResponse'
        )
    )]
    #[OA\Response(response: '422', ref: '#/components/responses/422')]
    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $response = $action($request);

        return response()->json($response, 201);
    }
}
