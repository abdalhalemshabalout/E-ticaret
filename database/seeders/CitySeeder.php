<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            0 => [
                'country_id' => 1,
                'id' => 1,
                'city' => 'Adana',
            ],
            1 => [
                'country_id' => 1,
                'id' => 2,
                'city' => 'Adıyaman',
            ],
            2 => [
                'country_id' => 1,
                'id' => 3,
                'city' => 'Afyonkarahisar',
            ],
            3 => [
                'country_id' => 1,
                'id' => 4,
                'city' => 'Ağrı',
            ],
            4 => [
                'country_id' => 1,
                'id' => 5,
                'city' => 'Amasya',
            ],
            5 => [
                'country_id' => 1,
                'id' => 6,
                'city' => 'Ankara',
            ],
            6 => [
                'country_id' => 1,
                'id' => 7,
                'city' => 'Antalya',
            ],
            7 => [
                'country_id' => 1,
                'id' => 8,
                'city' => 'Artvin',
            ],
            8 => [
                'country_id' => 1,
                'id' => 9,
                'city' => 'Aydın',
            ],
            9 => [
                'country_id' => 1,
                'id' => 10,
                'city' => 'Balıkesir',
            ],
            10 => [
                'country_id' => 1,
                'id' => 11,
                'city' => 'Bilecik',
            ],
            11 => [
                'country_id' => 1,
                'id' => 12,
                'city' => 'Bingöl',
            ],
            12 => [
                'country_id' => 1,
                'id' => 13,
                'city' => 'Bitlis',
            ],
            13 => [
                'country_id' => 1,
                'id' => 14,
                'city' => 'Bolu',
            ],
            14 => [
                'country_id' => 1,
                'id' => 15,
                'city' => 'Burdur',
            ],
            15 => [
                'country_id' => 1,
                'id' => 16,
                'city' => 'Bursa',
            ],
            16 => [
                'country_id' => 1,
                'id' => 17,
                'city' => 'Çanakkale',
            ],
            17 => [
                'country_id' => 1,
                'id' => 18,
                'city' => 'Çankırı',
            ],
            18 => [
                'country_id' => 1,
                'id' => 19,
                'city' => 'Çorum',
            ],
            19 => [
                'country_id' => 1,
                'id' => 20,
                'city' => 'Denizli',
            ],
            20 => [
                'country_id' => 1,
                'id' => 21,
                'city' => 'Diyarbakır',
            ],
            21 => [
                'country_id' => 1,
                'id' => 22,
                'city' => 'Edirne',
            ],
            22 => [
                'country_id' => 1,
                'id' => 23,
                'city' => 'Elazığ',
            ],
            23 => [
                'country_id' => 1,
                'id' => 24,
                'city' => 'Erzincan',
            ],
            24 => [
                'country_id' => 1,
                'id' => 25,
                'city' => 'Erzurum',
            ],
            25 => [
                'country_id' => 1,
                'id' => 26,
                'city' => 'Eskişehir',
            ],
            26 => [
                'country_id' => 1,
                'id' => 27,
                'city' => 'Gaziantep',
            ],
            27 => [
                'country_id' => 1,
                'id' => 28,
                'city' => 'Giresun',
            ],
            28 => [
                'country_id' => 1,
                'id' => 29,
                'city' => 'Gümüşhane',
            ],
            29 => [
                'country_id' => 1,
                'id' => 30,
                'city' => 'Hakkari',
            ],
            30 => [
                'country_id' => 1,
                'id' => 31,
                'city' => 'Hatay',
            ],
            31 => [
                'country_id' => 1,
                'id' => 32,
                'city' => 'Isparta',
            ],
            32 => [
                'country_id' => 1,
                'id' => 33,
                'city' => 'Mersin',
            ],
            33 => [
                'country_id' => 1,
                'id' => 34,
                'city' => 'İstanbul',
            ],
            34 => [
                'country_id' => 1,
                'id' => 35,
                'city' => 'İzmir',
            ],
            35 => [
                'country_id' => 1,
                'id' => 36,
                'city' => 'Kars',
            ],
            36 => [
                'country_id' => 1,
                'id' => 37,
                'city' => 'Kastamonu',
            ],
            37 => [
                'country_id' => 1,
                'id' => 38,
                'city' => 'Kayseri',
            ],
            38 => [
                'country_id' => 1,
                'id' => 39,
                'city' => 'Kırklareli',
            ],
            39 => [
                'country_id' => 1,
                'id' => 40,
                'city' => 'Kırşehir',
            ],
            40 => [
                'country_id' => 1,
                'id' => 41,
                'city' => 'Kocaeli',
            ],
            41 => [
                'country_id' => 1,
                'id' => 42,
                'city' => 'Konya',
            ],
            42 => [
                'country_id' => 1,
                'id' => 43,
                'city' => 'Kütahya',
            ],
            43 => [
                'country_id' => 1,
                'id' => 44,
                'city' => 'Malatya',
            ],
            44 => [
                'country_id' => 1,
                'id' => 45,
                'city' => 'Manisa',
            ],
            45 => [
                'country_id' => 1,
                'id' => 46,
                'city' => 'Kahramanmaraş',
            ],
            46 => [
                'country_id' => 1,
                'id' => 47,
                'city' => 'Mardin',
            ],
            47 => [
                'country_id' => 1,
                'id' => 48,
                'city' => 'Muğla',
            ],
            48 => [
                'country_id' => 1,
                'id' => 49,
                'city' => 'Muş',
            ],
            49 => [
                'country_id' => 1,
                'id' => 50,
                'city' => 'Nevşehir',
            ],
            50 => [
                'country_id' => 1,
                'id' => 51,
                'city' => 'Niğde',
            ],
            51 => [
                'country_id' => 1,
                'id' => 52,
                'city' => 'Ordu',
            ],
            52 => [
                'country_id' => 1,
                'id' => 53,
                'city' => 'Rize',
            ],
            53 => [
                'country_id' => 1,
                'id' => 54,
                'city' => 'Sakarya',
            ],
            54 => [
                'country_id' => 1,
                'id' => 55,
                'city' => 'Samsun',
            ],
            55 => [
                'country_id' => 1,
                'id' => 56,
                'city' => 'Siirt',
            ],
            56 => [
                'country_id' => 1,
                'id' => 57,
                'city' => 'Sinop',
            ],
            57 => [
                'country_id' => 1,
                'id' => 58,
                'city' => 'Sivas',
            ],
            58 => [
                'country_id' => 1,
                'id' => 59,
                'city' => 'Tekirdağ',
            ],
            59 => [
                'country_id' => 1,
                'id' => 60,
                'city' => 'Tokat',
            ],
            60 => [
                'country_id' => 1,
                'id' => 61,
                'city' => 'Trabzon',
            ],
            61 => [
                'country_id' => 1,
                'id' => 62,
                'city' => 'Tunceli',
            ],
            62 => [
                'country_id' => 1,
                'id' => 63,
                'city' => 'Şanlıurfa',
            ],
            63 => [
                'country_id' => 1,
                'id' => 64,
                'city' => 'Uşak',
            ],
            64 => [
                'country_id' => 1,
                'id' => 65,
                'city' => 'Van',
            ],
            65 => [
                'country_id' => 1,
                'id' => 66,
                'city' => 'Yozgat',
            ],
            66 => [
                'country_id' => 1,
                'id' => 67,
                'city' => 'Zonguldak',
            ],
            67 => [
                'country_id' => 1,
                'id' => 68,
                'city' => 'Aksaray',
            ],
            68 => [
                'country_id' => 1,
                'id' => 69,
                'city' => 'Bayburt',
            ],
            69 => [
                'country_id' => 1,
                'id' => 70,
                'city' => 'Karaman',
            ],
            70 => [
                'country_id' => 1,
                'id' => 71,
                'city' => 'Kırıkkale',
            ],
            71 => [
                'country_id' => 1,
                'id' => 72,
                'city' => 'Batman',
            ],
            72 => [
                'country_id' => 1,
                'id' => 73,
                'city' => 'Şırnak',
            ],
            73 => [
                'country_id' => 1,
                'id' => 74,
                'city' => 'Bartın',
            ],
            74 => [
                'country_id' => 1,
                'id' => 75,
                'city' => 'Ardahan',
            ],
            75 => [
                'country_id' => 1,
                'id' => 76,
                'city' => 'Iğdır',
            ],
            76 => [
                'country_id' => 1,
                'id' => 77,
                'city' => 'Yalova',
            ],
            77 => [
                'country_id' => 1,
                'id' => 78,
                'city' => 'Karabük',
            ],
            78 => [
                'country_id' => 1,
                'id' => 79,
                'city' => 'Kilis',
            ],
            79 => [
                'country_id' => 1,
                'id' => 80,
                'city' => 'Osmaniye',
            ],
            80 => [
                'country_id' => 1,
                'id' => 81,
                'city' => 'Düzce',
            ],
        ]);
    }
}
