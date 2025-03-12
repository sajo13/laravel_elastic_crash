<?php

use Illuminate\Support\Facades\Route;
use Maclof\Kubernetes\Client;
use GuzzleHttp\Client as GuzzleClient;
use Maclof\Kubernetes\Models\Job;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\NamespaceController;
use App\Http\Controllers\PodController;
use App\Http\Controllers\ReplicasetController;
use App\Http\Controllers\ReplicationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SecretsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ConfigmapController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\ServiceaccountController;

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


Route::get('/job-patch', function() {

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
    $response = $client->jobs()->patch($jobModel);

    dd($response['status']);
});

/**
 * Delete a model by name.
 */
Route::get('/job-delete', function() {

    $httpClient = new GuzzleClient([
        'verify' => false,
    ]);
    $client = new Client([
        'master' => 'https://172.30.49.52:6443',
        'token' => env('token')
    ], null, $httpClient);

    // Fetch the existing job
    $jobName = 'example-job1';
    $job = $client->jobs()->find(['name' => $jobName]);

    $job = $client->jobs()->delete($job[0]);
    dump($job);
});

Route::get('/job-list-first', function() {

    $httpClient = new GuzzleClient([
        'verify' => false,
    ]);
    $client = new Client([
        'master' => 'https://172.30.49.52:6443',
        'token' => env('token')
    ], null, $httpClient);

    // Fetch the existing job
    $first_job = $client->jobs()->find()->first();

    dump($first_job);
});

Route::get('/job-exist-check', function() {

    $httpClient = new GuzzleClient([
        'verify' => false,
    ]);
    $client = new Client([
        'master' => 'https://172.30.49.52:6443',
        'token' => env('token')
    ], null, $httpClient);

    // Fetch the existing job
    $exist = $client->jobs()->exists('example_job4');

    dump($exist);
});

Route::get('/job-list', function() {

    $httpClient = new GuzzleClient([
        'verify' => false,
    ]);
    $client = new Client([
        'master' => 'https://172.30.49.52:6443',
        'token' => env('token')
    ], null, $httpClient);

    $jobs = $client->jobs()->find();
    foreach($jobs as $job) {
        dump($job->getMetadata('name'));
    }
});

Route::get('/nodes-list', [NodeController::class, 'index']);
Route::get('/node-exist', [NodeController::class, 'exist']);
Route::get('/node-create', [NodeController::class, 'create']);
Route::get('/node-patch', [NodeController::class, 'patch']);
Route::get('/node-delete', [NodeController::class, 'delete']);

Route::get('/namespace-list', [NamespaceController::class, 'index']);
Route::get('/namespace-exist', [NamespaceController::class, 'exist']);
Route::get('/namespace-create', [NamespaceController::class, 'create']);
Route::get('/namespace-delete', [NamespaceController::class, 'delete']);

Route::get('/pod-list', [PodController::class, 'index']);
Route::get('/pod-exist', [PodController::class, 'exist']);
Route::get('/pod-create', [PodController::class, 'create']);
Route::get('/pod-update', [PodController::class, 'update']);
Route::get('/pod-delete', [PodController::class, 'delete']);

Route::get('/replicaset-list', [ReplicasetController::class, 'index']);
Route::get('/replicaset-exist', [ReplicasetController::class, 'exist']);
Route::get('/replicaset-create', [ReplicasetController::class, 'create']);
Route::get('/replicaset-update', [ReplicasetController::class, 'update']);
Route::get('/replicaset-delete', [ReplicasetController::class, 'delete']);

Route::get('/replication-list', [ReplicationController::class, 'index']);
Route::get('/replication-exist', [ReplicationController::class, 'exist']);
Route::get('/replication-create', [ReplicationController::class, 'create']);
Route::get('/replication-update', [ReplicationController::class, 'update']);
Route::get('/replication-delete', [ReplicationController::class, 'delete']);

Route::get('/service-list', [ServiceController::class, 'index']);
Route::get('/service-exist', [ServiceController::class, 'exist']);
Route::get('/service-create', [ServiceController::class, 'create']);
Route::get('/service-update', [ServiceController::class, 'update']);
Route::get('/service-delete', [ServiceController::class, 'delete']);

Route::get('/secret-list', [SecretsController::class, 'index']);
Route::get('/secret-exist', [SecretsController::class, 'exist']);
Route::get('/secret-create', [SecretsController::class, 'create']);
Route::get('/secret-update', [SecretsController::class, 'update']);
Route::get('/secret-delete', [SecretsController::class, 'delete']);

Route::get('/event-list', [EventController::class, 'index']);
Route::get('/event-exist', [EventController::class, 'exist']);
Route::get('/event-create', [EventController::class, 'create']);
Route::get('/event-update', [EventController::class, 'update']);
Route::get('/event-delete', [EventController::class, 'delete']);

Route::get('/configmap-list', [ConfigmapController::class, 'index']);
Route::get('/configmap-exist', [ConfigmapController::class, 'exist']);
Route::get('/configmap-create', [ConfigmapController::class, 'create']);
Route::get('/configmap-update', [ConfigmapController::class, 'update']);
Route::get('/configmap-delete', [ConfigmapController::class, 'delete']);

Route::get('/endpoint-list', [EndpointController::class, 'index']);
Route::get('/endpoint-exist', [EndpointController::class, 'exist']);
Route::get('/endpoint-create', [EndpointController::class, 'create']);
Route::get('/endpoint-update', [EndpointController::class, 'update']);
Route::get('/endpoint-delete', [EndpointController::class, 'delete']);

Route::get('/serviceaccount-list', [ServiceaccountController::class, 'index']);
Route::get('/serviceaccount-exist', [ServiceaccountController::class, 'exist']);