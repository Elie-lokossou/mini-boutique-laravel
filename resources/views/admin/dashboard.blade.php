{{-- Tableau de bord de présentation, protégé par le middleware auth. --}}
@extends('layouts.boutique')

@section('titre', 'Administration — Mini-Boutique')

@section('contenu')
    <div class="page-shell">
        <div class="admin-head">
            <div><span class="eyebrow" style="color:var(--green)">Espace sécurisé</span><h1>Vue d’ensemble</h1><p style="margin:5px 0;color:var(--muted)">Les indicateurs du catalogue sont calculés depuis la base Laravel.</p></div>
            <a class="button" href="{{ route('admin.produits.index') }}">Gérer les produits <span aria-hidden="true">→</span></a>
        </div>

        <div class="metric-grid">
            <div class="metric"><strong>{{ $statistiques['produits'] }}</strong><span>Produits référencés</span></div>
            <div class="metric"><strong>{{ $statistiques['disponibles'] }}</strong><span>En stock</span></div>
            <div class="metric"><strong>{{ $statistiques['ruptures'] }}</strong><span>En rupture</span></div>
            <div class="metric"><strong>{{ $statistiques['categories'] }}</strong><span>Catégories</span></div>
        </div>

        <section class="panel">
            <div class="section-head">
                <div><h2 style="font-size:21px">Stocks à surveiller</h2><p>Produits avec cinq unités ou moins.</p></div>
                <a class="text-link" href="{{ route('admin.produits.index') }}">Ouvrir le catalogue admin →</a>
            </div>
            @if ($produitsEnAlerte->isEmpty())
                <p class="notice">Aucune alerte de stock pour le moment.</p>
            @else
                <div class="admin-table-wrap">
                    <table class="admin">
                        <thead><tr><th>Produit</th><th>Catégorie</th><th>Stock restant</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach ($produitsEnAlerte as $produit)
                                <tr>
                                    <td><strong>{{ $produit->nom }}</strong></td>
                                    <td>{{ $produit->categorie->nom }}</td>
                                    <td><span class="stock {{ $produit->stock === 0 ? 'out' : '' }}">{{ $produit->stock }}</span></td>
                                    <td><a class="btn-small" href="{{ route('admin.produits.edit', $produit) }}">Mettre à jour</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection
