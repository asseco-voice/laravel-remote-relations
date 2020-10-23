<?php

declare(strict_types=1);

namespace Voice\ExternalRelations;

use Illuminate\Support\ServiceProvider;

class ExternalRelationsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/asseco-external-relations.php', 'asseco-external-relations');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/asseco-external-relations.php' => config_path('asseco-external-relations.php')]);
    }
}
