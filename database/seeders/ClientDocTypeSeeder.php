<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientDocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('client_doc_types')->insert([
            ["name"=>"DNI","digit_amount"=>8],
            ["name"=>"RUC","digit_amount"=>11],
            ["name"=>"Carné de extranjería","digit_amount"=>20]
        ]);
    }
}
