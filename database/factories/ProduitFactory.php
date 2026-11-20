<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Chapitre 10 — Artisan et données de démonstration.
 *
 * Une « factory » est une usine à objets : elle sait fabriquer des
 * produits d'exemple réalistes. Ici, au lieu de noms inventés au hasard,
 * on pioche dans un vrai petit catalogue (en français, prix en FCFA),
 * sans jamais prendre deux fois le même article : la boutique de démo
 * contient donc 20 produits différents, comme une vraie boutique.
 *
 * Commande qui génère ce fichier :
 *   php artisan make:factory ProduitFactory --model=Produit
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Le catalogue d'exemple.
     * categorie_id correspond à l'ordre de création des catégories
     * dans CategorieSeeder : 1 Téléphones, 2 Accessoires, 3 Audio,
     * 4 Ordinateurs, 5 Montres connectées.
     */
    private const CATALOGUE = [
        // --- Téléphones (catégorie 1) ---
        ['nom' => 'Smartphone Galaxy A15',      'description' => 'Écran 6,5 pouces, 128 Go de stockage',        'prix' => 85000,  'categorie_id' => 1],
        ['nom' => 'Smartphone Redmi Note 13',   'description' => 'Appareil photo 108 MP, batterie 5 000 mAh',     'prix' => 95000,  'categorie_id' => 1],
        ['nom' => 'iPhone 12 reconditionné',    'description' => '128 Go, Face ID, très bon état',                'prix' => 185000, 'categorie_id' => 1],
        ['nom' => 'Téléphone Tecno Spark 20',   'description' => 'Double SIM, écran 90 Hz',                       'prix' => 62000,  'categorie_id' => 1],

        // --- Accessoires (catégorie 2) ---
        ['nom' => 'Coque de protection',        'description' => 'Silicone souple, antichoc',                     'prix' => 3000,   'categorie_id' => 2],
        ['nom' => 'Chargeur rapide 25 W',       'description' => 'USB-C, charge rapide',                          'prix' => 7500,   'categorie_id' => 2],
        ['nom' => 'Câble USB-C tressé',         'description' => '1,5 m, nylon renforcé',                         'prix' => 2500,   'categorie_id' => 2],
        ['nom' => 'Verre trempé',               'description' => 'Protection d’écran 9H',                         'prix' => 2000,   'categorie_id' => 2],
        ['nom' => 'Support téléphone bureau',   'description' => 'Aluminium, angle réglable',                     'prix' => 4500,   'categorie_id' => 2],

        // --- Audio (catégorie 3) ---
        ['nom' => 'Écouteurs Bluetooth',        'description' => 'Autonomie 20 h, réduction de bruit',            'prix' => 12500,  'categorie_id' => 3],
        ['nom' => 'Casque audio Bluetooth',     'description' => 'Pliable, micro intégré',                        'prix' => 15000,  'categorie_id' => 3],
        ['nom' => 'Enceinte portable',          'description' => 'Bluetooth 5.0, étanche IPX5',                   'prix' => 18000,  'categorie_id' => 3],
        ['nom' => 'Écouteurs filaires',         'description' => 'Prise jack 3,5 mm',                             'prix' => 3500,   'categorie_id' => 3],

        // --- Ordinateurs (catégorie 4) ---
        ['nom' => 'Ordinateur portable HP 15',  'description' => 'Ryzen 5, 16 Go de RAM, SSD 512 Go',             'prix' => 385000, 'categorie_id' => 4],
        ['nom' => 'Souris sans fil',            'description' => 'Silencieuse, connexion 2,4 GHz',                'prix' => 6000,   'categorie_id' => 4],
        ['nom' => 'Clavier mécanique',          'description' => 'Rétroéclairé, touches mécaniques',              'prix' => 22000,  'categorie_id' => 4],
        ['nom' => 'Disque SSD externe 1 To',    'description' => 'USB-C, jusqu’à 1 050 Mo/s',                      'prix' => 48000,  'categorie_id' => 4],

        // --- Montres connectées (catégorie 5) ---
        ['nom' => 'Montre connectée Fit',       'description' => 'Suivi santé, appels Bluetooth',                 'prix' => 20000,  'categorie_id' => 5],
        ['nom' => 'Bracelet connecté',          'description' => 'Étanche, autonomie 14 jours',                   'prix' => 9000,   'categorie_id' => 5],
        ['nom' => 'Montre connectée Pro',       'description' => 'GPS intégré, écran AMOLED',                     'prix' => 35000,  'categorie_id' => 5],
    ];

    /**
     * L'état par défaut d'un produit fabriqué par l'usine.
     * unique() garantit qu'un même article du catalogue n'est
     * jamais tiré deux fois pendant le remplissage.
     */
    public function definition(): array
    {
        $article = $this->faker->unique()->randomElement(self::CATALOGUE);

        return [
            'nom'          => $article['nom'],
            'description'  => $article['description'],
            'prix'         => $article['prix'],
            'categorie_id' => $article['categorie_id'],
            // Un stock plausible pour la démo (parfois 0 : rupture de stock).
            'stock'        => $this->faker->numberBetween(0, 50),
        ];
    }
}
