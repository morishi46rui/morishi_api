<?php

declare(strict_types=1);

namespace Tests\Helpers;

use App\Models\User;

trait TestHelper
{
    /**
     * ユーザーを作成し、認証トークンを生成する
     *
     * @return string 認証トークン
     */
    public static function createLoginUser(array $userData = []): string
    {
        $user = User::factory()->create($userData);

        return $user->createToken('auth_token')->plainTextToken;
    }

    /**
     * 認証ヘッダーを取得する
     */
    public static function getAuthHeader(string $token): array
    {
        return ['Authorization' => 'Bearer ' . $token];
    }
}
