<?php
// database/seeders/PlanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::create([
            'nom' => 'Freemium',
            'prix_mensuel' => 0,
            'prix_annuel' => 0,
            'nb_evenements_max' => 1,
            'nb_services_max' => 5,
            'export_pdf' => false,
            'multi_users' => false,
        ]);

        Plan::create([
            'nom' => 'Premium Standard',
            'prix_mensuel' => 5000,
            'prix_annuel' => 50000,
            'nb_evenements_max' => -1,
            'nb_services_max' => -1,
            'export_pdf' => true,
            'multi_users' => false,
        ]);

        Plan::create([
            'nom' => 'Premium Pro',
            'prix_mensuel' => 15000,
            'prix_annuel' => 150000,
            'nb_evenements_max' => -1,
            'nb_services_max' => -1,
            'export_pdf' => true,
            'multi_users' => true,
        ]);
    }
}

