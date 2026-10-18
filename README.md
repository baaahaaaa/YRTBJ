# EduConnect - Plateforme Web Éducative (Symfony)

## Overview

Ce projet a été réalisé dans le cadre du module PIDEV à **Esprit School of Engineering** (2024-2025).  
Il constitue la partie web d'une plateforme éducative permettant aux étudiants :
- d'acheter des cours,
- de réserver des stages et des événements,
- et de déposer des réclamations.

Les agents, tuteurs et administrateurs assurent la gestion de tous les contenus pédagogiques.

## Features ##

- 🧑‍🎓 Espace étudiant :
  - Achat de cours
  - Réservations (stages & événements)
  - Module de réclamations

- 👨‍🏫 Espace agent / tuteur / admin :
  - Création de cours
  - Gestion des stages et événements
  - Tableau de bord et administration

- 🔐 Gestion des utilisateurs et des rôles

Tech Stack ###

Frontend ####

- Twig
- HTML5 / CSS3
- Bootstrap

Backend

- Symfony 6.4 (PHP 8.2)
- Doctrine ORM
- MySQL

### Other Tools

- Composer
- Git / GitHub
- WAMP / XAMPP
- Mailer SMTP

## Directory Structure ##

```csharp
📂 SkyLearn-Web/
├── config/         # Config Symfony & services
├── public/         # Document root & assets
├── src/
│   ├── Controller/
│   ├── Entity/
│   ├── Repository/
│   ├── Service/
│   └── Form/
├── templates/      # Twig (front & back)
├── var/            # Cache & logs
├── vendor/         # Dépendances Composer
└── README-Symfony.md

## Local environment setup

Copy `.env.example` to `.env` on your development machine and replace all placeholders with local values. Never commit real credentials or tokens. The project previously tracked `.env`; any secret that was in that history must be rotated. Removing `.env` from the latest branch does not erase past commits.
