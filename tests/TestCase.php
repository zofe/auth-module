<?php

namespace App\Modules\Auth\tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Facade;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Zofe\Auth\AuthServiceProvider;


class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });
        Facade::setFacadeApplication(app());
        parent::setUp();

//        Factory::guessFactoryNamesUsing(
//            fn (string $modelName) => 'Uania\\Permission\\Database\\Factories\\'.class_basename($modelName).'Factory'
//        );

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    protected function defineRoutes($router)
    {
//        $router->group(['prefix' => 'test-demo'], function () use ($router) {
//            $router->get('/', function () {
//                return view('master');
//            })->name('test');
//
//        });
    }

    public function makeACleanSlate()
    {
        Artisan::call('view:clear');
    }

    protected function getPackageProviders($app)
    {
        return [
            AuthServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('view.paths', [
            __DIR__.'/../resources/views',
            __DIR__.'/resources/views',

            resource_path('views'),
        ]);
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('session.driver', 'file');
    }
}
