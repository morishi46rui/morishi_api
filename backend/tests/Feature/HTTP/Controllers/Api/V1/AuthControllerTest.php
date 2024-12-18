<?php

declare(strict_types=1);

namespace Tests\Feature\HTTP\Controllers\Api\V1;

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
        $this->setUpCommonTestData();
        Spectator::using('api-docs.json');
    }

    private function setUpCommonTestData(): void
    {
        User::factory()->createMany(
            [
                [
                    'email' => 'user1@example.com',
                    'password' => Hash::make('P@ssw0rd'),
                ],
                [
                    'email' => 'user2@example.com',
                    'password' => Hash::make('P@ssw0rd'),
                ],
            ]
        );
    }

    #[Test]
    public function login_レスポンス200が返ること(): void
    {
        $request = [
            'email' => 'user1@example.com',
            'password' => 'P@ssw0rd',
        ];

        $this->postJson('/api/v1/login', $request)
            ->assertValidRequest()
            ->assertValidResponse(200);
    }

    #[Test]
    public function login_ログイン情報が不正な場合401が返ること(): void
    {
        $request = [
            'email' => 'un-auth-user@example.com',
            'password' => 'P@ssw0rd',
        ];

        $this->postJson('/api/v1/login', $request)
            ->assertValidRequest()
            ->assertValidResponse(401);
    }

    #[Test]
    public function login_リクエストが不正な場合422が返ること(): void
    {
        $request = [
            'email' => '',
            'password' => '',
        ];

        $this->postJson('/api/v1/login', $request)
            ->assertValidRequest()
            ->assertValidResponse(422);
    }

    #[Test]
    public function logout_レスポンス200が返ること(): void
    {
        $token = $this->createLoginUser(['id' => 3]);
        $this->authHeader = $this->getAuthHeader($token);
        $this->postJson('/api/v1/logout', [], $this->authHeader)
            ->assertValidRequest()
            ->assertValidResponse(200);
    }

    #[Test]
    public function logout_未認証の場合401が返ること(): void
    {
        $this->postJson('/api/v1/logout', ['Authorization' => 'Bearer invalid_token'])
            ->assertValidRequest()
            ->assertValidResponse(401);
    }

    #[Test]
    public function register_レスポンス201が返ること(): void
    {
        $request = [
            'name' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'P@ssw0rd',
            'passwordConfirmation' => 'P@ssw0rd',
        ];

        $this->postJson('/api/v1/register', $request)
            ->assertValidRequest()
            ->assertValidResponse(201);
    }

    #[Test]
    public function register_リクエストが不正な場合422が返ること(): void
    {
        $request = [
            'name' => '',
            'email' => '',
            'password' => '',
            'passwordConfirmation' => '',
        ];

        $this->postJson('/api/v1/register', $request)
            ->assertValidRequest()
            ->assertValidResponse(422);
    }

    #[Test]
    public function register_登録済みのメールアドレスの場合422が返ること(): void
    {
        $request = [
            'name' => 'new user',
            'email' => 'user1@example.com',
            'password' => 'P@ssw0rd',
            'passwordConfirmation' => 'P@ssw0rd',
        ];

        $this->postJson('/api/v1/register', $request)
            ->assertValidRequest()
            ->assertValidResponse(422);
    }
}
