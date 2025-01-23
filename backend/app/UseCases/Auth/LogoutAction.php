<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use Illuminate\Support\Facades\Auth;
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
            example: 'ログアウトに成功しました。'
        ),
    ]
)]
class LogoutAction
{
    /**
     * ログアウト処理を実行
     * @return array 成功時のレスポンスメッセージ
     */
    public function __invoke(): array
    {
        $user = Auth::user();

        /**
         * @var \App\Models\User $user
         */
        if ($user && $user->token()) {
            $user->token()->revoke();
        }

        return [
            'message' => 'ログアウトに成功しました。',
        ];
    }
}
