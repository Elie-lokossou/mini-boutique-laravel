{{-- Accueil du catalogue : recherche et filtres restent des requêtes Laravel GET. --}}
@extends('layouts.boutique')

@section('titre', 'Mini-Boutique — Catalogue en FCFA')

@section('contenu')
    @php
        $visuels = [
            'Téléphones' => 'telephones.svg',
            'Accessoires' => 'accessoires.svg',
            'Audio' => 'audio.svg',
            'Ordinateurs' => 'ordinateurs.svg',
            'Montres connectées' => 'montres.svg',
        ];
    @endphp

    <div class="page-shell">
        <section class="hero">
            <div class="hero-copy">
                <span class="eyebrow">La boutique en ligne</span>
                <h1>La technologie utile, au bon prix.</h1>
                <p>Retrouve tes accessoires, appareils et essentiels du quotidien dans un catalogue clair, avec des prix affichés en FCFA et le stock disponible.</p>
                <a class="button" href="#catalogue">Explorer le catalogue <span aria-hidden="true">→</span></a>
            </div>
            <div class="hero-showcase" aria-hidden="true">
                <div class="showcase-tile">📱</div>
                <div class="showcase-tile">🎧</div>
                <div class="showcase-tile">⌚</div>
                <div class="showcase-tile">💻</div>
            </div>
        </section>

        <section class="stats" aria-label="La boutique en chiffres">
            <div class="stat"><span class="stat-icon">▦</span><div><strong>{{ $statistiques['produits'] }}</strong><span>produits au catalogue</span></div></div>
            <div class="stat"><span class="stat-icon">◈</span><div><strong>{{ $statistiques['categories'] }}</strong><span>catégories à découvrir</span></div></div>
            <div class="stat"><span class="stat-icon">✓</span><div><strong>{{ $statistiques['disponibles'] }}</strong><span>produits disponibles</span></div></div>
        </section>

        @if ($produitMisEnAvant)
            <section class="featured" aria-label="Produit à découvrir">
                <div class="featured-visual">
                    @if ($produitMisEnAvant->image)
                        <img src="{{ asset('storage/'.$produitMisEnAvant->image) }}" alt="{{ $produitMisEnAvant->nom }}">
                    @else
                        <img src="{{ asset('images/categories/'.($visuels[$produitMisEnAvant->categorie->nom] ?? 'accessoires.svg')) }}" alt="Illustration de la catégorie {{ $produitMisEnAvant->categorie->nom }}">
                    @endif
                </div>
                <div>
                    <span class="eyebrow" style="color:var(--green)">À découvrir</span>
                    <h2>{{ $produitMisEnAvant->nom }}</h2>
                    <p>{{ $produitMisEnAvant->description ?: 'Un essentiel de notre sélection, disponible dès maintenant.' }}</p>
                    <p class="product-price">{{ number_format((float) $produitMisEnAvant->prix, 0, ',', ' ') }} FCFA</p>
                    <a class="button" href="{{ route('produits.show', $produitMisEnAvant) }}">Voir le produit <span aria-hidden="true">→</span></a>
                </div>
            </section>
        @endif

        <section id="catalogue">
            <div class="section-head">
                <div><h2>Le catalogue</h2><p>Recherche, compare et trouve ce qu’il te faut.</p></div>
                <span class="stock">Prix en FCFA</span>
            </div>

            <div class="category-list" aria-label="Filtrer par catégorie">
                <a class="category-chip {{ $categorieId === 0 ? 'active' : '' }}" href="{{ route('produits.index', request()->except('categorie', 'page')) }}">Tout voir</a>
                @foreach ($categories as $categorie)
                    <a class="category-chip {{ $categorieId === $categorie->id ? 'active' : '' }}"
                       href="{{ route('produits.index', array_merge(request()->except('page'), ['categorie' => $categorie->id])) }}">
                        {{ $categorie->nom }} <small>{{ $categorie->produits_count }}</small>
                    </a>
                @endforeach
            </div>

            <form class="filters" method="GET" action="{{ route('produits.index') }}">
                <input type="search" name="q" value="{{ $recherche }}" placeholder="Rechercher un produit…" aria-label="Rechercher un produit">
                <select name="categorie" aria-label="Catégorie">
                    <option value="">Toutes les catégories</option>
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}" @selected($categorieId === $categorie->id)>{{ $categorie->nom }}</option>
                    @endforeach
                </select>
                <select name="disponibilite" aria-label="Disponibilité">
                    <option value="">Tout le stock</option>
                    <option value="disponible" @selected($disponibilite === 'disponible')>Disponible</option>
                    <option value="rupture" @selected($disponibilite === 'rupture')>En rupture</option>
                </select>
                <select name="tri" aria-label="Ordre de tri">
                    <option value="nom" @selected($tri === 'nom')>Nom A à Z</option>
                    <option value="recent" @selected($tri === 'recent')>Plus récents</option>
                    <option value="prix_croissant" @selected($tri === 'prix_croissant')>Prix croissant</option>
                    <option value="prix_decroissant" @selected($tri === 'prix_decroissant')>Prix décroissant</option>
                </select>
                <button class="button" type="submit">Appliquer</button>
            </form>

            <div class="results-line">
                <span>{{ $produits->total() }} résultat(s)</span>
                @if ($recherche || $categorieId || $disponibilite || $tri !== 'nom')
                    <a class="text-link" href="{{ route('produits.index') }}">Réinitialiser les filtres</a>
                @endif
            </div>

            @if ($produits->isEmpty())
                <div class="empty-state">
                    <strong>Aucun produit trouvé</strong>
                    <p>Essaie une autre recherche ou enlève un filtre.</p>
                    <a class="button secondary" href="{{ route('produits.index') }}">Voir tout le catalogue</a>
                </div>
            @else
                <div class="product-grid">
                    @foreach ($produits as $produit)
                        <article class="product-card">
                            <div class="product-visual">
                                @if ($produit->image)
                                    <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}" loading="lazy">
                                @else
                                    <img src="{{ asset('images/categories/'.($visuels[$produit->categorie->nom] ?? 'accessoires.svg')) }}" alt="Illustration de la catégorie {{ $produit->categorie->nom }}" loading="lazy">
                                @endif
                                @if ($produit->stock > 0)
                                    <span class="stock stock-label">En stock</span>
                                @else
                                    <span class="stock out stock-label">Rupture</span>
                                @endif
                            </div>
                            <div class="product-info">
                                <p class="category-label">{{ $produit->categorie->nom }}</p>
                                <h3>{{ $produit->nom }}</h3>
                                <p class="product-price">{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</p>
                                <div class="product-actions">
                                    <a class="text-link" href="{{ route('produits.show', $produit) }}">Détails du produit</a>
                                    @if ($produit->stock > 0)
                                        <form method="POST" action="{{ route('panier.ajouter', $produit) }}">
                                            @csrf
                                            <button class="button" type="submit">Ajouter au panier</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="pagination-wrap">{{ $produits->links() }}</div>
            @endif
        </section>
    </div>
@endsection
