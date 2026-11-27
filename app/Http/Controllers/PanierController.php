<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/** Gère le panier de démonstration stocké dans la session Laravel. */
class PanierController extends Controller
{
    /** Affiche les articles du panier et le montant total. */
    public function index(Request $request): View
    {
        $articles = $this->articles($request);
        $total = $articles->sum('total');

        return view('panier.index', compact('articles', 'total'));
    }

    /** Ajoute un produit après vérification du stock disponible. */
    public function ajouter(Request $request, Produit $produit): RedirectResponse
    {
        $donnees = $request->validate([
            'quantite' => ['nullable', 'integer', 'min:1'],
        ]);
        $quantite = (int) ($donnees['quantite'] ?? 1);
        $panier = $request->session()->get('panier', []);
        $quantiteTotale = ($panier[$produit->id] ?? 0) + $quantite;

        if ($produit->stock < 1 || $quantiteTotale > $produit->stock) {
            return back()->withErrors([
                'panier' => 'La quantité demandée dépasse le stock disponible.',
            ]);
        }

        $panier[$produit->id] = $quantiteTotale;
        $request->session()->put('panier', $panier);

        return redirect()->route('panier.index')->with('succes', 'Produit ajouté au panier.');
    }

    /** Modifie la quantité d'un produit déjà présent dans le panier. */
    public function modifier(Request $request, Produit $produit): RedirectResponse
    {
        $donnees = $request->validate([
            'quantite' => ['required', 'integer', 'min:1', 'max:'.$produit->stock],
        ]);
        $panier = $request->session()->get('panier', []);

        if (! array_key_exists($produit->id, $panier)) {
            return redirect()->route('panier.index');
        }

        $panier[$produit->id] = (int) $donnees['quantite'];
        $request->session()->put('panier', $panier);

        return redirect()->route('panier.index')->with('succes', 'Panier mis à jour.');
    }

    /** Retire un article du panier. */
    public function supprimer(Request $request, Produit $produit): RedirectResponse
    {
        $panier = $request->session()->get('panier', []);
        unset($panier[$produit->id]);
        $request->session()->put('panier', $panier);

        return redirect()->route('panier.index')->with('succes', 'Produit retiré du panier.');
    }

    /** Simule une commande sans paiement ni écriture de commande en base. */
    public function commander(Request $request): RedirectResponse
    {
        $articles = $this->articles($request);

        if ($articles->isEmpty()) {
            return redirect()->route('panier.index')->withErrors([
                'panier' => 'Ajoute au moins un produit avant de valider la commande.',
            ]);
        }

        foreach ($articles as $article) {
            if ($article['quantite'] > $article['produit']->stock) {
                return redirect()->route('panier.index')->withErrors([
                    'panier' => 'Le stock de « '.$article['produit']->nom.' » a changé. Mets le panier à jour.',
                ]);
            }
        }

        $commande = [
            'reference' => 'DEMO-'.strtoupper(bin2hex(random_bytes(3))),
            'articles' => $articles->map(fn (array $article) => [
                'nom' => $article['produit']->nom,
                'quantite' => $article['quantite'],
                'total' => $article['total'],
            ])->all(),
            'total' => $articles->sum('total'),
        ];

        $request->session()->forget('panier');

        return redirect()->route('panier.confirmation')->with('commande_demo', $commande);
    }

    /** Affiche le récapitulatif d'une commande simulée. */
    public function confirmation(Request $request): View|RedirectResponse
    {
        $commande = $request->session()->get('commande_demo');

        if (! $commande) {
            return redirect()->route('produits.index');
        }

        return view('panier.confirmation', compact('commande'));
    }

    /** Construit les lignes du panier à partir des produits toujours existants. */
    private function articles(Request $request): Collection
    {
        $panier = $request->session()->get('panier', []);
        $produits = Produit::with('categorie')
            ->whereIn('id', array_keys($panier))
            ->get()
            ->keyBy('id');

        return collect($panier)
            ->map(function (int $quantite, int|string $id) use ($produits) {
                $produit = $produits->get($id);

                if (! $produit) {
                    return null;
                }

                return [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'total' => $quantite * (float) $produit->prix,
                ];
            })
            ->filter()
            ->values();
    }
}
