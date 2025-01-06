# 🚗 Système de Gestion de Location de Véhicules
Bienvenue dans notre projet de système de gestion de location de véhicules. Ce projet a été conçu pour faciliter la gestion des utilisateurs, des véhicules, des réservations et des avis dans une plateforme simple, intuitive et performante.

## 🌟 Fonctionnalités
### 1. Gestion des Utilisateurs
Inscription et connexion sécurisées.
Gestion des rôles : clients et administrateurs.
Sessions utilisateur pour un suivi personnalisé.
### 2. Gestion des Véhicules
Ajout, modification, et suppression (logique) des véhicules par les administrateurs.
Consultation des catégories et filtres dynamiques pour les clients.
### 3. Réservations
Formulaire interactif pour réserver un véhicule.
Vérification en temps réel de la disponibilité.
Historique des réservations accessible pour les clients.
### 4. Avis et Évaluations
Les clients peuvent laisser des avis sur les véhicules après location.
Modération des avis par les administrateurs.
### 5. Tableau de Bord Administratif
Visualisation des statistiques sur les véhicules les plus réservés et les mieux notés.
Actions rapides : gestion des réservations et des avis.
## 🔧 Technologies Utilisées
Frontend : HTML, CSS (avec Tailwind), JavaScript (Vanilla).
Backend : PHP avec gestion des sessions et requêtes SQL.
Base de Données : MySQL (schéma structuré avec phpMyAdmin).
Environnement de Développement : Laragon.
## 🚀 Installation
Clonez le projet depuis ce dépôt :
bash
### Copier le code
git clone <url-du-repo>
cd <nom-du-repo>
Configurez votre environnement avec Laragon ou tout autre serveur local.
Importez la base de données depuis le fichier database.sql disponible dans le dossier /db.
Lancez le serveur local et ouvrez le projet dans votre navigateur.
## 🐞 Bugs Connus
Voici une liste des bugs potentiels identifiés à ce stade :

Problèmes de filtrage des véhicules.
Gestion incorrecte des sessions utilisateurs.
Conflits possibles sur les réservations multiples d'un même véhicule.
Problèmes d'affichage des avis supprimés dans le tableau de bord.
Si vous rencontrez d'autres problèmes, n'hésitez pas à les signaler en créant une issue.

## 🛠️ Améliorations Futures
Ajout d'un système de notifications (réservations confirmées, avis approuvés).
Intégration d'une API pour vérifier les informations des utilisateurs en temps réel.
Optimisation des requêtes SQL pour une meilleure performance avec de grandes bases de données.
## 💻 Contributions
Les contributions sont les bienvenues !

Forkez ce dépôt.
Créez une branche pour votre fonctionnalité ou correction :
bash
Copier le code
git checkout -b feature/nouvelle-fonctionnalite
Envoyez vos modifications via une Pull Request.