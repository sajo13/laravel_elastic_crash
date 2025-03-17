<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\CronJob;

class CronjobController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $cronJobs = $client->cronJobs()->find();
      
        foreach($cronJobs as $job) {
            dump($job->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->cronJobs()->exists('example-job');
        dump($exist);
    }

    public function create()
    {
        $client = $this->initializeApiClient();

        $job = new CronJob([
            'apiVersion' => 'batch/v1',
            'kind' => 'CronJob',
            'metadata' => [
                'name' => 'hello',
            ],
            'spec' => [
                'schedule' => '* * * * *',
                'jobTemplate' => [
                    'spec' => [
                        'template' => [
                            'spec' => [
                                'containers' => [
                                    [
                                        'name' => 'hello',
                                        'image' => 'busybox:1.28',
                                        'imagePullPolicy' => 'IfNotPresent',
                                        'command' => [
                                            '/bin/sh',
                                            '-c',
                                            'date; echo Hello from the Kubernetes cluster',
                                        ],
                                    ],
                                ],
                                'restartPolicy' => 'OnFailure',
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $job = $client->cronJobs()->create($job);
        dump($job);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $job = new CronJob([
            'metadata' => [
                'name' => 'hello',
            ],
            'spec' => [
                'schedule' => '* * * * *',
                'jobTemplate' => [
                    'spec' => [
                        'template' => [
                            'spec' => [
                                'restartPolicy' => 'Never',
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $job = $client->cronJobs()->patch($job);
        dump($job);
    }
}
