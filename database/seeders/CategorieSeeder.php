<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

// Chapitre 10 — Seeders.
// Un seeder est une recette qui remplit la base avec des données
// d'exemple. Celui-ci crée les 5 catégories de la boutique.
// L'ORDRE COMPTE : Téléphones reçoit l'id 1, Accessoires l'id 2, etc. —
// ce sont ces ids que le catalogue de ProduitFactory utilise.
//
// Commande qui génère ce fichier : php artisan make:seeder CategorieSeeder
class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categorie::create(['nom' => 'Téléphones']);          // id 1
        Categorie::create(['nom' => 'Accessoires']);         // id 2
        Categorie::create(['nom' => 'Audio']);               // id 3
        Categorie::create(['nom' => 'Ordinateurs']);         // id 4
        Categorie::create(['nom' => 'Montres connectées']);  // id 5
    }
}
