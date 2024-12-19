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
    required: ['message'],
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
     * @param array $credentials ユーザーのログイン資格情報
     * @return array 成功時のレスポンスメッセージとトークン
     */
    public function __invoke(array $credentials): array
    {
        // ユーザーのログイン
        if (! Auth::attempt($credentials)) {
            abort(Response::HTTP_UNAUTHORIZED, 'メールアドレスまたはパスワードが正しくありません。');
        }

        $user = Auth::user();

        if (! $user instanceof User) {
            abort(Response::HTTP_UNAUTHORIZED, 'ログインに失敗しました。');
        }

        return $this->generateLoginResponse($user);
    }

    /**
     * 成功したログインのレスポンスを生成
     * @return array メッセージとトークンを含むレスポンス
     */
    private function generateLoginResponse(User $user): array
    {
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'ログイン成功',
            'token' => $token,
        ];
    }
}
