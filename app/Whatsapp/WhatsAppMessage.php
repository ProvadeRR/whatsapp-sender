<?php

namespace App\Whatsapp;

final class WhatsAppMessage
{
    public function __construct(private readonly string $body)
    {

    }

    public function getBody(): string
    {
        return $this->body;
    }
}
