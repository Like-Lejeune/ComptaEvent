<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            [
                'name' => 'Admin',
                'description' => 'Accès complet à toutes les fonctionnalités.',
                'list_action' => json_encode(['create_user', 'edit_user', 'delete_user', 'view_reports']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager',
                'description' => 'Accès aux fonctionnalités de gestion des utilisateurs.',
                'list_action' => json_encode(['create_user', 'edit_user', 'view_reports']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'description' => 'Accès limité aux fonctionnalités de base.',
                'list_action' => json_encode(['view_reports']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
