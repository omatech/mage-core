<?php

namespace Omatech\Mage\Core\Tests;

use Orchestra\Testbench\TestCase;
use Omatech\Mage\Core\Models\User;
use Omatech\Mage\Core\MageServiceProvider;
use Omatech\Mage\Core\Tests\Shared\Factories;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseTestCase extends TestCase
{
    use Factories;
    use RefreshDatabase;

    public $usersDBTable;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('vendor:publish --tag=mage-migrations')->run();
        $this->artisan('migrate')->run();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    public function getPackageProviders($app): array
    {
        return [
            MageServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', env('DB_CONNECTION'));

        $app['config']->set('database.connections.mysql', [
            'driver'   => 'mysql',
            'host'     => env('DB_TEST_HOST'),
            'database' => env('DB_TEST_DATABASE'),
            'username' => env('DB_TEST_USERNAME'),
            'password' => env('DB_TEST_PASSWORD'),
        ]);

        //Override configuration for testing
        $app['config']->set('auth.providers.users.model', User::class);

        $class = $app['config']->get('auth.providers.users.model');
        $table = (new $class())->getTable();
        $this->usersDBTable = $table;
    }
}
