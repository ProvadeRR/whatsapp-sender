<?php

namespace App\Console\Commands;

use App\WebDriver\Selenium;
use Illuminate\Console\Command;

class SeleniumCleanSessionsCommand extends Command
{
    protected $signature = 'selenium:clean-sessions';

    protected $description = "Clean all sessions to selenium";

    /**
     * @throws \JsonException
     */
    public function handle(): void
    {
        app(Selenium::class)->closeActiveSessions();
        $this->info('Все сессии Selenium были закрыты.');
    }
}
