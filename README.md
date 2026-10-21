# EduConnect — Plateforme éducative web (Symfony)

Projet académique PIDEV, réalisé à Esprit School of Engineering (2024–2025).

## Présentation

Application web éducative construite avec Symfony 6.4, Twig et Doctrine ORM. Le dépôt couvre les parcours liés aux cours, stages, événements, réclamations et espaces de gestion. Les fonctionnalités nécessitent une vérification dans un environnement local configuré ; aucune disponibilité en production n'est revendiquée.

## Technologies et structure

- PHP >= 8.1 (selon `composer.json`), Symfony 6.4, Doctrine ORM
- Twig, HTML/CSS et assets (`assets/`, `public/`)
- Base relationnelle via `DATABASE_URL` (MySQL dans le contexte du projet)
- Principaux dossiers : `src/Controller/`, `src/Entity/`, `src/Repository/`, `src/Form/`, `templates/`, `migrations/`, `tests/`

## Installation locale

Prérequis : PHP et extensions requises, Composer, base de données configurée et, idéalement, Symfony CLI.

```bash
git clone https://github.com/baaahaaaa/YRTBJ.git
cd YRTBJ
composer install
```

1. Copier `.env.example` vers `.env.local` (ignoré par Git).
2. Renseigner `APP_SECRET`, `DATABASE_URL` et les services utiles localement, sans publier de mots de passe.
3. Exécuter `php bin/console about` pour vérifier la configuration.
4. Sur une **base de développement**, appliquer `php bin/console doctrine:migrations:migrate` (modifie le schéma).
5. Si Symfony CLI est installé, démarrer avec `symfony serve`.

## Vérifications recommandées

```bash
composer validate
php bin/console lint:twig templates/
php bin/phpunit
```

Ces commandes restent à exécuter : aucun résultat de tests ni CI automatisée n'est présumé.

## Sécurité et limites

- Le dépôt a historiquement suivi un fichier `.env`. Supprimer ce fichier de la branche active ne supprime pas les anciennes versions : changer/révoquer tout secret réel précédemment exposé.
- Ne jamais versionner `.env.local`, les bases de données, les données réelles, des secrets ou des tokens.
- Vérifier l'authentification, les contrôles d'accès et les parcours end-to-end avant démonstration.
- Le client desktop associé est disponible dans [ProjectJava](https://github.com/baaahaaaa/ProjectJava).

**Statut :** code académique publié ; tests fonctionnels et audit de sécurité restant à confirmer.
