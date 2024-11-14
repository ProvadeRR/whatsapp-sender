<?php

namespace App\WebDriver;

use Illuminate\Support\Facades\Http;

class Selenium
{
    public const HOST = 'http://selenium-router:4444';

    public function closeActiveSessions(): void
    {
        $sessions = $this->getActiveSessionIds();

        foreach ($sessions as $sessionId) {
            $this->closeSession($sessionId);
        }
    }

    private function getActiveSessionIds(): array
    {
        $response = Http::get(self::HOST . '/status')->json();

        $nodes = $response['value']['nodes'] ?? [];

        $sessions = [];

        foreach ($nodes as $node) {
            foreach ($node['slots'] ?? [] as $slot) {
                if (isset($slot['session']['sessionId'])) {
                    $sessions[] = $slot['session']['sessionId'];
                }
            }
        }

        return $sessions;
    }

    private function closeSession(string $sessionId): void
    {
        Http::delete(self::HOST . '/session/' . $sessionId);
    }
}
