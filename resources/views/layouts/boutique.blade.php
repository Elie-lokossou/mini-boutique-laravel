<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Découvrez le catalogue Mini-Boutique et ses produits disponibles en FCFA.">
    <title>@yield('titre', 'Mini-Boutique')</title>
    <style>
        :root { --ink:#18231e; --muted:#69766e; --green:#006037; --green-dark:#06482f; --orange:#ea5b0c; --paper:#f7f8f4; --line:#e5e9e1; --white:#fff; --shadow:0 16px 40px rgba(16,43,29,.08); }
        * { box-sizing:border-box; }
        html { scroll-behavior:smooth; }
        body { margin:0; background:var(--paper); color:var(--ink); font:15px/1.55 system-ui,-apple-system,"Segoe UI",sans-serif; }
        a { color:inherit; }
        button,input,select { font:inherit; }
        .topbar { background:var(--green-dark); color:#e6f4eb; text-align:center; padding:8px 16px; font-size:12px; letter-spacing:.02em; }
        .site-header { position:sticky; top:0; z-index:5; background:rgba(255,255,255,.96); border-bottom:1px solid var(--line); backdrop-filter:blur(12px); }
        .header-inner { max-width:1180px; min-height:76px; margin:auto; padding:12px 22px; display:flex; align-items:center; justify-content:space-between; gap:20px; }
        .brand { display:flex; align-items:center; gap:11px; text-decoration:none; font-size:19px; font-weight:850; letter-spacing:-.04em; }
        .brand-mark { display:grid; width:40px; height:40px; place-items:center; border-radius:13px; color:#fff; background:var(--green); font-size:21px; }
        .brand small { display:block; color:var(--muted); font-size:10px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; }
        .nav-links { display:flex; align-items:center; gap:22px; }
        .nav-links a { text-decoration:none; font-size:13px; font-weight:700; }
        .nav-links a:hover,.text-link:hover { color:var(--orange); }
        .cart-link { display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border:1px solid var(--line); border-radius:999px; }
        .cart-count { min-width:21px; height:21px; padding:0 6px; display:inline-grid; place-items:center; border-radius:99px; color:#fff; background:var(--orange); font-size:11px; }
        main { min-height:65vh; }
        .page-shell { max-width:1180px; margin:0 auto; padding:34px 22px 70px; }
        .hero { position:relative; overflow:hidden; display:grid; grid-template-columns:1.1fr .9fr; min-height:350px; align-items:center; gap:30px; padding:48px 52px; border-radius:28px; color:#fff; background:linear-gradient(115deg,#06482f 0%,#006037 62%,#0a7850 100%); box-shadow:var(--shadow); }
        .hero:after { content:""; position:absolute; width:360px; height:360px; right:-95px; top:-165px; border-radius:50%; border:1px solid rgba(255,255,255,.13); box-shadow:0 0 0 42px rgba(255,255,255,.035),0 0 0 84px rgba(255,255,255,.025); }
        .hero-copy,.hero-showcase { position:relative; z-index:1; }
        .eyebrow { display:inline-flex; align-items:center; gap:8px; margin-bottom:16px; color:#d5f1df; font-size:11px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
        .eyebrow:before { content:""; width:22px; height:2px; background:var(--orange); }
        .hero h1 { max-width:590px; margin:0; font-size:clamp(35px,5vw,58px); line-height:1.02; letter-spacing:-.055em; }
        .hero p { max-width:510px; margin:18px 0 25px; color:#d7e9df; font-size:15px; }
        .button { display:inline-flex; align-items:center; justify-content:center; gap:9px; min-height:44px; padding:0 18px; border:0; border-radius:12px; color:#fff; background:var(--orange); text-decoration:none; font-weight:800; cursor:pointer; transition:transform .18s,filter .18s; }
        .button:hover { transform:translateY(-2px); filter:brightness(1.05); }
        .button.secondary { color:var(--green); background:#edf5ef; }
        .hero-showcase { display:grid; grid-template-columns:1fr 1fr; align-items:center; gap:12px; transform:rotate(-3deg); }
        .showcase-tile { min-height:118px; display:grid; place-items:center; border:1px solid rgba(255,255,255,.2); border-radius:22px; background:rgba(255,255,255,.12); font-size:48px; backdrop-filter:blur(8px); }
        .showcase-tile:nth-child(2),.showcase-tile:nth-child(3) { transform:translateY(18px); }
        .stats { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin:22px 0 38px; }
        .stat { display:flex; align-items:center; gap:12px; padding:17px 20px; border:1px solid var(--line); border-radius:18px; background:#fff; }
        .stat-icon { width:40px; height:40px; display:grid; place-items:center; border-radius:13px; color:var(--green); background:#ecf5ee; font-size:19px; }
        .stat strong { display:block; font-size:19px; line-height:1.2; }
        .stat span { display:block; color:var(--muted); font-size:11px; }
        .featured { display:grid; grid-template-columns:1fr 1fr; align-items:center; gap:34px; margin:36px 0 54px; padding:25px; border:1px solid var(--line); border-radius:24px; background:#fff; }
        .featured-visual { min-height:230px; display:grid; place-items:center; overflow:hidden; border-radius:18px; background:radial-gradient(circle at 50% 45%,#fff 0,#f2f6ef 62%,#e9efe8 100%); font-size:100px; }
        .featured-visual img { width:100%; height:260px; object-fit:cover; }
        .featured h2 { margin:6px 0 10px; font-size:30px; line-height:1.1; letter-spacing:-.04em; }
        .featured p { color:var(--muted); }
        .section-head { display:flex; align-items:end; justify-content:space-between; gap:16px; margin:0 0 17px; }
        .section-head h2 { margin:0; font-size:28px; letter-spacing:-.04em; }
        .section-head p { margin:4px 0 0; color:var(--muted); font-size:13px; }
        .category-list { display:flex; gap:9px; overflow:auto; padding:2px 0 16px; scrollbar-width:thin; }
        .category-chip { flex:none; display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border:1px solid var(--line); border-radius:99px; color:#415149; background:#fff; text-decoration:none; font-size:12px; font-weight:750; }
        .category-chip:hover,.category-chip.active { color:#fff; border-color:var(--green); background:var(--green); }
        .category-chip small { opacity:.7; font-size:10px; }
        .filters { display:grid; grid-template-columns:minmax(180px,1.5fr) repeat(3,minmax(145px,1fr)) auto; gap:9px; margin:6px 0 18px; padding:13px; border:1px solid var(--line); border-radius:17px; background:#fff; }
        .filters input,.filters select { width:100%; min-height:42px; padding:0 12px; border:1px solid var(--line); border-radius:10px; color:var(--ink); background:#fff; }
        .filters .button { min-height:42px; border-radius:10px; }
        .results-line { display:flex; justify-content:space-between; margin:0 2px 14px; color:var(--muted); font-size:12px; }
        .product-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:16px; }
        .product-card { overflow:hidden; border:1px solid var(--line); border-radius:18px; background:#fff; transition:transform .2s,box-shadow .2s; }
        .product-card:hover { transform:translateY(-4px); box-shadow:var(--shadow); }
        .product-visual { position:relative; height:175px; display:grid; place-items:center; overflow:hidden; background:radial-gradient(circle at 50% 43%,#fff 0,#f0f5ed 64%,#e8eee5 100%); font-size:57px; }
        .product-visual img { width:100%; height:100%; object-fit:cover; }
        .product-visual .stock-label { position:absolute; top:12px; left:12px; }
        .product-info { padding:15px; }
        .product-info .category-label { margin:0 0 5px; color:var(--green); font-size:10px; font-weight:850; letter-spacing:.1em; text-transform:uppercase; }
        .product-info h3 { min-height:42px; margin:0; font-size:15px; line-height:1.35; }
        .product-price { margin:9px 0 12px; font-size:18px; font-weight:850; letter-spacing:-.03em; }
        .product-actions { display:flex; gap:8px; align-items:center; }
        .product-actions .button { min-height:38px; padding:0 12px; border-radius:10px; font-size:11px; }
        .text-link { color:var(--green); text-decoration:none; font-size:11px; font-weight:800; }
        .stock { display:inline-flex; align-items:center; gap:5px; padding:5px 9px; border-radius:99px; color:#14683e; background:#eaf5ec; font-size:10px; font-weight:800; }
        .stock:before { content:""; width:6px; height:6px; border-radius:50%; background:#2fa466; }
        .stock.out { color:#9a382c; background:#fff0ed; }
        .stock.out:before { background:#d9594c; }
        .empty-state,.panel { padding:28px; border:1px solid var(--line); border-radius:18px; background:#fff; }
        .empty-state { text-align:center; }
        .empty-state strong { display:block; font-size:19px; }
        .pagination-wrap { margin-top:25px; }
        .pagination-wrap nav { display:flex; align-items:center; justify-content:space-between; gap:12px; color:var(--muted); font-size:12px; }
        .pagination-wrap nav>div:first-child { display:none; }
        .pagination-wrap nav>div:last-child>span,.pagination-wrap nav>div:last-child>a { display:inline-flex; gap:4px; }
        .pagination-wrap nav span[aria-current],.pagination-wrap nav a { min-width:34px; height:34px; align-items:center; justify-content:center; padding:0 9px; border:1px solid var(--line); border-radius:9px; color:var(--green); background:#fff; text-decoration:none; }
        .pagination-wrap nav [aria-current="page"]>span { color:#fff; background:var(--green); }
        .pagination-wrap nav svg { width:15px; height:15px; }
        .detail-layout { display:grid; grid-template-columns:1fr 1fr; gap:30px; align-items:start; }
        .detail-visual { min-height:360px; display:grid; place-items:center; border:1px solid var(--line); border-radius:24px; background:radial-gradient(circle at 50% 45%,#fff 0,#f0f5ed 70%,#e8eee5 100%); font-size:130px; }
        .detail-visual img { width:100%; max-height:420px; object-fit:cover; border-radius:24px; }
        .detail-content { padding:22px 0; }
        .detail-content h1 { margin:8px 0 12px; font-size:clamp(32px,4vw,46px); line-height:1.04; letter-spacing:-.05em; }
        .detail-content .product-price { font-size:30px; }
        .detail-content .description { max-width:520px; color:var(--muted); }
        .quantity-row { display:flex; align-items:center; gap:10px; margin:20px 0; }
        .quantity-row input { width:82px; height:44px; padding:0 10px; border:1px solid var(--line); border-radius:10px; }
        .cart-table { width:100%; border-collapse:collapse; }
        .cart-table th,.cart-table td { padding:14px 10px; border-bottom:1px solid var(--line); text-align:left; vertical-align:middle; }
        .cart-table th { color:var(--muted); font-size:11px; text-transform:uppercase; }
        .cart-table input[type=number] { width:74px; padding:8px; border:1px solid var(--line); border-radius:9px; }
        .cart-summary { max-width:380px; margin:20px 0 0 auto; padding:20px; border:1px solid var(--line); border-radius:16px; background:#fff; }
        .cart-total { display:flex; justify-content:space-between; margin:0 0 16px; font-size:18px; font-weight:850; }
        .notice { margin:0 0 15px; padding:13px 15px; border-radius:12px; color:#155b35; background:#eaf5ec; }
        .notice.error { color:#9a382c; background:#fff0ed; }
        .footer { padding:28px 22px; color:#68756d; background:#fff; text-align:center; font-size:11px; }
        .footer strong { color:var(--green); }
        .admin-head { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:20px; }
        .admin-head h1 { margin:0; font-size:30px; letter-spacing:-.04em; }
        .metric-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin:20px 0; }
        .metric { padding:18px; border:1px solid var(--line); border-radius:16px; background:#fff; }
        .metric strong { display:block; font-size:24px; }
        .metric span { color:var(--muted); font-size:11px; }
        .admin-table-wrap { overflow-x:auto; border:1px solid var(--line); border-radius:16px; background:#fff; }
        table.admin { width:100%; border-collapse:collapse; min-width:680px; }
        table.admin th,table.admin td { padding:12px 14px; text-align:left; border-bottom:1px solid var(--line); font-size:12px; }
        table.admin th { color:#637168; background:#f5f7f3; font-size:10px; letter-spacing:.08em; text-transform:uppercase; }
        .btn-small { display:inline-flex; align-items:center; justify-content:center; min-height:34px; padding:0 10px; border:0; border-radius:9px; color:var(--green); background:#eaf5ec; text-decoration:none; font-weight:800; font-size:11px; cursor:pointer; }
        .btn-small.danger { color:#a2382e; background:#fff0ed; }
        .form-card { max-width:680px; padding:25px; border:1px solid var(--line); border-radius:19px; background:#fff; }
        .field { margin-bottom:17px; }
        .field label { display:block; margin-bottom:6px; font-size:12px; font-weight:800; }
        .field input,.field select,.field textarea { width:100%; min-height:43px; padding:10px 12px; border:1px solid var(--line); border-radius:10px; background:#fff; }
        .field textarea { min-height:100px; resize:vertical; }
        .field-error { margin:4px 0 0; color:#a2382e; font-size:11px; }
        .form-errors { margin-bottom:16px; padding:14px; border-radius:12px; color:#9a382c; background:#fff0ed; }
        .form-actions { display:flex; flex-wrap:wrap; gap:9px; }
        @media (max-width:900px) { .product-grid { grid-template-columns:repeat(3,minmax(0,1fr)); } .filters { grid-template-columns:repeat(2,minmax(0,1fr)); } .hero { padding:38px; } }
        @media (max-width:640px) { .header-inner { min-height:64px; padding:10px 16px; } .nav-links { gap:9px; } .nav-links>a:first-child { display:none; } .nav-links a { font-size:11px; } .brand { font-size:16px; } .brand-mark { width:35px; height:35px; } .page-shell { padding:22px 15px 50px; } .hero { grid-template-columns:1fr; min-height:0; padding:30px 24px; border-radius:22px; } .hero-showcase { max-width:340px; margin:5px auto 0; } .showcase-tile { min-height:78px; font-size:35px; } .stats { gap:7px; margin:14px 0 30px; } .stat { display:block; padding:12px 9px; text-align:center; } .stat-icon { width:31px; height:31px; margin:0 auto 7px; font-size:14px; } .stat strong { font-size:16px; } .stat span { font-size:9px; } .featured { grid-template-columns:1fr; gap:18px; padding:15px; } .featured-visual,.featured-visual img { min-height:175px; height:175px; } .featured h2 { font-size:24px; } .section-head h2 { font-size:23px; } .filters { grid-template-columns:1fr 1fr; padding:10px; } .filters input:first-child { grid-column:1/-1; } .filters .button { grid-column:1/-1; } .product-grid { grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; } .product-visual { height:125px; font-size:43px; } .product-info { padding:11px; } .product-info h3 { min-height:38px; font-size:13px; } .product-price { font-size:16px; } .product-actions { align-items:stretch; flex-direction:column; } .product-actions .button { width:100%; } .detail-layout { grid-template-columns:1fr; gap:12px; } .detail-visual { min-height:245px; font-size:94px; } .detail-visual img { max-height:300px; } .cart-table th:nth-child(2),.cart-table td:nth-child(2) { display:none; } .metric-grid { grid-template-columns:repeat(2,1fr); gap:8px; } .metric { padding:13px; } .admin-head { align-items:flex-start; flex-direction:column; } }
    </style>
</head>
<body>
    <div class="topbar">Une sélection simple, des prix clairs et un catalogue pensé pour vous</div>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ route('produits.index') }}">
                <span class="brand-mark">M</span>
                <span>Mini-Boutique<small>Le bon choix, simplement</small></span>
            </a>
            <nav class="nav-links" aria-label="Navigation principale">
                <a href="{{ route('produits.index') }}#catalogue">Catalogue</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}">Administration</a>
                @endauth
                <a class="cart-link" href="{{ route('panier.index') }}" aria-label="Ouvrir le panier">
                    <span>Panier</span>
                    <span class="cart-count">{{ array_sum(session('panier', [])) }}</span>
                </a>
            </nav>
        </div>
    </header>

    <main>@yield('contenu')</main>

    <footer class="footer">
        <strong>Mini-Boutique</strong> · Projet réalisé par LOKOSSOU John Elie, AMEHO Fifamè Grâce, SOSSOU Almira Davina Oluwatoyi, DINLA Marcel et DJIMENOU Onésime · IFRI, Université d'Abomey-Calavi
    </footer>
</body>
</html>
