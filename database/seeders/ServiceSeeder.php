<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            [
                's_name' => 'COMPTABILITE',
                's_description' => '',
                's_budget' => '5000000',
                's_solde' => '5000000',
                's_photo' => 'COMPTABILITE.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
        ]);

        DB::table('services')->insert([
            [
                's_name' => 'ACCUEIL',
                's_description' => '',
                's_budget' => '5000000',
                's_solde' => '5000000',
                's_photo' => 'ACCUEIL.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
           
         
        ]);

        DB::table('services')->insert([
            [
                's_name' => 'ENTRETIEN',
                's_description' => '',
                's_budget' => '5000000',
                's_solde' => '5000000',
                's_photo' => 'ENTRETIEN.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
           
         
        ]);
        DB::table('services')->insert([
            [
                's_name' => 'AUDIO VIDEO',
                's_description' => '',
                's_budget' => '5000000',
                's_solde' => '5000000',
                's_photo' => 'AV.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
           
         
        ]);
    }
}
