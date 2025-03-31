<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderDocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('order_doc_types')->insert([
            ["name"=>"Boleta","digit_amount"=>12],
            ["name"=>"Factura","digit_amount"=>20],
        ]);
    }
}
