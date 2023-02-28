# Auth Module

This is a auth module for a Laravel application (>= 8) 

It embed login, registration, two factor authentication, role/permission management, impersonation features.


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

