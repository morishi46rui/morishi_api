<?php

declare(strict_types=1);

namespace Tests\Feature\HTTP\Controllers\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    #[Test]
    public function upload_ステータスコード200がレスポンスされること(): void
    {
        // TODO: テスト実装
    }
}
