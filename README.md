# Auth Module

This is an auth module for a Laravel application (>= 8) 

It embed:

- login, registration, two factor authentication
- role/permission management
- user management
- impersonation features.


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

this features is based on the library
https://github.com/lab404/laravel-impersonate


# Installation & configuration 

Your laravel application must have rapyd-livewire package already installed first, then you can require this module using: 
```
composer require zofe/auth-module

php artisan migrate 
php artisan db:seed --class="App\\Modules\\Auth\\Database\\Seeders\\AuthSeeder"
```
Note that auth module use layout-module, you may need to do:

```
cd app/Modules/Layout/

npm i
npm run dev
```

this will compile scss and copy css assets to your public project folder



# Usage
This command will create a folder "auth" in your /app/Modules/ folder,   
the module comes with sole routes to edit users, roles, permissions.

