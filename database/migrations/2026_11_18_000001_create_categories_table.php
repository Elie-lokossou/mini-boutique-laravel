<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Chapitre 5 — Migrations.
// Cette migration crée la table « categories ».
// Elle passe AVANT celle des produits : la table produits aura besoin
// de pointer vers les catégories (clé étrangère categorie_id).
return new class extends Migration
{
    /**
     * up() = construire.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                    // clé primaire auto-incrémentée
            $table->string('nom');           // Ex. : Téléphones, Accessoires, Audio
            $table->timestamps();            // created_at + updated_at, automatiques
        });
    }

    /**
     * down() = défaire (utilisé par migrate:rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
