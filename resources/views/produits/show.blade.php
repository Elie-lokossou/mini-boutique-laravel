{{-- Détail produit : route model binding, relation Eloquent et panier session. --}}
@extends('layouts.boutique')

@section('titre', $produit->nom.' — Mini-Boutique')

@section('contenu')
    @php
        $visuels = ['Téléphones' => 'telephones.svg', 'Accessoires' => 'accessoires.svg', 'Audio' => 'audio.svg', 'Ordinateurs' => 'ordinateurs.svg', 'Montres connectées' => 'montres.svg'];
    @endphp
    <div class="page-shell">
        <p><a class="text-link" href="{{ route('produits.index') }}">← Retour au catalogue</a></p>
        @if ($errors->has('panier'))
            <div class="notice error">{{ $errors->first('panier') }}</div>
        @endif
        <section class="detail-layout">
            <div class="detail-visual">
                @if ($produit->image)
                    <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}">
                @else
                    <img src="{{ asset('images/categories/'.($visuels[$produit->categorie->nom] ?? 'accessoires.svg')) }}" alt="Illustration de la catégorie {{ $produit->categorie->nom }}">
                @endif
            </div>
            <div class="detail-content">
                <p class="category-label">{{ $produit->categorie->nom }}</p>
                <h1>{{ $produit->nom }}</h1>
                <p class="description">{{ $produit->description ?: 'Un produit sélectionné pour répondre à tes besoins du quotidien.' }}</p>
                <p class="product-price">{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</p>
                @if ($produit->stock > 0)
                    <span class="stock">Disponible · {{ $produit->stock }} en stock</span>
                    <form class="quantity-row" method="POST" action="{{ route('panier.ajouter', $produit) }}">
                        @csrf
                        <label for="quantite">Quantité</label>
                        <input id="quantite" type="number" name="quantite" value="1" min="1" max="{{ $produit->stock }}">
                        <button class="button" type="submit">Ajouter au panier</button>
                    </form>
                @else
                    <span class="stock out">Actuellement en rupture</span>
                @endif
                <p style="color:var(--muted);font-size:12px">Prix affiché en FCFA. La validation de commande est une démonstration sans paiement.</p>
            </div>
        </section>
    </div>
@endsection
