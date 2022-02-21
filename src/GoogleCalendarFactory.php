<?php

namespace Patimio66\GoogleCalendar;

use Google_Client;
use Google_Service_Calendar;
use Patimio66\GoogleCalendar\Exceptions\InvalidConfiguration;
use Illuminate\Support\Facades\Auth;

class GoogleCalendarFactory
{
    public static function createForCalendarId(string $calendarId): GoogleCalendar
    {
        $config = config('google-calendar');

        $client = self::createAuthenticatedGoogleClient($config);

        $service = new Google_Service_Calendar($client);

        return self::createCalendarClient($service, $calendarId);
    }

    public static function createAuthenticatedGoogleClient(array $config): Google_Client
    {
        $authProfile = $config['default_auth_profile'];

        if ($authProfile === 'service_account') {
            return self::createServiceAccountClient($config['auth_profiles']['service_account']);
        }
        if ($authProfile === 'oauth') {
            return self::createOAuthClient($config['auth_profiles']['oauth']);
        }
        if ($authProfile === 'user_oauth') {
            return self::createOAuthClientFromAuth($config['auth_profiles']['user_oauth']);
        }

        throw InvalidConfiguration::invalidAuthenticationProfile($authProfile);
    }

    protected static function createServiceAccountClient(array $authProfile): Google_Client
    {
        $client = new Google_Client;

        $client->setScopes([
            Google_Service_Calendar::CALENDAR,
        ]);

        $client->setAuthConfig($authProfile['credentials_json']);

        if (config('google-calendar')['user_to_impersonate']) {
            $client->setSubject(config('google-calendar')['user_to_impersonate']);
        }

        return $client;
    }

    protected static function createOAuthClient(array $authProfile): Google_Client
    {
        $client = new Google_Client;

        $client->setScopes([
            Google_Service_Calendar::CALENDAR,
        ]);

        $client->setAuthConfig($authProfile['credentials_json']);

        $client->setAccessToken(file_get_contents($authProfile['token_json']));

        return $client;
    }

    protected static function createOAuthClientFromAuth(array $authProfile): Google_Client
    {
        $client = new Google_Client;

        $client->setScopes([
            Google_Service_Calendar::CALENDAR,
        ]);

        $client->setAuthConfig($authProfile['credentials_json']);

        $user_token = Auth::guard($authProfile['guard'])->user()->{$authProfile['column']};

        $client->setAccessToken($user_token);

        return $client;
    }

    protected static function createCalendarClient(Google_Service_Calendar $service, string $calendarId): GoogleCalendar
    {
        return new GoogleCalendar($service, $calendarId);
    }
}
