<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Auth;

use App\Models\User;
use App\UseCases\Auth\LoginAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class LoginActionTest extends TestCase
{
    use RefreshDatabase;

    private LoginAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new LoginAction();
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
    public function ログインが成功すること(): void
    {
        $this->createTestUser([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];
        $response = ($this->action)($credentials);

        $this->assertArrayHasKey('message', $response);
        $this->assertArrayHasKey('token', $response);
        $this->assertEquals('ログイン成功', $response['message']);
        $this->assertNotEmpty($response['token']);
    }

    #[Test]
    public function 認証情報が間違っている場合は401エラーを返すこと(): void
    {
        $this->createTestUser([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $credentials = [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ];

        try {
            ($this->action)($credentials);
        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_UNAUTHORIZED, $e->getStatusCode());
            $this->assertEquals('ログイン失敗：認証に失敗しました。', $e->getMessage());

            return;
        }

        $this->fail('HttpException with 401 status code was not thrown.');
    }
}
