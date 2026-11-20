<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Chapitre 9 (authentification) + chapitre 10 (seeders).
// Ce seeder crée le compte ADMINISTRATEUR de démonstration, pour pouvoir
// se connecter à l'espace admin le jour de la présentation.
//
// ⚠️ COMPTE DE DÉMONSTRATION UNIQUEMENT :
//    e-mail    : admin@boutique.test
//    mot de passe : password
// Le mot de passe n'est JAMAIS stocké en clair : Hash::make() le
// transforme en empreinte illisible (bcrypt) avant l'enregistrement.
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Boutique',
            'email'    => 'admin@boutique.test',
            'password' => Hash::make('password'),
        ]);
    }
}
