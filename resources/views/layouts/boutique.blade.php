<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titre', 'Mini-Boutique')</title>

    {{-- CSS minimal, intégré directement : aucun outil à installer. --}}
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, Arial, sans-serif; margin: 0; background: #f4f6fb; color: #1f2430; }
        header { background: #0B2447; color: #fff; padding: 16px 24px; }
        header a { color: #fff; text-decoration: none; font-weight: 700; font-size: 20px; }
        header span { display: block; font-size: 13px; opacity: .8; margin-top: 2px; }
        main { max-width: 1000px; margin: 0 auto; padding: 24px 16px 48px; }
        h1 { font-size: 24px; margin: 8px 0 20px; }
        .grille { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
        .carte { background: #fff; border-radius: 10px; padding: 16px; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .carte h2 { font-size: 17px; margin: 0 0 6px; }
        .categorie { font-size: 12px; text-transform: uppercase; letter-spacing: .04em; color: #0866FF; margin: 0 0 8px; }
        .prix { font-size: 18px; font-weight: 700; margin: 8px 0; }
        .badge { display: inline-block; font-size: 12px; padding: 3px 8px; border-radius: 999px; background: #e6f4ea; color: #137333; }
        .badge.rupture { background: #fdecea; color: #b3261e; }
        .lien { display: inline-block; margin-top: 10px; color: #0866FF; text-decoration: none; font-weight: 600; }
        .lien:hover { text-decoration: underline; }
        .detail { background: #fff; border-radius: 10px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .detail .prix { font-size: 24px; }
        .vide { background: #fff; border-radius: 10px; padding: 24px; text-align: center; }
        code { background: #eef1f6; padding: 2px 6px; border-radius: 4px; }
        footer { text-align: center; font-size: 12.5px; color: #5b6472; padding: 4px 16px 28px; }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('produits.index') }}">🛍️ Mini-Boutique</a>
        <span>Le projet pratique de l'exposé Laravel — catalogue des produits</span>
    </header>

    <main>
        {{-- Chaque page remplit cette zone avec @section('contenu') --}}
        @yield('contenu')
    </main>

    <footer>
        Projet réalisé par LOKOSSOU John Elie, AMEHO Fifamè Grâce, SOSSOU Almira Davina Oluwatoyi, DINLA Marcel et DJIMENOU Onésime — IFRI, Université d'Abomey-Calavi
    </footer>
</body>
</html>
