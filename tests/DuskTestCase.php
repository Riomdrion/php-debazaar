<?php

namespace Tests;
use app\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
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
        $options = (new ChromeOptions)
            ->addArguments(['--disable-gpu', '--headless']);

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(
            ChromeOptions::CAPABILITY, $options
        );

        return RemoteWebDriver::create(
            'http://localhost:50765', $capabilities
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
