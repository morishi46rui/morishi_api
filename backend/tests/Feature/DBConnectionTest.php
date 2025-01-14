<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DBConnectionTest extends TestCase
{
    #[Test]
    public function テスト用のデータベースに接続できること(): void
    {
        $expectedDatabaseName = 'laraveltest';
        $actualDatabaseName = DB::connection()->getDatabaseName();

        $this->assertEquals($expectedDatabaseName, $actualDatabaseName);
    }
}
