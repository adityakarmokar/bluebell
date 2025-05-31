<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load the custom admin route file
        Route::middleware('web')
            ->group(base_path('storage/framework/testing/test.php'));
    }
}
