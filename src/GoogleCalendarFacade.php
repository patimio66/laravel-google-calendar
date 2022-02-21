<?php

namespace Patimio66\GoogleCalendar;

use Illuminate\Support\Facades\Facade;

class GoogleCalendarFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-google-calendar';
    }
}
