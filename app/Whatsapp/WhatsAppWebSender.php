<?php

namespace App\Whatsapp;

use Illuminate\Support\Facades\Log;

final class WhatsAppWebSender implements WhatsappSender
{
    public function __construct(
        private readonly WhatsAppWeb $web,
    ) {}

    public function send(mixed $to, WhatsAppMessage $message): void
    {
        try {
            $text = $message->getBody();
            $this->web->sendMessage($to, $text);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function sendSpam(string $to, int $countMessages): void
    {
        try {
            for ($i = 0; $i < $countMessages; $i++) {
                $messageText = fake('ru_RU')->realText(random_int(20, 60));
                $this->web->sendMessage($to, $messageText);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
