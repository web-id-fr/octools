# 🐙🤖 Octools

Octools est un package PHP qui permet de self-hosted [Octools.io](https://octools.io). Il est également possible de prendre un abonnement sur [Octools.io](https://octools.io).
Ce package vous permet d'installer le back-office qui permet la gestion des utilisateurs, équipes, applications.

## Installation

Pour installer le projet self-hosted, suivez les étapes suivantes :

1. Créez un nouveau projet Laravel en utilisant la commande suivante :
    
    ```bash
    composer create-project laravel/laravel example-app
    ```
   
2. Installez Laravel Nova en ajoutant les lignes suivantes dans le composer.json :
    
    ```json
    "repositories": [
      {
        "type": "composer",
        "url": "https://nova.laravel.com"
      }
   ],
    ```
   
    ```json
   "require": {
      "php": "^8.0",
      "laravel/framework": "^9.0",
      "laravel/nova": "~4.0"
   },
    ```
   
    ```bash
    composer update --prefer-dist
    ```
   
    ```php
    php artisan nova:install
    ```

2. Ajoutez le package Octools en utilisant la commande suivante :
    
    ```bash
    composer require webid/octools
    ```
   
3. Publiez les fichiers de configuration en utilisant la commande suivante :
    
    ```php
    php artisan vendor:publish --provider="Webid\Octools\OctoolsServiceProvider"
    ```
   
4. Lancez les migrations en utilisant la commande suivante :
    
    ```php
    php artisan migrate
    ```
   
5. Création de votre organisation et de votre premier utilisateur :
    
    ```php
    php artisan organization:create
    ```
    
    ```php
    php artisan user:create
    ```
   
6. Enfin, ajoutez le trait HasOrganization à votre modèle User :

    ```php
    use WebId\Octools\Traits\HasOrganization;
    
    class User extends Authenticatable
    {
        use HasOrganization;
    }
    ```
   
7. Vous pouvez maintenant vous connecter à votre back-office à l'adresse suivante : https://your-domain.com/nova


## Utilisation de l'API

Vous pouves dès à présent utiliser l'API pour gérer vos utilisateurs, équipes et applications. Vous pouvez vous référer à la documentation de l'API sur [Octools.io](https://app.octools.io/api/docs).

Les routes de l'API ont besoin d'un token d'authentification. Vous pouvez générer un token en vous connectant à votre back-office et en allant dans le menu "Application". Vous pouvez ensuite créer une nouvelle application et un token lui sera rattaché.
C'est avec celui-ci que l'on s'authentifie sur l'API.

```sh
curl -X GET \
https://your-domain.com/api/users \
-H 'Authorization: Bearer VOTRE_APP_TOKEN_ICI' \
-H 'Content-Type: application/json'
```

## Installation des services

Enfin, vous pouvez installer les services que vous souhaitez utiliser. Pour cela, vous devez vous rendre sur la documentation de chaque service et suivre les instructions d'installation.

- [Slack](https://github.com/web-id-fr/octools-connectors)
- [Github](https://github.com/web-id-fr/octools-connectors)
- [Gryzzly](https://github.com/web-id-fr/octools-connectors)