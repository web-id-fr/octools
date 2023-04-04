<?php

namespace Tests;

use CreateOctoolsTable;
use Dotenv\Dotenv;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\Setup\Migrations\CreateUsersTable;
use Tests\Setup\Models\User;
use Webid\Octools\Models\Application;
use Webid\Octools\OctoolsServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use DatabaseTransactions;

    public function actingAsApplication(Application $app): self
    {
        return $this->withHeader('Authorization', 'Bearer ' . $app->token);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->withFactories(__DIR__ . '/Setup/Factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            OctoolsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        config()->set('database.default', 'mysql');
        config()->set('database.connections.mysql', [
            'driver' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => [],
        ]);

        config()->set('octools.models.user', User::class);

        $this->dropTables();

        include_once __DIR__ . '/Setup/Migrations/create_users_tables.php';
        include_once __DIR__ . '/../database/migrations/create_octools_tables.php';

        (new CreateUsersTable())->up();
        (new CreateOctoolsTable())->up();
    }

    private function dropTables(): void
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            Schema::drop($table->Tables_in_octools_test);
        }
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");
    }
}

