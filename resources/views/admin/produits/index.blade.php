{{-- Liste paginée et indicateurs du catalogue administrateur. --}}
@extends('layouts.boutique')

@section('titre', 'Gérer les produits — Mini-Boutique')

@section('contenu')
    <div class="page-shell">
        <div class="admin-head">
            <div><span class="eyebrow" style="color:var(--green)">Gestion du catalogue</span><h1>Produits</h1><p style="margin:5px 0;color:var(--muted)">Créer, modifier et supprimer les articles de la boutique.</p></div>
            <div class="form-actions">
                <a class="button secondary" href="{{ route('admin.dashboard') }}">Vue d’ensemble</a>
                <a class="button" href="{{ route('admin.produits.create') }}">＋ Ajouter un produit</a>
            </div>
        </div>

        <div class="metric-grid">
            <div class="metric"><strong>{{ $statistiques['produits'] }}</strong><span>Produits</span></div>
            <div class="metric"><strong>{{ $statistiques['disponibles'] }}</strong><span>Disponibles</span></div>
            <div class="metric"><strong>{{ $statistiques['ruptures'] }}</strong><span>En rupture</span></div>
            <div class="metric"><strong>{{ $statistiques['categories'] }}</strong><span>Catégories</span></div>
        </div>

        @if (session('succes'))
            <div class="notice">{{ session('succes') }}</div>
        @endif

        <div class="admin-table-wrap">
            <table class="admin">
                <thead><tr><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($produits as $produit)
                        <tr>
                            <td><strong>{{ $produit->nom }}</strong></td>
                            <td>{{ $produit->categorie->nom }}</td>
                            <td>{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</td>
                            <td><span class="stock {{ $produit->stock === 0 ? 'out' : '' }}">{{ $produit->stock }}</span></td>
                            <td style="white-space:nowrap">
                                <a class="btn-small" href="{{ route('admin.produits.edit', $produit) }}">Modifier</a>
                                <form method="POST" action="{{ route('admin.produits.destroy', $produit) }}" style="display:inline" onsubmit="return confirm('Supprimer définitivement ce produit ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-small danger" type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Aucun produit dans le catalogue.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">{{ $produits->links() }}</div>
    </div>
@endsection
