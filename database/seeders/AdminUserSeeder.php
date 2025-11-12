<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer l'ID du profil Administrateur
        $adminProfile = DB::table('profiles')->where('name', 'Administrateur')->first();

        if ($adminProfile) {
            // Créer un utilisateur admin par défaut
            DB::table('users')->updateOrInsert(
                ['email' => 'admin@comptaevent.com'],
                [
                    'name' => 'Administrateur',
                    'email' => 'admin@comptaevent.com',
                    'password' => Hash::make('Admin@2025'),
                    'matricule' => 'ADM001',
                    'type' => 'admin',
                    'status' => 1,
                    'profil_id' => $adminProfile->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
