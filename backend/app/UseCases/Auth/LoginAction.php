<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

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
     * ログイン処理を実行
     * @param array $credentials 認証情報（email, password）
     * @return array 成功時のレスポンスメッセージとトークン
     */
    public function __invoke(array $credentials): array
    {
        $this->attemptAuthentication($credentials);
        $user = $this->getUser();
        $token = $this->createToken($user);

        return [
            'message' => 'ログイン成功',
            'token' => $token,
        ];
    }

    /**
     * 認証を試行
     * @param array $credentials 認証情報
     */
    private function attemptAuthentication(array $credentials): void
    {
        if (! Auth::attempt($credentials)) {
            abort(Response::HTTP_UNAUTHORIZED, 'ログイン失敗：認証に失敗しました。');
        }
    }

    /**
     * ユーザーを取得
     */
    private function getUser(): User
    {
        $user = Auth::user();

        if (! $user) {
            abort(Response::HTTP_NOT_FOUND, 'ログイン失敗：ユーザーが見つかりません。');
        }

        return $user;
    }

    /**
     * アクセストークンを作成
     */
    private function createToken(User $user): string
    {
        return $user->createToken('authToken')->accessToken;
    }
}
