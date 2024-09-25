<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        DB::table('vouchers')->insert([
            [
                'code' => 'DISKON10',
                'discount' => 10,
                'expiration_date' => '2024-10-23 04:21:38', // Change valid_until to expiration_date
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more vouchers if needed
        ]);
    }
}
