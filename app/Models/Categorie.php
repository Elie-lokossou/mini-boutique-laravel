<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Chapitre 6 — Eloquent.
// La classe « Categorie » représente la table « categories ».
class Categorie extends Model
{
    use HasFactory;

    /**
     * Seul le nom peut être rempli en masse.
     */
    protected $fillable = [
        'nom',
    ];

    /**
     * Relation inverse de Produit::categorie() :
     * une catégorie POSSÈDE PLUSIEURS produits.
     * Ensuite, on écrit simplement : $categorie->produits
     */
    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class);
    }
}
