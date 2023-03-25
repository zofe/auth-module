# Auth Module

This is an auth module for a Laravel application (>= 8) 

It embed:

- login, registration, two factor authentication
- role/permission management
- user management
- impersonation features.
- component permissions, and priority "role based"


# Login / Registration & Two factor authentication

This module give you out of the box a fortify implementation https://laravel.com/docs/10.x/fortify#main-content 
with a bootstrap layout and default configuration you can customize on ./config/fortify.php 


# Permissions & Models

Two Models will be provided by this module:
 - Role
 - Permission

As you can imagine the role is a characteristic you can associate with a user, permissions are the "actions granted" for that role.

The module has a configuration file that allows you to define roles, permissions, and the relationship between them.

The editable configuration is provided in ./config/permission.php
Then you need to run the provided seeder.

these features are based on the library:
https://github.com/spatie/laravel-permission


# Impersonation 

One of the necessary features in the implementation of a backend is to impersonate other users/customers, this module has this functionality built in

This module include a trait `Zofe\Auth\Traits\Impersonate` to check roles if user can impersonate other and to check if user can be impersonated.

By default, this trait add check if You are admin and the user you want to impersonate is not an admin (using roles).

for a custom implementation override `canImpersonate()` and `canBeImpersonated()` in your model

```php

use Zofe\Auth\Traits\Impersonate;

class User extends Model
{
  use Impersonate;

```

this features is based on the library
https://github.com/lab404/laravel-impersonate



# Component roles & permissions

This module include a trait `Zofe\Auth\Traits\Authorize` to check roles or permissions before build/render/execute component actions.

you can just include the trait:

```php

use Zofe\Auth\Traits\Authorize;

class CompaniesEdit extends Component
{
    use Authorize;
```

then add authorize check at booted time in your components:

```php
    public function booted()
    {
        $this->authorize('admin|edit users');
    }
```

this will check if one of role or permission is applied to the logged-in user, otherwise it gives a permission error.


# Component priority role based

This module include a middleware out of the box, that search for priority component instead of the one defaulted by the route.

By "priority component" we mean a component that is prefixed with the "Rolename" of the logged-in user
e.g., despite the defined route :

`Route::get('/companies/view/{company:id}', CompaniesView::class)`

`Customer` role user the middleware looks for `CustomerCompaniesView::class` and dispenses that if it exists.

this allows you to extend livewire components and adapt features and views potentially for each `role` to be managed (if you need to do so).

Just configure your prefixes in the config:
```php
    'role_to_component_prefix' => [
        'customer' => 'customer'
    ],
```

add the middleware in your app/Http/Kernel.php
```php
    protected $middlewareGroups = [
        'web' => [
            //..
            Zofe\Auth\Middleware\ComponentByRole::class,
        ],
    ]
```




# Installation & configuration 

Your laravel application must have rapyd-livewire package already installed first, then you can require this module using: 
```
composer require zofe/auth-module

php artisan migrate 
php artisan db:seed --class="App\\Modules\\Auth\\Database\\Seeders\\AuthSeeder"
```

# Layout

Note that this module will install/use layout-module, you may need to do:

```
cd app/Modules/Layout/

npm i
npm run dev
```

this will compile scss and copy css assets to your public project folder



# Usage
This command will create a folder "auth" in your /app/Modules/ folder,   
the module comes with sole routes to edit users, roles, permissions.


# Customizing Module 
To customize the module code, we recommend forking the original package repository on GitHub and making changes there. This way, you can maintain a separate branch for your changes, while also keeping up-to-date with the latest releases of the package.

To install your forked version of the package in your Laravel application, you can reference your forked repository in the composer.json file of your Laravel application using the "vcs" package type. Here's an example of what you can add to your composer.json:

```json

"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/<your-github-username>/<package-name>"
    }
],
```
Replace `<your-github-username>` with your GitHub username and `<package-name>` with the name of your forked package repository.

After adding your forked repository to composer.json, you can require your customized package in the same way you would require the original package:

```php
composer require <your-github-username>/<package-name>:dev-<your-branch-name>
```
Replace `<your-github-username>`, `<package-name>`, and `<your-branch-name>` with the appropriate values for your forked repository and branch.

By using this approach, you can easily customize the module code while also keeping your code up-to-date with the latest releases of the package.

We encourage developers to make changes that could be useful to the wider community and contribute back to the original package repository via pull requests. This can help improve the package for everyone and ensure that your changes are integrated with the latest releases of the package.
