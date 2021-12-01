<?php

declare(strict_types=1);

namespace Wnx\Sends\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as Orchestra;
use Wnx\Sends\Listeners\AttachCustomMessageIdListener;
use Wnx\Sends\Listeners\StoreOutgoingMailListener;
use Wnx\Sends\SendsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Wnx\\Sends\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        Event::listen(MessageSent::class, [StoreOutgoingMailListener::class, 'handle']);
    }

    protected function getPackageProviders($app)
    {
        return [
            SendsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('view.paths', [__DIR__.'/TestSupport/resources/views']);

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $migration = include __DIR__.'/../database/migrations/create_sends_table.php.stub';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/create_sendables_table.php.stub';
        $migration->up();

        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function addTransportMessageIdHeaderToMail(): void
    {
        Event::listen(MessageSending::class, [AttachCustomMessageIdListener::class, 'handle']);
    }
}
