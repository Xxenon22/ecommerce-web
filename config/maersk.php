<?php

return [
    'base_url'   => env('MAERSK_API_BASE_URL', 'https://api.maersk.com'),
    'client_id'  => env('MAERSK_CLIENT_ID'),
    'secret'     => env('MAERSK_CLIENT_SECRET'),
    'timeout'    => 30,
];
