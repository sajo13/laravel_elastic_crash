<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Job;

class JobController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $jobs = $client->jobs()->find();
      
        foreach($jobs as $job) {
            dump($job->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->jobs()->exists('example-job');
        dd($client->jobs());
        dump($exist);
    }

    public function create()
    {
        $client = $this->initializeApiClient();

        $job = new job([
            'metadata' => [
                'name' => 'example-job-peer',
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

        $job = $client->jobs()->create($job);
        dump($job);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $job = new job([
            'kind' => 'Job',
            'apiVersion' => 'batch/v1',
            'metadata' => [
                'name' => 'example-job-peer',
                'namespace' => 'default',
            ],
            'spec' => [
                'parallelism' => 1,
                'completions' => 1,
                'backoffLimit' => 6,
                'selector' => [
                    'matchLabels' => [
                        'controller-uid' => '8def6d25-08d8-4268-9a98-84db8c51bae2',
                    ],
                ],
                'template' => [
                    'metadata' => [
                        'labels' => [
                            'controller-uid' => '8def6d25-08d8-4268-9a98-84db8c51bae2',
                            'job-name' => 'example-job-peer',
                        ],
                    ],
                    'spec' => [
                        'containers' => [
                            [
                                'name' => 'example-container',
                                'image' => 'nginx',
                            ],
                        ],
                        'restartPolicy' => 'Never',
                        'terminationGracePeriodSeconds' => 30,
                        'dnsPolicy' => 'ClusterFirst',
                        'securityContext' => [],
                        'schedulerName' => 'default-scheduler',
                    ],
                ],
            ],
        ]);

        $job = $client->jobs()->patch($job);
        dump($job);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'example-job-peer';
        $endpoint = $client->jobs()->find([ 'name' => $name]);
        
        $result = $client->jobs()->delete($endpoint[4]);
        dump($result);
    }
}
