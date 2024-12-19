<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use App\Utils\CaseConverter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CaseConverterTest extends TestCase
{
    protected $camelCaseKeys =
        [
            'camelCaseKey' => 'value1',
            'anotherCamelCaseKey' => 'value2',
            'yetAnotherKey' => 'value3',
        ];

    protected $snakeCaseKeys =
        [
            'camel_case_key' => 'value1',
            'another_camel_case_key' => 'value2',
            'yet_another_key' => 'value3',
        ];

    #[Test]
    public function toSnakeCaseKeys_正常に変換できること(): void
    {
        $this->assertSame(
            $this->snakeCaseKeys,
            CaseConverter::toSnakeCaseKeys($this->camelCaseKeys)
        );
    }

    #[Test]
    public function toSnakeCaseKeys_空の配列の場合、空の配列を返すこと(): void
    {
        $empty = [];

        $this->assertSame($empty, CaseConverter::toSnakeCaseKeys($empty));
    }

    #[Test]
    public function toSnakeCaseKeys_キーがスネークケースの場合、変換されないこと(): void
    {
        $this->assertSame(
            $this->snakeCaseKeys,
            CaseConverter::toSnakeCaseKeys($this->snakeCaseKeys)
        );
    }
}
