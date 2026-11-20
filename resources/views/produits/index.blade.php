{{-- Page d'accueil : la liste des produits du catalogue.
     Les données viennent de ProduitController@index :
     la variable $produits contient tous les produits, avec leur
     catégorie déjà chargée (relation Eloquent du chapitre 6). --}}
@extends('layouts.boutique')

@section('titre', 'Nos produits — Mini-Boutique')

@section('contenu')
    <h1>Nos produits</h1>

    @if ($produits->isEmpty())
        {{-- Aucun produit : la base est probablement vide. --}}
        <div class="vide">
            <p>La boutique est vide pour le moment.</p>
            <p>Remplis-la en une commande : <code>php artisan migrate:fresh --seed</code></p>
        </div>
    @else
        <div class="grille">
            @foreach ($produits as $produit)
                <article class="carte">
                    {{-- $produit->categorie : la relation belongsTo en action --}}
                    <p class="categorie">{{ $produit->categorie->nom }}</p>
                    <h2>{{ $produit->nom }}</h2>

                    {{-- Prix formaté à la française : 12 500 FCFA --}}
                    <p class="prix">{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</p>

                    @if ($produit->stock > 0)
                        <span class="badge">En stock : {{ $produit->stock }}</span>
                    @else
                        <span class="badge rupture">Rupture de stock</span>
                    @endif

                    <br>
                    <a class="lien" href="{{ route('produits.show', $produit) }}">Voir le détail →</a>
                </article>
            @endforeach
        </div>
    @endif
@endsection
