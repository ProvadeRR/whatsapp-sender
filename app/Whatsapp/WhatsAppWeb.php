<?php

namespace App\Whatsapp;

use App\WebDriver\WebDriverManager;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

final class WhatsAppWeb
{
    private const URL = 'https://web.whatsapp.com';
    private string $openedDialog = '';

    public function __construct(private readonly WebDriverManager $driverManager)
    {
        $this->driverManager->startDriver()->get(self::URL);
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     * @throws \Exception
     */
    public function sendMessage(string $to, string $message): void
    {
        $this->openDialog($to);
        $this->writeMessage($message);
        $this->submitMessage();
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     * @throws \Exception
     */
    private function openDialog(string $to): void
    {
        if ($this->openedDialog === $to) {
            return;
        }

        $driver = $this->driverManager->startDriver();
        sleep(random_int(5,10));
        $this->searchContact($to);
        $listItems = $driver->findElements(WebDriverBy::cssSelector('div[role="listitem"]'));

        foreach ($listItems as $item) {
            try {
                $gridcell = $item->findElement(WebDriverBy::cssSelector('div[role="gridcell"]'));
                $gridcell->click();
                break;
            } catch (\Exception $e) {
                continue;
            }
        }

        $this->openedDialog = $to;
    }

    /**
     * @throws \Exception
     */
    private function searchContact(string $to): void
    {
        WebDriverExpectedCondition::elementToBeClickable(
            $by = WebDriverBy::cssSelector('div[aria-autocomplete="list"]')
        );

        $element = $this->driverManager->startDriver()->findElement($by);
        $element->click();
        $element->clear();
        $element->sendKeys($to);
        sleep(random_int(2, 5));
    }

    /**
     * @throws NoSuchElementException
     * @throws TimeoutException
     * @throws \Exception
     */
    private function writeMessage(string $message): void
    {
        $driver = $this->driverManager->startDriver();
        $driver->wait()->until(
            WebDriverExpectedCondition::elementToBeClickable(
                $by = WebDriverBy::cssSelector('div[aria-placeholder="Введите сообщение"]')
            )
        );

        $element = $driver->findElement($by);
        $element->click();
        $element->clear();
        $element->sendKeys($message);

        sleep(random_int(2, 5));
    }
    /**
     * @throws \Exception
     */
    private function submitMessage(): void
    {
        $sendButton = $this->driverManager->startDriver()->findElement(WebDriverBy::xpath('//button[@aria-label="Отправить"]'));
        $sendButton->click();

        sleep(random_int(2, 5));
    }
}
