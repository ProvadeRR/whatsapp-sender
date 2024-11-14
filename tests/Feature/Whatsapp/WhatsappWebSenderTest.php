<?php

namespace Tests\Feature\Whatsapp;

use App\WebDriver\WebDriverManager;
use App\Whatsapp\Whatsapp;
use App\Whatsapp\WhatsAppWeb;
use App\Whatsapp\WhatsAppWebSender;
use Tests\TestCase;

class WhatsappWebSenderTest extends TestCase
{
    protected Whatsapp $whatsapp;
    protected WebDriverManager $webDriverManager;
    public function setUp(): void
    {
        parent::setUp();
        $this->webDriverManager = new WebDriverManager();
        $this->whatsapp = new Whatsapp(new WhatsAppWebSender(new WhatsAppWeb($this->webDriverManager)));
    }

    public function tearDown(): void
    {
        $this->webDriverManager->stopDriver();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_user_can_send_a_message_to_whatsapp(): void
    {
        $user = 'Станислав Карноза';
        $message = 'Привет сейчас ' . date('H:i') . ' часов дня!';
        $this->whatsapp->sendMessage($user, $message);
        $this->whatsapp->sendSpam($user, 5);
    }
    /**
     * @test
     */
    public function it_user_can_send_a_spam_to_whatsapp(): void
    {
        /** @var Whatsapp $whatsapp */
        $whatsapp = resolve(Whatsapp::class);
        $user = 'Станислав Карноза';
        $whatsapp->sendSpam($user, 5);

        $this->webDriverManager->stopDriver();
    }
}
