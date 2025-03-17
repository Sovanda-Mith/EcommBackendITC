<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Payment;
use App\Observers\ModelActivityObserver;
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
        Order::observe(ModelActivityObserver::class);
        Category::observe(ModelActivityObserver::class);
        Product::observe(ModelActivityObserver::class);
        OrderProduct::observe(ModelActivityObserver::class);
        Wishlist::observe(ModelActivityObserver::class);
        Cart::observe(ModelActivityObserver::class);
        Customer::observe(ModelActivityObserver::class);
        Payment::observe(ModelActivityObserver::class);
    }
}
