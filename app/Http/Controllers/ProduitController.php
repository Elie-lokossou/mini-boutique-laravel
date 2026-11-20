<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Le contrôleur fait le lien entre les routes (les adresses) et les
// vues (les pages). Il reçoit la demande, interroge les modèles
// Eloquent (chapitre 6) et renvoie la bonne page.
class ProduitController extends Controller
{
    /**
     * Page d'accueil : le catalogue public de la boutique.
     *
     * with('categorie') charge les catégories EN MÊME TEMPS que les
     * produits : sans lui, afficher 20 produits lancerait 21 requêtes
     * (le problème « N+1 » du chapitre 6). Avec lui : 2 requêtes.
     */
    public function index(): View
    {
        $produits = Produit::with('categorie')
            ->orderBy('nom')
            ->get();

        return view('produits.index', compact('produits'));
    }

    /**
     * Page détail d'un seul produit.
     *
     * « Produit $produit » : Laravel retrouve tout seul le produit
     * dont l'id est dans l'adresse (/produits/3 → le produit nº 3).
     * C'est le « route model binding ». Si l'id n'existe pas,
     * Laravel affiche une erreur 404 automatiquement.
     */
    public function show(Produit $produit): View
    {
        $produit->load('categorie');

        return view('produits.show', compact('produit'));
    }

    // =================================================================
    // Espace admin (protégé par le middleware « auth », chapitre 9).
    // C'est le CRUD complet du chapitre 8 : Create, Read, Update, Delete.
    // =================================================================

    /**
     * READ (version admin) : la liste des produits, avec les boutons
     * pour créer, modifier et supprimer.
     */
    public function indexAdmin(): View
    {
        $produits = Produit::with('categorie')
            ->orderBy('nom')
            ->get();

        return view('admin.produits.index', compact('produits'));
    }

    /**
     * CREATE (le formulaire) : on affiche un formulaire vide.
     * Les catégories sont envoyées à la vue pour remplir la liste
     * déroulante (chaque produit appartient à une catégorie).
     */
    public function create(): View
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.produits.create', compact('categories'));
    }

    /**
     * CREATE (l'enregistrement) : on reçoit le formulaire envoyé.
     *
     * Chapitre 7 — la validation passe AVANT tout le reste :
     * $request->validate() vérifie chaque champ. Si un champ est
     * invalide, Laravel renvoie automatiquement l'utilisateur sur le
     * formulaire, avec les messages d'erreur et les anciennes valeurs
     * (old()). Si tout est bon, on crée le produit en une ligne grâce
     * au « mass assignment » protégé par $fillable (chapitre 6).
     */
    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate(...$this->reglesValidation());

        Produit::create($donnees);

        return redirect()
            ->route('admin.produits.index')
            ->with('succes', 'Produit ajouté au catalogue.');
    }

    /**
     * UPDATE (le formulaire) : même formulaire que la création,
     * mais pré-rempli avec les valeurs actuelles du produit.
     */
    public function edit(Produit $produit): View
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    /**
     * UPDATE (l'enregistrement) : mêmes règles de validation que la
     * création, puis $produit->update() écrit les nouvelles valeurs.
     */
    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $donnees = $request->validate(...$this->reglesValidation());

        $produit->update($donnees);

        return redirect()
            ->route('admin.produits.index')
            ->with('succes', 'Produit modifié.');
    }

    /**
     * DELETE : on supprime le produit, puis on revient à la liste.
     * La vue demande une confirmation avant d'envoyer cette requête
     * (un clic accidentel ne doit pas effacer le catalogue).
     */
    public function destroy(Produit $produit): RedirectResponse
    {
        $produit->delete();

        return redirect()
            ->route('admin.produits.index')
            ->with('succes', 'Produit supprimé.');
    }

    /**
     * Les règles de validation des produits (chapitre 7), partagées
     * par la création et la modification : règles, messages en
     * français et noms de champs lisibles pour l'utilisateur.
     *
     * @return array{0: array, 1: array, 2: array}
     */
    private function reglesValidation(): array
    {
        $regles = [
            'nom'          => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'prix'         => ['required', 'numeric', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'categorie_id' => ['required', 'exists:categories,id'],
        ];

        $messages = [
            'required' => 'Le champ :attribute est obligatoire.',
            'numeric'  => 'Le champ :attribute doit être un nombre.',
            'integer'  => 'Le champ :attribute doit être un nombre entier.',
            'min'      => 'Le champ :attribute doit être au minimum :min.',
            'max'      => 'Le champ :attribute ne doit pas dépasser :max caractères.',
            'exists'   => 'La catégorie choisie n\'existe pas.',
        ];

        $attributs = [
            'nom'          => 'nom',
            'prix'         => 'prix',
            'stock'        => 'stock',
            'categorie_id' => 'catégorie',
        ];

        return [$regles, $messages, $attributs];
    }
}
