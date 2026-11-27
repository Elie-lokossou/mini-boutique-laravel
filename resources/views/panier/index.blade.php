{{-- Panier stocké en session : aucune dépendance JavaScript nécessaire. --}}
@extends('layouts.boutique')

@section('titre', 'Mon panier — Mini-Boutique')

@section('contenu')
    <div class="page-shell">
        <div class="section-head">
            <div><span class="eyebrow" style="color:var(--green)">Votre sélection</span><h2>Mon panier</h2><p>Les articles restent dans la session pendant votre visite.</p></div>
            <a class="text-link" href="{{ route('produits.index') }}">Continuer mes achats →</a>
        </div>

        @if (session('succes'))
            <div class="notice">{{ session('succes') }}</div>
        @endif
        @if ($errors->has('panier'))
            <div class="notice error">{{ $errors->first('panier') }}</div>
        @endif

        @if ($articles->isEmpty())
            <div class="empty-state">
                <strong>Ton panier est encore vide</strong>
                <p>Parcours le catalogue et ajoute les produits qui t’intéressent.</p>
                <a class="button" href="{{ route('produits.index') }}">Découvrir le catalogue</a>
            </div>
        @else
            <div class="panel" style="padding:8px 18px">
                <div class="admin-table-wrap" style="border:0">
                    <table class="cart-table">
                        <thead><tr><th>Produit</th><th>Prix unitaire</th><th>Quantité</th><th>Sous-total</th><th></th></tr></thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <td><strong>{{ $article['produit']->nom }}</strong><br><span style="color:var(--muted);font-size:11px">{{ $article['produit']->categorie->nom }}</span></td>
                                    <td>{{ number_format((float) $article['produit']->prix, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <form method="POST" action="{{ route('panier.modifier', $article['produit']) }}" style="display:flex;gap:6px;align-items:center">
                                            @csrf @method('PATCH')
                                            <input type="number" name="quantite" value="{{ $article['quantite'] }}" min="1" max="{{ $article['produit']->stock }}" aria-label="Quantité de {{ $article['produit']->nom }}">
                                            <button class="btn-small" type="submit">OK</button>
                                        </form>
                                    </td>
                                    <td><strong>{{ number_format($article['total'], 0, ',', ' ') }} FCFA</strong></td>
                                    <td>
                                        <form method="POST" action="{{ route('panier.supprimer', $article['produit']) }}">
                                            @csrf @method('DELETE')
                                            <button class="btn-small danger" type="submit">Retirer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="cart-summary">
                <p class="cart-total"><span>Total estimé</span><span>{{ number_format($total, 0, ',', ' ') }} FCFA</span></p>
                <form method="POST" action="{{ route('panier.commander') }}">
                    @csrf
                    <button class="button" type="submit" style="width:100%">Valider la commande démo</button>
                </form>
                <p style="margin:10px 0 0;color:var(--muted);font-size:10px">Aucun paiement n’est effectué. La commande est simulée pour la présentation.</p>
            </div>
        @endif
    </div>
@endsection
