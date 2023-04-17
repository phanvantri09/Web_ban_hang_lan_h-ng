<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class order extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) {
            DB::table('info_order')->insert([
                'id_user' => 1,
                'id_cart' => $i.','.$i+10,
                'name' => 'name-'.Str::random(10),
                'numberphone' => 'numberphone-'.Str::random(5),
                'address' => 'address-'.Str::random(5),
                'description'=>'description-'.Str::random(30),
                'email' => Str::random(10).'@gmail.com',
                'total' => 1000*$i,
                'status'=> 1, // 1 vừa tạo, 2 đã xác nhận, 3 đã giao
            ]);
        }

    }
}
