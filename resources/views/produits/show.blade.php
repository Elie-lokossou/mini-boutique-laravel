{{-- Page détail : un seul produit.
     La variable $produit vient de ProduitController@show,
     retrouvée automatiquement grâce à l'id dans l'adresse. --}}
@extends('layouts.boutique')

@section('titre', $produit->nom . ' — Mini-Boutique')

@section('contenu')
    <a class="lien" href="{{ route('produits.index') }}">← Retour au catalogue</a>

    <div class="detail" style="margin-top: 16px;">
        <p class="categorie">{{ $produit->categorie->nom }}</p>
        <h1>{{ $produit->nom }}</h1>

        @if ($produit->description)
            <p>{{ $produit->description }}</p>
        @endif

        <p class="prix">{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</p>

        @if ($produit->stock > 0)
            <span class="badge">En stock : {{ $produit->stock }} exemplaire(s)</span>
        @else
            <span class="badge rupture">Rupture de stock</span>
        @endif
    </div>
@endsection
