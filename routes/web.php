<?php

use Illuminate\Support\Facades\Route;
use Maclof\Kubernetes\Client;
use GuzzleHttp\Client as GuzzleClient;

Route::get('/client-connect', function() {

    $httpClient = new GuzzleClient([
        'verify' => false,
    ]);
    $client = new Client([
        'master' => 'https://172.30.49.52:6443',
        'token' => env('token')
    ], null, $httpClient);

    dump($client);
});
