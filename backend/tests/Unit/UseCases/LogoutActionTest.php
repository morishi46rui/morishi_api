<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Auth;

use App\Models\User;
use App\UseCases\Auth\LogoutAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LogoutActionTest extends TestCase
{
    use RefreshDatabase;

    private LogoutAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpCommonTestData();
        $this->action = new LogoutAction();
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
    public function ログアウト処理を実行しトークンが削除されること(): void
    {
        $user = User::first();
        Sanctum::actingAs($user);

        $request = Request::create('/logout', 'POST');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $response = ($this->action)($request);

        $this->assertEmpty($user->tokens);
        $this->assertEquals(
            ['message' => 'ログアウトしました。'],
            $response
        );
    }
}
