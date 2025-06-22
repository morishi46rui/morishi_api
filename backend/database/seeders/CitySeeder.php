<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        City::updateOrCreate(
            ['code' => 28101],
            ['name' => '神戸市東灘区', 'prefecture_id' => 1]
        );
    }
}
