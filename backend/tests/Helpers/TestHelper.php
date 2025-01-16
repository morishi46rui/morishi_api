<?php

declare(strict_types=1);

namespace Tests\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

trait TestHelper
{
    protected static bool $passportClientCreated = false;

    protected static function createPassportClient(): void
    {
        // テーブルの内容を毎回リセットしてクライアントを再作成
        DB::table('oauth_clients')->truncate();

        $clientRepository = new ClientRepository();
        $clientRepository->createPersonalAccessClient(
            null,
            'Personal Access Client',
            'http://localhostexit'
        );

        self::$passportClientCreated = true;
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
