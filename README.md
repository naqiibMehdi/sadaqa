# Projet Full Stack avec Laravel et Vue.js

## Description

Ce projet est une application full stack avec un backend développé en Laravel et un frontend développé en Vue.js. Le
backend utilise Docker Compose pour gérer les conteneurs Docker pour MariaDB et MailHog.

## Prérequis

- Docker
- Docker Compose
- PHP 8.2 ou supérieur
- Composer
- Node.js (version 22 ou supérieure)
- npm (version 6 ou supérieure) ou yarn (version 1.22 ou supérieure)

## Structure du projet

- `backend/` : Contient le code source du backend Laravel
- `frontend/` : Contient le code source du frontend Vue.js
- `backend/docker-compose.yml` : Fichier de configuration Docker Compose pour les services MariaDB et MailHog

## Installation et démarrage

### Backend Laravel

1. **Accéder au répertoire du backend :**

   ```bash
   cd back
   ```

2. **Copier le fichier .env.example :**

   ```bash
   cp .env.example .env
   ```

3. **Configurer les variables d'environnements :**

    ```text
    DB_CONNECTION=mysql
    DB_HOST=mariadb
    DB_PORT=3306
    DB_DATABASE=votre_base_de_données
    DB_USERNAME=votre_utilisateur
    DB_PASSWORD=votre_mot_de_passe
    
    MAIL_MAILER=smtp
    MAIL_HOST=mailhog
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="\${APP_NAME}"
    ```
4. **Installer les dépendances :**

   ```bash
   composer install
   ```

5. **Démarrer le serveur**

    ```bash
   composer run dev
   ```

### Frontend Vuejs

1. **Accéder au répertoire du frontend**

    ```bash
    cd front
    ```

2. **Installer les dépendances**

    ```bash
    npm install
    ```

3. **Démarrer le serveur Vuejs**

    ```bash
   npm run dev
   ```

### Fichier docker-compose.yml

**Dans le cadre où si vous devez utiliser docker, vous pouvez lancer le fichier docker-compose.yml pour votre base de
donées et/ou votre serveur mail**

**Voici le fichier à adapter:**

```dockerfile
services:
  mariadb:
    image: mariadb:10.6
    container_name: mariadb
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: votre_base_de_données
      MYSQL_USER: votre_utilisateur
      MYSQL_PASSWORD: votre_mot_de_passe
      MYSQL_ROOT_PASSWORD: votre_mot_de_passe_root
    ports:
      - "3306:3306"
    volumes:
      - ./docker-compose/mariadb:/var/lib/mysql

  mailhog:
    image: mailhog/mailhog
    container_name: mailhog
    restart: unless-stopped
    ports:
      - "1025:1025"
      - "8025:8025"
```

Ce fichier `README.md` fournit des instructions claires et détaillées pour démarrer les serveurs Laravel et Vue.js,
ainsi que pour lancer les conteneurs Docker pour MariaDB et MailHog.

