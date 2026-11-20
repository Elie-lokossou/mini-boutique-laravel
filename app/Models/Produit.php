<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Chapitre 6 — Eloquent.
// Un modèle = une table. La classe « Produit » représente la table
// « produits » (Laravel devine le nom : modèle au singulier, table au
// pluriel). Chaque objet Produit en PHP EST une ligne de la table.
class Produit extends Model
{
    // Permet d'utiliser Produit::factory() (voir ProduitFactory, chapitre 10).
    use HasFactory;

    /**
     * Les champs qu'on a le droit de remplir « en masse »
     * (Produit::create([...]), formulaires…).
     * C'est une protection : tout champ absent d'ici ne pourra pas être
     * écrit par un formulaire, même malveillant.
     */
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'stock',
        'image',
        'categorie_id',
    ];

    /**
     * Conversions automatiques de types.
     * « prix » est lu comme un nombre décimal à 2 chiffres après la
     * virgule — cohérent avec la colonne decimal(10,2) de la migration.
     */
    protected $casts = [
        'prix' => 'decimal:2',
    ];

    /**
     * Relation : un produit APPARTIENT À une catégorie.
     * Ensuite, on écrit simplement : $produit->categorie->nom
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
