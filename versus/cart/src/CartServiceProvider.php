<?php
namespace Versus\Cart;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('cart', function() {
            return new \Versus\Cart\Cart;
        });
    }
}
