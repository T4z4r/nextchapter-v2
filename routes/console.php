<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('packages:sync', function (\App\Services\PackageCatalogImporter $importer) {
    $stats = $importer->import();

    $this->info(sprintf(
        'Packages synced. %d created, %d updated, %d deleted, %d skipped.',
        $stats['created'],
        $stats['updated'],
        $stats['deleted'],
        $stats['skipped'],
    ));
})->purpose('Fetch packages from the remote BalancePoint API');
