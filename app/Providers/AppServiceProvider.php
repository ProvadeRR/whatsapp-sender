<?php

namespace App\Providers;

use App\WebDriver\WebDriverManager;
use App\Whatsapp\WhatsappSender;
use App\Whatsapp\WhatsAppWebSender;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(WhatsappSender::class, WhatsAppWebSender::class);
        $this->app->singleton(WebDriverManager::class, WebDriverManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
