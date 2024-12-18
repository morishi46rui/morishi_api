<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'logoutResponse',
    type: 'object',
    description: 'ログアウト成功',
    required: ['message'],
    properties: [
        new OA\Property(
            property: 'message',
            type: 'string',
            description: 'メッセージ',
            example: 'ログアウトしました。'
        ),
    ]
)]

class LogoutAction
{
    /**
     * ログアウト処理を実行し、トークンを削除
     * @return array 成功時のレスポンスメッセージ
     */
    public function __invoke($request): array
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return ['message' => 'ログアウトしました。'];
    }
}
