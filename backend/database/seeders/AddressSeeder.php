<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Address;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/28_2023.csv');
        $rows = array_slice(array_map('str_getcsv', file($file)), 1, 210); // ヘッダー除去 + 東灘区のみ

        DB::transaction(function () use ($rows) {

            foreach ($rows as $row) {
                $row = array_map(fn ($value) => mb_convert_encoding($value, 'UTF-8', 'SJIS-win'), $row);
                $cityCode = $row[2];
                $addressCode = $row[4];
                $addressName = $row[5];
                $lat = $row[6];
                $lng = $row[7];

                $city = City::where('code', $cityCode)->first();

                if ($city) {
                    Address::updateOrCreate(
                        ['code' => $addressCode],
                        [
                            'name' => $addressName,
                            'latitude' => $lat,
                            'longitude' => $lng,
                            'city_id' => $city->id,
                        ]
                    );
                }
            }
        });
    }
}
