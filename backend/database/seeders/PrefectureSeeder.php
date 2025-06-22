<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Prefecture;
use Illuminate\Database\Seeder;

class PrefectureSeeder extends Seeder
{
    public function run(): void
    {
        Prefecture::updateOrCreate(
            ['code' => 28],
            ['name' => '兵庫県']
        );
    }
}
