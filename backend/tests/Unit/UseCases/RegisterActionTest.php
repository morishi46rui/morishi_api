<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Auth;

use App\UseCases\Auth\RegisterAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    use RefreshDatabase;

    private RegisterAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new RegisterAction();
    }

    #[Test]
    public function ユーザーが作成されること(): void
    {
        $request = new Request([
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd',
        ]);

        $response = ($this->action)($request);

        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('email', $response);
    }
}
