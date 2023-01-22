<?php

namespace Potatoquality\TopCheck\Providers;
use Potatoquality\TopCheck\Commands\RunTopCheck;
use Illuminate\Support\ServiceProvider;
use Potatoquality\TopCheck\Commands\SaveTopCheck;

class TopCheckServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Migrations');

        $this->publishes([
            __DIR__ . "/../Publish/Config/topcheck.php" => config_path("topcheck.php"),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                RunTopCheck::class,
                SaveTopCheck::class,
            ]);
        }
    }
}
