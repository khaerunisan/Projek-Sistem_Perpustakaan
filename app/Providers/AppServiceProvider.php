<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Tambahan: Import Paginator

class AppServiceProvider extends ServiceProvider
{
    
    public const HOME = '/dashboard';

   
    public function register(): void
    {
        //
    }

    
    public function boot(): void
    {
        Paginator::useTailwind();
    }
}