# 🐙🤖 Octools

Octools is a PHP package that enables self-hosted [Octools.io](https://octools.io). It is also possible to take out a subscription on [Octools.io](https://octools.io).
This package allows you to install the back-office which allows the management of users, teams, applications.

## Requirements

- PHP >= 8.1
- Laravel >= 10.0
- Laravel Nova >= 4.0

## Installation

1. With Composer :
    
    ```bash
    composer require webid/octools
    ```
   
2. After installation, you must publish the necessary assets using the following command :
    
    ```php
    php artisan vendor:publish --provider="Webid\Octools\OctoolsServiceProvider"
    ```
   
3. Now, you need to run the migrations :
    
    ```php
    php artisan migrate
    ```
   
## First steps

1. You can easily create your first organization and user by running the following command :
    
    ```php
    php artisan organization:create
    ```
    
    ```php
    php artisan user:create
    ```
   
2. Finally, add HasOrganization trait to your User model :
    
    ```php
    use WebId\Octools\Traits\HasOrganization;
    
    class User extends Authenticatable
    {
        use HasOrganization;
    }
    ```

## Configuration

You can configure the package, like the reference for your models in config/octools.php.
    
```php
    'models' => [
        'user' => App\Models\User::class,
        'member' => \Webid\Octools\Models\Member::class,
        'application' => \Webid\Octools\Models\Application::class,
        'member_service' => \Webid\Octools\Models\MemberService::class,
        'organization' => \Webid\Octools\Models\Organization::class,
        'workspace' => \Webid\Octools\Models\Workspace::class,
        'workspace_service' => \Webid\Octools\Models\WorkspaceService::class,
    ],
```

You can also edit the brand and menu sidebar of the back-office.

## API Usage

You can now use the API to manage your users, teams and applications. You can refer to the API documentation at [Octools.io](https://app.octools.io/api/docs).
API routes requires an authentication token. You can generate a token by logging into your back office and going to the "Application" menu. You can then create a new application and a token will be attached to it.
It is with this that we authenticate on the API.

```sh
curl -X GET \
https://your-domain.com/api/users \
-H 'Authorization: Bearer YOU_APP_TOKEN' \
-H 'Content-Type: application/json'
```

## Services installation

Finally, you can install the services you want to use. To do this, you must go to the documentation for each service and follow the installation instructions.

- [Slack](https://github.com/web-id-fr/octools-connectors)
- [Github](https://github.com/web-id-fr/octools-connectors)
- [Gryzzly](https://github.com/web-id-fr/octools-connectors)