<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function モデルが作成できること(): void
    {
        $model = Address::factory()->create();
        $this->assertDatabaseHas($model->getTable(), [
            'id' => $model->id,
        ]);
    }
}
