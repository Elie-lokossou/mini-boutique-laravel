<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Chapitre 5 — Migrations.
// Cette migration crée la table « produits », le cœur de la mini-boutique.
// Remarque : la colonne « stock » n'est PAS ici — elle est ajoutée par la
// migration suivante (add_stock_to_produits_table), pour montrer comment
// on fait évoluer une table qui existe déjà. Au final, la table contient
// exactement les colonnes présentées dans l'exposé.
return new class extends Migration
{
    /**
     * up() = construire.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                    // Ex. : Écouteurs Bluetooth
            $table->text('description')->nullable();  // la description est facultative
            $table->decimal('prix', 10, 2);           // 12500.00 — jamais de float pour l'argent
            $table->string('image')->nullable();      // chemin d'une image, facultatif

            // Clé étrangère : chaque produit appartient à une catégorie.
            $table->foreignId('categorie_id')
                  ->constrained()          // = clé vers la table « categories »
                  ->onDelete('cascade');   // supprimer la catégorie supprime ses produits

            $table->timestamps();
        });
    }

    /**
     * down() = défaire.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
