<?php

namespace App\WebDriver;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverDimension;

final class WebDriverManager
{
    private const SELENIUM_HOST = 'http://selenium-router:4444';
    private ?RemoteWebDriver $driver = null;

    public function startDriver(): RemoteWebDriver
    {
        if ($this->driver) {
            return $this->driver;
        }

        $options = new ChromeOptions();
        $options->addArguments([
            'user-data-dir=/tmp/chrome_data',
            'profile-directory=Profile 1',
            'no-sandbox',
            'disable-infobars',
            'disable-gpu',
        ]);
        $options->setExperimentalOption('excludeSwitches', ['enable-automation']);
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options->toArray());
        $this->driver = RemoteWebDriver::create(self::SELENIUM_HOST, $capabilities);

        return $this->driver;
    }

    public function stopDriver(): void
    {
        if ($this->driver) {
            $this->driver->quit();
            $this->driver = null;
        }
    }
}
