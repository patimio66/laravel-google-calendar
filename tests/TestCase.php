<?php

namespace Patimio66\GoogleCalendar\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Patimio66\GoogleCalendar\GoogleCalendarServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    use MockeryPHPUnitIntegration;

    /** @var string */
    protected $calendarId;

    protected function getPackageProviders($app): array
    {
        return [
            GoogleCalendarServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('laravel-google-calendar.calendar_id', $this->calendarId = 'personal');
    }
}
