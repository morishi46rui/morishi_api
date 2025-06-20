<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Spectator\Spectator;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Spectator::using('api-docs.json');

        self::createPassportClient();
    }

    private function createTestUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ], $attributes));
    }

    #[Test]
    public function login_レスポンス200が返ること(): void
    {
        $this->createTestUser();

        $this->postJson('/api/v1/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'token',
            ]);
    }

    #[Test]
    public function login_ログイン情報が異なる場合で401が返ること(): void
    {
        $this->createTestUser();

        $this->postJson('/api/v1/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ])
            ->assertStatus(401)
            ->assertJson([
                'message' => 'ログイン失敗：認証に失敗しました。',
            ]);
    }

    #[Test]
    public function logout_レスポンス200が返ること(): void
    {
        $token = self::createLoginUser();

        $this->withHeaders(self::getAuthHeader($token))
            ->postJson('/api/v1/logout')
            ->assertStatus(200)
            ->assertJson([
                'message' => 'ログアウトに成功しました。',
            ]);
    }

    #[Test]
    public function logout_未認証で401が返ること(): void
    {
        $this->postJson('/api/v1/logout')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}
