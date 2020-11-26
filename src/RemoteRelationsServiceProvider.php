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
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $timestamp = now()->format('Y_m_d_His');

        $this->publishes([
            __DIR__ . config('asseco-remote-relations.stub_path') => database_path("migrations/{$timestamp}_create_remote_relations_table.php")
        ], 'asseco-remote-relations-migrations');

        $this->publishes([
            __DIR__ . '/../config/asseco-remote-relations.php' => config_path('asseco-remote-relations.php')
        ], 'asseco-remote-relations-config');
    }
}
