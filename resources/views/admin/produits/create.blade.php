{{-- CREATE : le formulaire d'ajout d'un produit (chapitre 8).
     Le formulaire envoie une requête POST vers admin.produits.store.
     @csrf ajoute le jeton de sécurité obligatoire (chapitre 7). --}}
@extends('layouts.boutique')

@section('titre', 'Ajouter un produit — Mini-Boutique')

@section('contenu')
    <a class="lien" href="{{ route('admin.produits.index') }}">← Retour à la liste admin</a>
    <h1 style="margin-top:12px;">Ajouter un produit</h1>

    <form method="POST" action="{{ route('admin.produits.store') }}">
        @csrf
        @include('admin.produits._form', ['bouton' => 'Ajouter le produit'])
    </form>
@endsection
