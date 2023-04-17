<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class cart extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i=0; $i < 20; $i++) {
            DB::table('cart')->insert([
                'id_user' => 1,
                'id_product' => $i,
                'amount' => 10,
                'status'=> 1, // 1 vừa tạo, 3 đã giao
            ]);
        }

    }
}
