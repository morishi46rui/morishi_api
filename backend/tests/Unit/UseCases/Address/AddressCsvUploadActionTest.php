<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Address;

use App\UseCases\Address\AddressCsvUploadAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddressCsvUploadActionTest extends TestCase
{
    use RefreshDatabase;

    private $action;

    private $expectedResultBase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->expectedResultBase = ['sample' => 1];
        $this->action = new AddressCsvUploadAction();
    }

    #[Test]
    public function サンプルが取得できること(): void
    {
        // TODO: テスト実装
    }
}
