<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Auth;

use App\Models\User;
use App\UseCases\Auth\LogoutAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;
use PHPUnit\Framework\Attributes\Test;
use Tests\Helpers\TestHelper;
use Tests\TestCase;

class LogoutActionTest extends TestCase
{
    use RefreshDatabase, TestHelper;

    private LogoutAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new LogoutAction();
        self::createPassportClient();
    }

    #[Test]
    public function ログアウトが成功すること(): void
    {
        $this->markTestSkipped('ログアウトが成功すること');
        // テスト用のユーザー作成
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->token;

        // パスポートを使用してユーザーを認証
        Passport::actingAs($user);

        // トークンが有効であることを確認
        $this->assertTrue($token->exists());

        // ログアウトアクションの実行
        $response = ($this->action)();

        // レスポンスの確認
        $this->assertSame([
            'message' => 'ログアウトに成功しました。',
        ], $response);

        // トークンが無効化されていることを確認
        $this->assertDatabaseMissing('oauth_access_tokens', [
            'id' => $token->id,
            'revoked' => false,
        ]);
    }
}
