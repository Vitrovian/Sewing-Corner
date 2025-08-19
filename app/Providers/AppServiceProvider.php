<?php

namespace App\Providers;

use App\Services\LiqPayService;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        Paginator::defaultView('pagination::tailwind');
    }

    private function configureModels(): void
    {
        Model::shouldBeStrict();
    }
}
