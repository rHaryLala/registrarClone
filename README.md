# Registrar Clone

Ce projet est une application de gestion universitaire développée avec Laravel.  
Il permet la gestion des étudiants, enseignants, cours et mentions, avec une interface moderne et une recherche rapide côté front.

## Fonctionnalités

- **Gestion des étudiants** : ajout, modification, suppression, affichage, recherche instantanée sans rechargement de page, tri par colonne (matricule, nom, prénom, email, mention, niveau d'étude).
- **Gestion des enseignants** : ajout, modification, suppression, affichage.
- **Gestion des cours** : ajout, modification, suppression, affichage, association aux enseignants et mentions.
- **Gestion des mentions** : ajout, modification, suppression, affichage.
- **Tableau de bord** : statistiques, dernières inscriptions, graphiques.
- **Ajout et retrait de cours pour chaque étudiant.**
- **Filtrage et tri avancés dans les listes.**

## Installation

1. Cloner le dépôt :
   ```bash
   git clone https://github.com/rHaryLala/registrarClone
   cd registrarClone
   ```
2. Installer les dépendances :
   ```bash
   composer install
   npm install
   ```
3. Copier `.env.example` en `.env` et configurer la base de données.
4. Générer la clé d'application :
   ```bash
   php artisan key:generate
   ```
5. Lancer les migrations :
   ```bash
   php artisan migrate
   ```
6. Démarrer le serveur :
   ```bash
   php artisan serve
   ```

## Utilisation

- Accéder à l'interface via `http://localhost:8000`.
- Utiliser le menu latéral pour naviguer entre les modules.
- La recherche dans la liste des étudiants est instantanée et ne recharge pas la page.
- Le tri s'effectue en cliquant sur les en-têtes de colonnes.

## Technologies

- Laravel (backend)
- Blade (templates)
- Tailwind CSS
- JavaScript (recherche front)
- FontAwesome

## Auteur

Université Adventiste Zurcher - Projet Registrar Clone

