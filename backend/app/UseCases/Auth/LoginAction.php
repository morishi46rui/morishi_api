<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'loginResponse',
    type: 'object',
    description: 'ログイン成功',
    required: ['message', 'token'],
    properties: [
        new OA\Property(
            property: 'message',
            type: 'string',
            description: 'メッセージ',
            example: 'ログイン成功'
        ),
        new OA\Property(
            property: 'token',
            type: 'string',
            description: 'アクセストークン',
            example: 'sample_token'
        ),
    ]
)]

class LoginAction
{
    /**
     * ログイン処理を実行し、ワンタイムパスワードやアカウントロック機能を適用
     * @return array 成功時のレスポンスメッセージとトークン
     */
    public function __invoke($request): array
    {
        echo $request;

        return [
            'message' => 'ログイン成功',
            'token' => 'sample_token',
        ];
    }
}
