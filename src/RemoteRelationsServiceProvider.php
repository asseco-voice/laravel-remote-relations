<?php

declare(strict_types=1);

namespace Voice\RemoteRelations;

use Illuminate\Support\ServiceProvider;

class RemoteRelationsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/asseco-remote-relations.php', 'asseco-remote-relations');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/asseco-remote-relations.php' => config_path('asseco-remote-relations.php')]);
    }
}
