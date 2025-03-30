<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientDocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('client_doc_type')->insert([
            ["name"=>"DNI"],
            ["name"=>"RUC"],
            ["name"=>"Carné de extranjería"]
        ]);
    }
}
