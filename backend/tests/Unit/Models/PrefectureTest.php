<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Prefecture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PrefectureTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function モデルが作成できること(): void
    {
        $model = Prefecture::factory()->create();
        $this->assertDatabaseHas($model->getTable(), [
            'id' => $model->id,
            'code' => $model->code,
            'name' => $model->name,
        ]);
    }
}
