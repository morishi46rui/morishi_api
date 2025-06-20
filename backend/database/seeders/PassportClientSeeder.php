<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Laravel\Passport\Client;

class PassportClientSeeder extends Seeder
{
    public function run()
    {
        // Personal Access Client
        $personalClient = Client::updateOrCreate(
            ['name' => 'Personal Access Client', 'personal_access_client' => true],
            [
                'secret' => 'your_personal_access_client_secret', // 必要ならランダム生成
                'redirect' => 'http://localhost',
                'personal_access_client' => true,
                'password_client' => false,
                'revoked' => false,
            ]
        );

        // Password Grant Client
        $passwordClient = Client::updateOrCreate(
            ['name' => 'Password Grant Client', 'password_client' => true],
            [
                'secret' => 'your_password_grant_client_secret', // 必要ならランダム生成
                'redirect' => 'http://localhost',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
            ]
        );

        // クライアント情報をファイルに保存
        $secretsPath = base_path('backend/app/secrets/oauth');
        if (! File::exists($secretsPath)) {
            File::makeDirectory($secretsPath, 0755, true);
        }

        $privateKeyPath = $secretsPath . '/oauth-private.key';
        $content = json_encode([
            'personal_access_client_id' => $personalClient->id,
            'personal_access_client_secret' => $personalClient->secret,
            'password_client_id' => $passwordClient->id,
            'password_client_secret' => $passwordClient->secret,
        ], JSON_PRETTY_PRINT);

        File::put($privateKeyPath, $content);
        echo "OAuth secrets saved to {$privateKeyPath}\n";
    }
}
