<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\Sample;

use App\UseCases\Sample\SampleAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SampleActionTest extends TestCase
{
    use RefreshDatabase;

    private $action;

    private $expectedResultBase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->expectedResultBase = ['sample' => 1];
        $this->action = new SampleAction();
    }

    #[Test]
    public function サンプルが取得できること(): void
    {
        $this->assertEquals($this->expectedResultBase, $this->action->__invoke());
    }
}
