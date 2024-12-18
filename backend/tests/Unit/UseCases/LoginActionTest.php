<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Auth;

use App\Models\User;
use App\UseCases\Auth\LoginAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginActionTest extends TestCase
{
    use RefreshDatabase;

    private LoginAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCommonTestData();
        $this->action = new LoginAction();
    }

    private function setUpCommonTestData(): void
    {
        User::factory()->createMany(
            [
                [
                    'email' => 'user1@example.com',
                    'password' => Hash::make('password123'),
                ],
                [
                    'email' => 'user2@example.com',
                    'password' => Hash::make('password123'),
                ],
            ]
        );
    }

    #[Test]
    public function ログイン成功時にアクセストークンが返ること(): void
    {
        $credentials = ['email' => 'user1@example.com', 'password' => 'password123'];
        $response = ($this->action)($credentials);

        $this->assertArrayHasKey('token', $response);
        $this->assertEquals('ログイン成功', $response['message']);
    }
}
