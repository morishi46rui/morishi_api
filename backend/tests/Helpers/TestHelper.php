<?php

declare(strict_types=1);

namespace Tests\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

trait TestHelper
{
    private static bool $isClientCreated = false;

    /**
     * クライアントを作成（既に存在する場合は再利用）
     */
    public static function createPassportClient(): void
    {
        if (! DB::table('oauth_clients')->where('name', 'Personal Access Client')->exists()) {
            $clientRepository = new ClientRepository();
            $clientRepository->createPersonalAccessClient(
                null,
                'Personal Access Client',
                'http://localhost'
            );
        }
    }

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
