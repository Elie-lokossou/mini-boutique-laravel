<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Chapitre 5 — Migrations : faire ÉVOLUER une table existante.
// La boutique démarre sans stock, puis le besoin arrive : on n'écrase pas
// la table, on écrit une NOUVELLE migration qui ajoute la colonne « stock »
// à la table « produits » déjà créée. C'est exactement le geste à retenir :
// une modification de la base = une nouvelle migration, jamais un bricolage
// à la main dans phpMyAdmin.
//
// Commande qui génère ce fichier :
//   php artisan make:migration add_stock_to_produits_table
return new class extends Migration
{
    /**
     * up() = ajouter la colonne.
     * Entier, 0 par défaut : les produits déjà présents passent à 0.
     */
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->integer('stock')->default(0);
        });
    }

    /**
     * down() = retirer la colonne (migrate:rollback revient en arrière).
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};
