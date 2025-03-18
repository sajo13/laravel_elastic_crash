<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\DaemonSet;

class DeamonsetController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $daemonSets = $client->daemonSets()->find();
      
        foreach($daemonSets as $daemonSet) {
            dump($daemonSet->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->daemonSets()->exists('example-job');
        dump($exist);
    }

    public function create()
    {
        $client = $this->initializeApiClient();

        $daemonSets = new DaemonSet($daemonSet = [
            'apiVersion' => 'apps/v1',
            'kind' => 'DaemonSet',
            'metadata' => [
                'name' => 'monitoring-agent',
                'namespace' => 'default',
            ],
            'spec' => [
                'selector' => [
                    'matchLabels' => [
                        'app' => 'monitoring-agent',
                    ],
                ],
                'template' => [
                    'metadata' => [
                        'labels' => [
                            'app' => 'monitoring-agent',
                        ],
                    ],
                    'spec' => [
                        'containers' => [
                            [
                                'name' => 'monitoring-agent',
                                'image' => 'monitoring-agent:1.0',
                                'resources' => [
                                    'limits' => [
                                        'memory' => '200Mi',
                                        'cpu' => '100m',
                                    ],
                                    'requests' => [
                                        'memory' => '100Mi',
                                        'cpu' => '50m',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $daemonSet = $client->daemonSets()->create($daemonSets);
        dump($daemonSet);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $daemonSets = new DaemonSet($daemonSet = [
            'metadata' => [
                'name' => 'monitoring-agent',
                'namespace' => 'default',
            ],
            'spec' => [
                'template' => [
                    'spec' => [
                        'containers' => [
                            [
                                'name' => 'monitoring-agent',
                                'image' => 'monitoring-agent:1.0',
                                'resources' => [
                                    'limits' => [
                                        'memory' => '200Mi',
                                        'cpu' => '110m',
                                    ],
                                    'requests' => [
                                        'memory' => '100Mi',
                                        'cpu' => '60m',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $daemonSet = $client->daemonSets()->patch($daemonSets);
        dump($daemonSet);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'monitoring-agent';
        $endpoint = $client->daemonSets()->find([ 'name' => $name]);
        
        $result = $client->daemonSets()->delete($endpoint[0]);
        dump($result);
    }
}
