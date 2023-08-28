<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['id' => Str::ulid(), 'key' => 'app_name', 'value' => 'Tabungan App', 'type' => 'text'],
        ];

        Setting::insert($settings);

        Customer::create([
            'code' => '001',
            'name' => 'Tono',
            'class' => '001',
            'dob' => now()->subYears(19),
            'address' => 'Alamat Lengkap',
        ]);
    }
}
