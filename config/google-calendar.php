<?php

return [

    'default_auth_profile' => env('GOOGLE_CALENDAR_AUTH_PROFILE', 'service_account'),

    'auth_profiles' => [

        /*
         * Authenticate using a service account.
         */
        'service_account' => [
            /*
             * Path to the json file containing the credentials.
             */
            'credentials_json' => storage_path('app/google-calendar/service-account-credentials.json'),
        ],

        /*
         * Authenticate with actual google user account.
         */
        'oauth' => [
            /*
             * Path to the json file containing the oauth2 credentials.
             */
            'credentials_json' => storage_path('app/google-calendar/oauth-credentials.json'),

            /*
             * Path to the json file containing the oauth2 token.
             */
            'token_json' => storage_path('app/google-calendar/oauth-token.json'),
        ],

        /*
         * Authenticate with user's stored token.
         */
        'user_oauth' => [
            /*
             * Path to the json file containing the oauth2 credentials.
             */
            'credentials_json' => storage_path('app/google-calendar/oauth-credentials.json'),

            /*
             * Auth guard.
             */
            'guard' => 'web',

            /*
             * Column stored calendar token.
             */
            'column' => 'calendar_token',
        ],

        /*
         * Authenticate with user's stored token.
         */
        'userid_oauth' => [
            /*
             * Path to the json file containing the oauth2 credentials.
             */
            'credentials_json' => storage_path('app/google-calendar/oauth-credentials.json'),

            /*
             * Column stored calendar token.
             */
            'column' => 'calendar_token',
        ],
    ],

    /*
     *  The id of the Google Calendar that will be used by default.
     */
    'calendar_id' => env('GOOGLE_CALENDAR_ID'),

     /*
     *  The email address of the user account to impersonate.
     */
    'user_to_impersonate' => env('GOOGLE_CALENDAR_IMPERSONATE'),
];
