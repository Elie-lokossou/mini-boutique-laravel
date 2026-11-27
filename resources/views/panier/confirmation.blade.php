{{-- Confirmation pédagogique : le panier est vidé, sans débit ni persistance. --}}
@extends('layouts.boutique')

@section('titre', 'Commande simulée — Mini-Boutique')

@section('contenu')
    <div class="page-shell">
        <section class="empty-state" style="max-width:700px;margin:28px auto;padding:42px">
            <div style="font-size:52px" aria-hidden="true">✓</div>
            <span class="eyebrow" style="color:var(--green)">Démonstration Laravel</span>
            <h1 style="font-size:34px;margin:5px 0">Commande simulée</h1>
            <p>Le parcours de validation fonctionne. Aucun paiement n’a été effectué et aucune commande n’a été enregistrée en base.</p>
            <p><strong>Référence : {{ $commande['reference'] }}</strong></p>
            <div class="admin-table-wrap" style="margin:20px 0">
                <table class="cart-table">
                    <thead><tr><th>Produit</th><th>Quantité</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach ($commande['articles'] as $article)
                            <tr><td>{{ $article['nom'] }}</td><td>{{ $article['quantite'] }}</td><td>{{ number_format($article['total'], 0, ',', ' ') }} FCFA</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="cart-total"><span>Total simulé</span><span>{{ number_format($commande['total'], 0, ',', ' ') }} FCFA</span></p>
            <a class="button" href="{{ route('produits.index') }}">Retour à la boutique</a>
        </section>
    </div>
@endsection
