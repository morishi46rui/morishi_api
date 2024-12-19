<?php

declare(strict_types=1);

namespace Tests\Feature\HTTP\Controllers\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Spectator\Spectator;
use Tests\TestCase;

class SampleControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function レスポンス200が返ること(): void
    {
        Spectator::using('api-docs.json');
        $this->getJson('/api/v1/sample')
            ->assertValidRequest()
            ->assertValidResponse(200);
    }
}
