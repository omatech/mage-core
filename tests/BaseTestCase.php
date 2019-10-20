<?php

namespace Omatech\Mage\Core\Tests;

use Orchestra\Testbench\TestCase;
use Omatech\Mage\Core\MageServiceProvider;
use Omatech\Mage\Core\Tests\Shared\Bindings;
use Omatech\Mage\Core\Tests\Shared\Factories;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseTestCase extends TestCase
{
    use Bindings;
    use Factories;
    use RefreshDatabase;

    public $usersDBTable;

    public function setUp(): void
    {
        parent::setUp();

        $this->bindings();

        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/../src/database/migrations');

        $this->artisan('migrate')->run();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    public function getPackageProviders($app)
    {
        return [
            MageServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => __DIR__.'/../testing.sqlite',
            'prefix'   => '',
        ]);

        //Override configuration for testing
        $app['config']->set('auth.providers.users.model', 'Omatech\Mage\Core\Models\User');

        $class = $app['config']->get('auth.providers.users.model');
        $table = (new $class)->getTable();
        $this->usersDBTable = $table;
    }
}
