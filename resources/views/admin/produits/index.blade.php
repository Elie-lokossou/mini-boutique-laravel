{{-- READ (version admin) : la liste des produits avec les actions
     du CRUD — créer, modifier, supprimer (chapitre 8). --}}
@extends('layouts.boutique')

@section('titre', 'Admin — Produits — Mini-Boutique')

@section('contenu')
    <style>
        table.admin { width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,.08); }
        table.admin th, table.admin td { padding:10px 12px; text-align:left; font-size:14px; border-bottom:1px solid #edf0f6; }
        table.admin th { background:#0B2447; color:#fff; }
        .btn { display:inline-block; background:#0866FF; color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; }
        .btn.petit { padding:5px 10px; font-size:13px; }
        .btn.danger { background:#b3261e; }
        .succes { background:#e6f4ea; color:#137333; border-radius:8px; padding:12px 16px; margin-bottom:16px; }
    </style>

    <h1>Administration des produits</h1>

    @if (session('succes'))
        <div class="succes">{{ session('succes') }}</div>
    @endif

    <p><a class="btn" href="{{ route('admin.produits.create') }}">+ Ajouter un produit</a></p>

    <table class="admin">
        <thead>
            <tr>
                <th>Nom</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produits as $produit)
                <tr>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ $produit->categorie->nom }}</td>
                    <td>{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $produit->stock }}</td>
                    <td style="white-space:nowrap;">
                        <a class="btn petit" href="{{ route('admin.produits.edit', $produit) }}">Modifier</a>
                        {{-- DELETE : un mini-formulaire en méthode DELETE,
                             avec confirmation avant l'envoi. --}}
                        <form method="POST" action="{{ route('admin.produits.destroy', $produit) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Supprimer définitivement « {{ $produit->nom }} » ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn petit danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
