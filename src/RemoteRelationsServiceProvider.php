<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations;

use Asseco\RemoteRelations\App\Contracts\RelationsResolver;
use Asseco\RemoteRelations\App\Contracts\RemoteRelation;
use Illuminate\Support\Facades\Route;
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

        if (config('asseco-remote-relations.migrations.run')) {
            $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        }
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'asseco-comments');

        $this->publishes([
            __DIR__ . '/../config/asseco-remote-relations.php' => config_path('asseco-remote-relations.php'),
        ], 'asseco-remote-relations-config');

        $this->app->bind(RemoteRelation::class, config('asseco-remote-relations.models.remote_relation'));
        $this->app->bind(RelationsResolver::class, config('asseco-remote-relations.models.relations_resolver'));

        Route::model('remote_relation', get_class(app(RemoteRelation::class)));
    }
}
