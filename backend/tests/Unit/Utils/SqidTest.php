<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use App\Utils\Sqid;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SqidTest extends TestCase
{
    protected $sqid;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sqid = new Sqid();
    }

    #[Test]
    public function encode_正常にエンコードできること(): void
    {
        $recordId = 123;
        $randomNumber = 456;
        $encoded = $this->sqid->encode($recordId, $randomNumber);

        $this->assertIsString($encoded);
        $this->assertNotEmpty($encoded);
    }

    #[Test]
    public function decode_正常にデコードできること(): void
    {
        $recordId = 123;
        $randomNumber = 456;
        $encoded = $this->sqid->encode($recordId, $randomNumber);
        $decoded = $this->sqid->decode($encoded);

        $this->assertIsInt($decoded);
        $this->assertEquals($recordId, $decoded);
    }

    #[Test]
    public function decode_不正なSQIDの場合、nullを返すこと(): void
    {
        $invalidSqid = 'invalid_sqid';
        $decoded = $this->sqid->decode($invalidSqid);

        $this->assertNull($decoded);
    }
}
