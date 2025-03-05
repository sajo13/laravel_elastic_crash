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

    // dump($client);

    $pods = $client->pods()->setLabelSelector([
        'name'    => 'test',
        'version' => 'a',
    ])->find();
    // dump($pods);

    // Find pods by field selector
    $pods = $client->pods()->setFieldSelector([
        'metadata.name' => 'test',
    ])->find();
    // dump($pods);

    
    $pod = $client->pods()->setLabelSelector([
        'name' => 'nginx-deployment-585449566-6kt9r',
    ]);
    // dump($pod);

    // Find nodes by field selector
    $pods = $client->nodes()->setFieldSelector([
        'metadata.name' => 'test',
    ])->find();
    // dump($pods);

    $nodes = $client->nodes()->setLabelSelector([
        'name' => 'prophz-sajo',
    ]);
    // dump($nodes);

    $jobs = $client->jobs()->find();
    dump($jobs);
});

