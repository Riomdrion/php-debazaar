<?php

namespace Tests;

use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;


    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }


    public function driver()
    {
        $options = (new \Facebook\WebDriver\Chrome\ChromeOptions)
            ->addArguments(['--disable-gpu', '--headless']);

        $capabilities = \Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
        $capabilities->setCapability(
            \Facebook\WebDriver\Chrome\ChromeOptions::CAPABILITY, $options
        );

        return \Facebook\WebDriver\Remote\RemoteWebDriver::create(
            'http://localhost:50942', $capabilities
        );
    }



    protected function rodin(): User
    {
        return User::firstOrCreate(
            ['email' => 'rodin@example.com'],
            [
                'name' => 'Rodin',
                'password' => bcrypt('password4'),
                'email_verified_at' => now(),
            ]
        );
    }
}
