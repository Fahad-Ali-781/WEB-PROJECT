<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'products.index'], function ($view) {
            $categories = Schema::hasTable('categories') ? Category::all() : collect();
            $view->with('categories', $categories);
        });

        View::composer('layouts.app', function ($view) {
            $pendingOrdersCount = 0;

            if (Auth::check() && (Auth::user()->is_admin ?? false) && Schema::hasTable('orders')) {
                $pendingOrdersCount = Order::where('status', 'pending')->count();
            }

            $view->with('pendingOrdersCount', $pendingOrdersCount);
        });
    }
}
