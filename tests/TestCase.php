<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\Tests;

use Asseco\RemoteRelations\RemoteRelationsServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [RemoteRelationsServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
