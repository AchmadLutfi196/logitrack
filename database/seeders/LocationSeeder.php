<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('villages')->truncate();
        DB::table('districts')->truncate();
        DB::table('cities')->truncate();
        DB::table('provinces')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $basePath = database_path('data');

        // --- 1. Seed Provinces ---
        $this->command->info('Seeding provinces...');
        $provinces = $this->readCsv($basePath . '/provinsi.csv');
        $provinceMap = []; // code => db_id
        $provinceInserts = [];
        foreach ($provinces as $row) {
            $provinceInserts[] = ['name' => $row['name']];
        }
        DB::table('provinces')->insert($provinceInserts);

        // Build map: csv code => db id
        $dbProvinces = DB::table('provinces')->select('id', 'name')->get();
        foreach ($provinces as $index => $row) {
            $dbProv = $dbProvinces->firstWhere('name', $row['name']);
            if ($dbProv) {
                $provinceMap[$row['id']] = $dbProv->id;
            }
        }
        $this->command->info('  -> ' . count($provinceMap) . ' provinces inserted.');

        // --- 2. Seed Cities ---
        $this->command->info('Seeding cities...');
        $cities = $this->readCsv($basePath . '/kabupaten_kota.csv');
        $cityMap = []; // code => db_id
        $cityChunks = [];
        $cityCodeOrder = [];

        foreach ($cities as $row) {
            $provinceCode = explode('.', $row['id'])[0]; // "11.01" -> "11"
            if (!isset($provinceMap[$provinceCode])) {
                continue;
            }
            $cityChunks[] = [
                'province_id' => $provinceMap[$provinceCode],
                'name' => $row['name'],
            ];
            $cityCodeOrder[] = $row['id'];
        }

        // Insert in chunks
        foreach (array_chunk($cityChunks, 500) as $chunk) {
            DB::table('cities')->insert($chunk);
        }

        // Build map
        $dbCities = DB::table('cities')->select('id', 'province_id', 'name')->get();
        $cityIndex = 0;
        foreach ($dbCities as $dbCity) {
            if (isset($cityCodeOrder[$cityIndex])) {
                $cityMap[$cityCodeOrder[$cityIndex]] = $dbCity->id;
            }
            $cityIndex++;
        }
        $this->command->info('  -> ' . count($cityMap) . ' cities inserted.');

        // --- 3. Seed Districts ---
        $this->command->info('Seeding districts...');
        $districts = $this->readCsv($basePath . '/kecamatan.csv');
        $districtMap = []; // code => db_id
        $districtChunks = [];
        $districtCodeOrder = [];

        foreach ($districts as $row) {
            $parts = explode('.', $row['id']);
            $cityCode = $parts[0] . '.' . $parts[1]; // "11.01.01" -> "11.01"
            if (!isset($cityMap[$cityCode])) {
                continue;
            }
            $districtChunks[] = [
                'city_id' => $cityMap[$cityCode],
                'name' => $row['name'],
            ];
            $districtCodeOrder[] = $row['id'];
        }

        foreach (array_chunk($districtChunks, 1000) as $chunk) {
            DB::table('districts')->insert($chunk);
        }

        // Build map
        $dbDistricts = DB::table('districts')->select('id')->orderBy('id')->get();
        foreach ($dbDistricts as $index => $dbDistrict) {
            if (isset($districtCodeOrder[$index])) {
                $districtMap[$districtCodeOrder[$index]] = $dbDistrict->id;
            }
        }
        $this->command->info('  -> ' . count($districtMap) . ' districts inserted.');

        // --- 4. Seed Villages ---
        $this->command->info('Seeding villages (this may take a while)...');
        $villageFile = $basePath . '/kelurahan.csv';
        $handle = fopen($villageFile, 'r');
        if ($handle === false) {
            $this->command->error('Cannot read kelurahan.csv');
            return;
        }

        // Read header
        $header = fgetcsv($handle);
        $header = array_map(fn($h) => trim($h, '" '), $header);

        $batch = [];
        $totalVillages = 0;

        while (($line = fgetcsv($handle)) !== false) {
            if (count($line) < 2) continue;

            $code = trim($line[0], '" ');
            $name = trim($line[1], '" ');

            $parts = explode('.', $code);
            if (count($parts) < 4) continue;

            $districtCode = $parts[0] . '.' . $parts[1] . '.' . $parts[2];
            if (!isset($districtMap[$districtCode])) {
                continue;
            }

            $batch[] = [
                'district_id' => $districtMap[$districtCode],
                'name' => $name,
                'postal_code' => null,
            ];

            if (count($batch) >= 2000) {
                DB::table('villages')->insert($batch);
                $totalVillages += count($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('villages')->insert($batch);
            $totalVillages += count($batch);
        }

        fclose($handle);
        $this->command->info('  -> ' . $totalVillages . ' villages inserted.');
        $this->command->info('Location seeding complete!');
    }

    private function readCsv(string $path): array
    {
        $rows = [];
        $handle = fopen($path, 'r');
        if ($handle === false) return [];

        $header = fgetcsv($handle);
        $header = array_map(fn($h) => trim($h, '" '), $header);

        while (($line = fgetcsv($handle)) !== false) {
            $row = [];
            foreach ($header as $i => $key) {
                $row[$key] = trim($line[$i] ?? '', '" ');
            }
            $rows[] = $row;
        }
        fclose($handle);
        return $rows;
    }
}
