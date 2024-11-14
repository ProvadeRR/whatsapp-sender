<?php

namespace App\Whatsapp;

final class Whatsapp
{
    public function __construct(private readonly WhatsappSender $sender)
    {

    }

    public function sendMessage(mixed $to, string $message): void
    {
        $this->sender->send($to, new WhatsAppMessage($message));
    }

    public function sendSpam(mixed $to, int $countMessages): void
    {
       $this->sender->sendSpam($to, $countMessages);
    }
}
