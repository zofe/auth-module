# Auth Module

This is a auth module for a Laravel application (>= 8) 

It embed login, registration, two factor authentication, role/permission management, impersonation features.


# Models

Two Models will be provided by this module:
 - Role
 - Permission

As you can imagine the role is a characteristic you can associate with a user, permissions are the "actions granted" for that role.

The mudule has a configuration file that allows you to define roles, permissions, and the relationship between them.

After possibly adjusting them to your needs a seeder will allow you to create the entire authentication system.


This module is based on 
https://github.com/spatie/laravel-permission


# Impersonation 

One of the necessary features in the implementation of a backend is to impersonate other users/customers, this module has this functionality built in


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
then will be enabled rome routes ...

