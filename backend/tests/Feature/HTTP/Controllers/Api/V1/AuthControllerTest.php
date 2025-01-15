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

    private $authHeader = [];

    protected function setUp(): void
    {
        parent::setUp();
        Spectator::using('api-docs.json');
    }

    private function createTestUser(array $attributes = []): User
    {
        $user = User::factory()->create(array_merge([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ], $attributes));

        return $user;
    }

    #[Test]
    public function login_レスポンス200が返ること(): void
    {
        $this->createTestUser();
        $this->postJson('/api/v1/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ])
            ->assertValidRequest()
            ->assertValidResponse(200);
    }

    // #[Test]
    // public function login_ログイン情報が異なる場合で401が返ること(): void
    // {
    //     $this->createTestUser();
    //     $this->postJson('/api/v1/login', [
    //         'email' => 'user@example.com',
    //         'password' => 'password1234',
    //     ])
    //         ->assertValidRequest()
    //         ->assertValidResponse(401);
    // }
}
