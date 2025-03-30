<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $cities = [
            'London', 'Birmingham', 'Manchester', 'Liverpool', 'Leeds', 'Newcastle upon Tyne',
            'Sheffield', 'Bristol', 'Nottingham', 'Leicester', 'Coventry', 'Sunderland',
            'Southampton', 'Portsmouth', 'Brighton and Hove', 'Kingston upon Hull', 'Plymouth',
            'Wolverhampton', 'Derby', 'Stoke-on-Trent', 'Norwich', 'Reading', 'Milton Keynes',
            'Northampton', 'Oxford', 'Cambridge', 'York', 'Gloucester', 'Worcester', 'Bath',
            'Exeter', 'Lancaster', 'Durham', 'Carlisle', 'Chester', 'Canterbury', 'Ipswich',
            'Preston', 'Blackburn', 'Bolton', 'Stockport', 'Huddersfield', 'Wigan', 'Luton',
            'Watford', 'Swindon', 'Bournemouth', 'Poole', 'Blackpool', 'Southend-on-Sea'
        ];

        foreach ($cities as $city) {
            DB::table('countries')->insert([
                'name' => $city
            ]);
        }
    }
}
