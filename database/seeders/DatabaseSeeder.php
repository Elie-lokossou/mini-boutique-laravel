<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Chapitre 10 — Seeders : le chef d'orchestre.
// DatabaseSeeder ne remplit rien lui-même : il déclare l'ORDRE dans
// lequel les autres seeders doivent jouer.
//   1. L'admin (pour l'espace protégé du chapitre 9)
//   2. Les catégories (les produits en ont besoin : clé étrangère)
//   3. Les produits (fabriqués par ProduitFactory)
//
// Lancé par : php artisan db:seed
// ou, le jour J : php artisan migrate:fresh --seed
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorieSeeder::class,
            ProduitSeeder::class,
        ]);
    }
}
