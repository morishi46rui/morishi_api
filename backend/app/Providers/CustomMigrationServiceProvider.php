<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CustomMigrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MigrationRepositoryInterface::class, function ($app) {
            $connectionResolver = $app->make(ConnectionResolverInterface::class);
            $table = $app->make('config')->get('database.migrations');
            $this->app->make('log')->info("Creating DatabaseMigrationRepository with table: {$table}");

            return new DatabaseMigrationRepository($connectionResolver, $table);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
