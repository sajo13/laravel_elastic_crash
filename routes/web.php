<?php

use Illuminate\Support\Facades\Route;
use Maclof\Kubernetes\Client;
use GuzzleHttp\Client as GuzzleClient;
use Maclof\Kubernetes\Models\Job;

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


    $jobModel = new Job([
        'metadata' => [
            'name' => 'example-job',
        ],
        'spec' => [
            'template' => [
                'spec' => [
                    'containers' => [
                        [
                            'name' => 'example-container',
                            'image' => 'nginx',
                        ],
                    ],
                    'restartPolicy' => 'Never',
                ],
            ],
        ],
    ]);

    $jobs = $client->jobs()->create($jobModel);
    // dd($jobs);

    // Fetch the existing job
    $jobName = 'example-job';
    $job = $client->jobs()->find([ 'name' => $jobName]);

    // dd($job[0]);
    $job = $client->jobs()->delete($job[0]);
    dump($job);
});

Route::get('/job-update', function() {

    $httpClient = new GuzzleClient([
        'verify' => false,
    ]);
    $client = new Client([
        'master' => 'https://172.30.49.52:6443',
        'token' => env('token')
    ], null, $httpClient);

    $jobModel = new Job([
        'metadata' => [
            'name' => 'example-job',
        ],
        'spec' => [
            'selector' => [
                'matchLabels' => [
                    'controller-uid' => '5f528320-04f2-448a-b51f-3cd189f2d84c',
                ],
            ],
            'template' => [
                'metadata' => [
                    'labels' => [
                        'controller-uid' => '5f528320-04f2-448a-b51f-3cd189f2d84c',
                        'job-name' => 'example-job',
                    ],
                ],
                'spec' => [
                    'containers' => [
                        [
                            'name' => 'example-container',
                            'image' => 'nginx',
                        ],
                    ],
                    'restartPolicy' => 'Never'
                ],
            ]
        ],
    ]);
    

    // Now update the job using the update function
    $response = $client->jobs()->update($jobModel);

    dd($response['status']);
});