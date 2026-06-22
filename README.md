# Vite & Gourmand

Application web de commande en ligne pour une entreprise de traiteur événementiel basée à Bordeaux.

## Prérequis

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Installation

### 1. Cloner le dépôt

git clone https://github.com/samymakhloufi-bot/vite-et-gourmand.git
cd vite-et-gourmand

### 2. Configurer l'environnement

Copier le fichier d'exemple et le renommer :

cp .env.docker.exemple .env.docker

Les variables sont pré-remplies et fonctionnelles, aucune modification nécessaire pour un lancement en local.

### 3. Lancer l'application

sudo docker-compose up -d

L'application est accessible à l'adresse : http://localhost:8080

### 4. Importer la base de données

La base de données est automatiquement initialisée au premier démarrage via le fichier `init.sql`.

## Identifiants de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@vite-gourmand.fr | Motdepasse1! |
| Employé | employe@vite-gourmand.fr | Motdepasse1! |
| Utilisateur | user@vite-gourmand.fr | Motdepasse1! |

## Démo en ligne

https://vite-et-gourmand-samy.alwaysdata.net/