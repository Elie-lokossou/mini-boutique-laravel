<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;

// Chapitre 10 — Seeders + factory.
// Au lieu d'écrire les 20 produits un par un, on demande à l'« usine »
// (ProduitFactory) de les fabriquer : elle pioche 20 articles différents
// dans son catalogue d'exemple. Les catégories doivent exister AVANT
// (c'est DatabaseSeeder qui garantit l'ordre).
//
// Commande qui génère ce fichier : php artisan make:seeder ProduitSeeder
class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produit::factory()
            ->count(20)   // exactement les 20 articles du catalogue
            ->create();
    }
}
