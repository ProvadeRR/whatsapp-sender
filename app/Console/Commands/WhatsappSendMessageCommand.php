<?php

namespace App\Console\Commands;

use App\WebDriver\WebDriverManager;
use App\Whatsapp\Whatsapp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class WhatsappSendMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:send-message {--to=} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message to WhatApp';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $to = $this->option('to');
        $message = $this->option('message');

        if(empty($to) || empty($message)) {
            $this->error('Please provide --to and --message options.');
            return;
        }

        Artisan::call('selenium:clean-sessions');

        try {
            $this->info("Sending message to: {$to}");
            app(Whatsapp::class)->sendMessage($to, $message);
            app(WebDriverManager::class)->stopDriver();
            $this->info('Message sent successfully!');
        } catch (\Exception $e) {
            $this->error("Failed to send message: {$e->getMessage()}");
        }
    }
}
