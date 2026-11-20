# Mini Boutique — Application Laravel

Une application de catalogue de produits construite avec **Laravel** : les visiteurs parcourent la boutique et le détail des produits, et un administrateur connecté gère le catalogue (ajout, modification, suppression) depuis un espace protégé.

Ce projet est l'application pratique de notre **exposé de groupe sur Laravel** : chaque chapitre du cours correspond à une partie réellement implémentée ici, du premier `composer create-project` jusqu'aux seeders.

> Exposé de groupe — Institut de Formation et de Recherche en Informatique (IFRI), Université d'Abomey-Calavi, année académique 2026-2027.

## Ce que fait l'application

- **Côté visiteur** : page d'accueil avec le catalogue (20 produits), page détail de chaque produit, prix affichés en FCFA et stock visible.
- **Côté administrateur** : connexion sécurisée, tableau de bord, liste des produits, formulaire de création et de modification avec validation en français, suppression.
- **Données de démonstration** : une factory génère 20 produits français en FCFA et les seeders remplissent la base en une commande.

Pages principales, une fois l'application lancée :

- `/` → le catalogue public (20 produits, catégories, prix en FCFA, stock)
- `/produits/3` → le détail d'un produit
- `/login` → la page de connexion
- `/admin/produits` → l'espace admin (connexion obligatoire)

## Les 10 notions Laravel démontrées

| # | Notion | Où la voir dans le projet |
|---|---|---|
| 1 | Installation | Projet Laravel (PHP 8.2+, Composer), base SQLite |
| 2 | Routage | `routes/web.php` : routes publiques et routes admin protégées |
| 3 | Contrôleurs | `ProduitController` (index, show + CRUD admin) |
| 4 | Blade | `resources/views/` : layout boutique, vues produits et admin, composants |
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

php artisan serve
```

L'application est alors accessible sur http://127.0.0.1:8000

Pour repartir de zéro à tout moment : `php artisan migrate:fresh --seed`

Si les pages de connexion s'affichent sans style, régénérer les assets de Breeze avec `npm install && npm run build`.

## Identifiants de démonstration

| Rôle | E-mail | Mot de passe |
|---|---|---|
| Administrateur | `admin@boutique.test` | `password` |

Compte de démonstration uniquement, mot de passe stocké haché (bcrypt) : ne jamais l'utiliser sur un vrai site.

## Contexte

Application réalisée dans le cadre de l'exposé de groupe « Laravel, le framework PHP pour artisans du web » — IFRI, Université d'Abomey-Calavi (Bénin).
