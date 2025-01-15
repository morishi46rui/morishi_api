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

        $response = $this->postJson('/api/v1/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'token',
        ]);
    }

    #[Test]
    public function login_ログイン情報が異なる場合で401が返ること(): void
    {
        $this->createTestUser();

        $response = $this->postJson('/api/v1/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'ログイン失敗：認証に失敗しました。',
        ]);
    }
}
