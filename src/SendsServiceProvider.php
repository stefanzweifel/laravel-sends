<?php

declare(strict_types=1);

namespace Wnx\Sends;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SendsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-sends')
            ->hasConfigFile()
            ->hasMigrations(['create_sends_table', 'create_sendables_table']);
    }
}
