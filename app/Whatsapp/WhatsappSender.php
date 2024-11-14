<?php

namespace App\Whatsapp;

interface WhatsappSender
{
    public function send(mixed $to, WhatsAppMessage $message);
    public function sendSpam(string $to, int $countMessages);
}
