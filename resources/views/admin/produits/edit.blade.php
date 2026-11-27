{{-- UPDATE : le formulaire de modification (chapitre 8).
     HTML ne connaît que GET et POST : @method('PUT') dit à Laravel
     de traiter cet envoi comme une requête PUT. --}}
@extends('layouts.boutique')

@section('titre', 'Modifier ' . $produit->nom . ' — Mini-Boutique')

@section('contenu')
    <a class="lien" href="{{ route('admin.produits.index') }}">← Retour à la liste admin</a>
    <h1 style="margin-top:12px;">Modifier le produit</h1>

    <form method="POST" action="{{ route('admin.produits.update', $produit) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.produits._form', ['bouton' => 'Enregistrer les modifications'])
    </form>
@endsection
