# Mini Boutique — Application Laravel

Une application de catalogue de produits construite avec **Laravel** : les visiteurs parcourent la boutique et le détail des produits, et un administrateur connecté gère le catalogue (ajout, modification, suppression) depuis un espace protégé.

Ce projet est l'application pratique de notre **exposé de groupe sur Laravel** : chaque chapitre du cours correspond à une partie réellement implémentée ici, du premier `composer create-project` jusqu'aux seeders.

> Exposé de groupe — Institut de Formation et de Recherche en Informatique (IFRI), Université d'Abomey-Calavi, année académique 2026-2027.

## Ce que fait l'application

- **Côté visiteur** : accueil avec produits à découvrir et chiffres du catalogue, recherche, filtres par catégorie et stock, tri, pagination, fiches détaillées et prix en FCFA.
- **Panier** : ajout, mise à jour et retrait d'articles avec quantité vérifiée selon le stock. Le panier est stocké dans la session Laravel. La validation de commande est simulée : aucun paiement ni enregistrement de commande n'est effectué.
- **Côté administrateur** : espace protégé, indicateurs du catalogue, alertes de stock, liste paginée, CRUD des produits, validation en français et téléversement local de photos.
- **Interface** : vues Blade, CSS intégré au layout et SVG locaux. Aucun framework front-end ni bibliothèque d'interface externe.
- **Données de démonstration** : une factory génère 20 produits français en FCFA et les seeders remplissent la base en une commande.

Pages principales, une fois l'application lancée :

- `/` → le catalogue public (20 produits, catégories, prix en FCFA, stock)
- `/produits/3` → le détail d'un produit
- `/panier` → le panier de démonstration
- `/login` → la page de connexion
- `/admin` → le tableau de bord (connexion obligatoire)
- `/admin/produits` → l'espace admin (connexion obligatoire)

## Les 10 notions Laravel démontrées

| # | Notion | Où la voir dans le projet |
|---|---|---|
| 1 | Installation | Projet Laravel (PHP 8.2+, Composer), base SQLite |
| 2 | Routage | `routes/web.php` : catalogue, panier et routes admin protégées |
| 3 | Contrôleurs | `ProduitController` (catalogue, recherche, détail et CRUD) et `PanierController` |
| 4 | Blade | `resources/views/` : layout boutique, catalogue, panier et administration |
| 5 | Migrations | `database/migrations/` : tables `categories` et `produits`, puis ajout de la colonne `stock` par une migration séparée |
| 6 | Eloquent | Modèles `Produit` et `Categorie`, relations `belongsTo` / `hasMany` |
| 7 | Formulaires et validation | Formulaire produit, règles de validation et messages d'erreur en français |
| 8 | CRUD complet | Créer, lire, modifier, supprimer les produits depuis l'espace admin |
| 9 | Authentification | Laravel Breeze (`/login`, `/register`), middleware `auth`, compte admin semé |
| 10 | Artisan et seeders | Commandes Artisan, factory et seeders (`database/seeders/`) |

## Installation

Prérequis : **PHP 8.2+** et **Composer**.

```bash
git clone https://github.com/Elie-lokossou/mini-boutique-laravel.git
cd mini-boutique-laravel

composer install

cp .env.example .env
php artisan key:generate

# Base de données SQLite (déjà configurée dans .env.example)
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link

php artisan serve
```

L'application est alors accessible sur http://127.0.0.1:8000

Pour repartir de zéro à tout moment : `php artisan migrate:fresh --seed`

Les images envoyées par l'administration sont stockées dans `storage/app/public/produits`. La commande `php artisan storage:link` rend ces fichiers accessibles depuis les pages du catalogue.

Si les pages de connexion s'affichent sans style, régénérer les assets de Breeze avec `npm install && npm run build`.

## Identifiants de démonstration

| Rôle | E-mail | Mot de passe |
|---|---|---|
| Administrateur | `admin@boutique.test` | `password` |

Compte de démonstration uniquement, mot de passe stocké haché (bcrypt) : ne jamais l'utiliser sur un vrai site.

## Contexte

Application réalisée dans le cadre de l'exposé de groupe « Laravel, le framework PHP pour artisans du web » — IFRI, Université d'Abomey-Calavi (Bénin).

## L'équipe du projet

Ce projet a été réalisé par un groupe de cinq étudiants de l'IFRI :

- **LOKOSSOU John Elie**
- **AMEHO Fifamè Grâce**
- **SOSSOU Almira Davina Oluwatoyi**
- **DINLA Marcel**
- **DJIMENOU Onésime**

## Remerciements

Un merci spécial à toute l'équipe : ce projet est le fruit d'un vrai travail collectif, où chacune et chacun a apporté sa part, ses idées et son énergie, du premier chapitre jusqu'à la dernière ligne de code. C'est ensemble que nous avons transformé un sujet de cours en une application qui fonctionne pour de vrai.

Merci à chacune et à chacun, personnellement :

- Merci à **John Elie** pour son engagement sans relâche et sa volonté de toujours aller au bout des choses.
- Merci à **Fifamè Grâce** pour sa rigueur et la qualité constante de son travail.
- Merci à **Almira Davina Oluwatoyi** pour son sérieux et sa contribution précieuse à l'avancement du groupe.
- Merci à **Marcel** pour sa disponibilité et son esprit d'équipe tout au long du projet.
- Merci à **Onésime** pour sa participation active et sa bonne humeur communicative.

Nos remerciements vont également à notre enseignant, **Monsieur OUSMANE Matine**, pour son encadrement, ses enseignements et la confiance accordée à notre groupe tout au long de cet exposé.

Merci enfin à l'IFRI et à l'Université d'Abomey-Calavi pour le cadre d'apprentissage qui a rendu ce travail possible.
