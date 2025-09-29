<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Airenti & Barabino',
                'logo' => null,
                'phone_one' => '+39.011.506.3073',
                'phone_two' => '+39.010.580.386',
                'email_one' => 'torino@airentiebarabino.com',
                'email_two' => 'genova@airentiebarabino.com',
                'address_one' => 'Corso Vittorio Emanuele II 52',
                'city_one' => 'Torino',
                'address_two' => 'Via Ceccardi 4/20',
                'city_two' => 'Genova',
                'footer_description' => 'Professional accounting and consulting services for businesses and individuals in Torino and Genova.',
            ]
        );
    }
}
