<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'DKI Jakarta' => [
                'Jakarta Pusat' => [
                    'Gambir' => ['Gambir', 'Kebon Kelapa', 'Petojo Selatan'],
                    'Tanah Abang' => ['Bendungan Hilir', 'Karet Tengsin', 'Kebon Melati'],
                    'Menteng' => ['Menteng', 'Pegangsaan', 'Cikini'],
                ],
                'Jakarta Selatan' => [
                    'Kebayoran Baru' => ['Senayan', 'Selong', 'Gunung'],
                    'Tebet' => ['Tebet Barat', 'Tebet Timur', 'Bukit Duri'],
                ],
                'Jakarta Barat' => [
                    'Grogol Petamburan' => ['Grogol', 'Jelambar', 'Tanjung Duren'],
                ],
                'Jakarta Timur' => [
                    'Matraman' => ['Pisangan Baru', 'Utan Kayu Selatan', 'Kayu Manis'],
                ],
                'Jakarta Utara' => [
                    'Kelapa Gading' => ['Kelapa Gading Barat', 'Kelapa Gading Timur', 'Pegangsaan Dua'],
                ],
            ],
            'Jawa Barat' => [
                'Bandung' => [
                    'Sumur Bandung' => ['Braga', 'Kebon Pisang', 'Merdeka'],
                    'Coblong' => ['Dago', 'Lebak Siliwangi', 'Cipaganti'],
                    'Lengkong' => ['Burangrang', 'Cijagra', 'Lingkar Selatan'],
                ],
                'Bekasi' => [
                    'Bekasi Barat' => ['Bintara', 'Kranji', 'Kota Baru'],
                ],
                'Depok' => [
                    'Pancoran Mas' => ['Depok', 'Depok Jaya', 'Rangkapan Jaya'],
                ],
                'Bogor' => [
                    'Bogor Tengah' => ['Panaragan', 'Gudang', 'Babakan Pasar'],
                ],
            ],
            'Jawa Tengah' => [
                'Semarang' => [
                    'Semarang Tengah' => ['Pekunden', 'Sekayu', 'Pandean Lamper'],
                ],
                'Surakarta' => [
                    'Laweyan' => ['Laweyan', 'Panularan', 'Sriwedari'],
                ],
                'Magelang' => [
                    'Magelang Tengah' => ['Kemirirejo', 'Cacaban', 'Rejowinangun Utara'],
                ],
            ],
            'Jawa Timur' => [
                'Surabaya' => [
                    'Genteng' => ['Genteng', 'Embong Kaliasin', 'Ketabang'],
                ],
                'Malang' => [
                    'Klojen' => ['Klojen', 'Rampal Celaket', 'Oro-oro Dowo'],
                ],
                'Kediri' => [
                    'Kota Kediri' => ['Mojoroto', 'Campurejo', 'Bandar Kidul'],
                ],
            ],
            'Banten' => [
                'Tangerang' => [
                    'Cipondoh' => ['Cipondoh', 'Cipondoh Indah', 'Cipondoh Makmur'],
                ],
                'Serang' => [
                    'Serang' => ['Serang', 'Cipare', 'Kota Baru'],
                ],
                'Cilegon' => [
                    'Cilegon' => ['Jombang Wetan', 'Masigit', 'Bendungan'],
                ],
            ],
        ];

        foreach ($data as $provinceName => $cities) {
            $province = Province::create(['name' => $provinceName]);
            foreach ($cities as $cityName => $districts) {
                $city = City::create(['province_id' => $province->id, 'name' => $cityName]);
                foreach ($districts as $districtName => $villages) {
                    $district = District::create(['city_id' => $city->id, 'name' => $districtName]);
                    foreach ($villages as $villageName) {
                        Village::create(['district_id' => $district->id, 'name' => $villageName]);
                    }
                }
            }
        }
    }
}
