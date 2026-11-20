<?php

use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Les routes : le plan des adresses de la boutique (chapitre 2).
// Les deux pages publiques du catalogue :

Route::get('/', [ProduitController::class, 'index'])
    ->name('produits.index');                    // la liste des produits

Route::get('/produits/{produit}', [ProduitController::class, 'show'])
    ->name('produits.show');                     // le détail d'un produit

// ---------------------------------------------------------------------
// Chapitre 9 — l'espace admin protégé par le middleware « auth »
// (installé avec Breeze). Un visiteur non connecté qui essaie d'ouvrir
// une de ces adresses est renvoyé automatiquement vers /login.
// C'est ici que vit le CRUD complet du chapitre 8.

Route::middleware('auth')->group(function () {
    // Le tableau de bord Breeze et le profil de l'utilisateur connecté.
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Administration des produits (chapitre 8 — CRUD complet).
    Route::get('/admin/produits', [ProduitController::class, 'indexAdmin'])
        ->name('admin.produits.index');
    Route::get('/admin/produits/create', [ProduitController::class, 'create'])
        ->name('admin.produits.create');
    Route::post('/admin/produits', [ProduitController::class, 'store'])
        ->name('admin.produits.store');
    Route::get('/admin/produits/{produit}/edit', [ProduitController::class, 'edit'])
        ->name('admin.produits.edit');
    Route::put('/admin/produits/{produit}', [ProduitController::class, 'update'])
        ->name('admin.produits.update');
    Route::delete('/admin/produits/{produit}', [ProduitController::class, 'destroy'])
        ->name('admin.produits.destroy');
});

// Les routes de connexion / inscription fournies par Breeze
// (/login, /register, /logout, ...).
require __DIR__.'/auth.php';
