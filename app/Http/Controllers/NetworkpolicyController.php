<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\NetworkPolicy;

class NetworkpolicyController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $networkPolicies = $client->networkPolicies()->find();
      
        foreach($networkPolicies as $networkPolicie) {
            dump($networkPolicie->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->networkPolicies()->exists('example-policy');
        dump($exist);
    }

    public function create()
    {
        $client = $this->initializeApiClient();

        $networkPolicy = new NetworkPolicy([
            'apiVersion' => 'networking.k8s.io/v1',
            'kind' => 'NetworkPolicy',
            'metadata' => [
                'name' => 'test-network-policy',
                'namespace' => 'default',
            ],
            'spec' => [
                'podSelector' => [
                    'matchLabels' => [
                        'role' => 'db',
                    ],
                ],
                'policyTypes' => [
                    'Ingress',
                    'Egress',
                ],
                'ingress' => [
                    [
                        'from' => [
                            [
                                'ipBlock' => [
                                    'cidr' => '172.17.0.0/16',
                                    'except' => [
                                        '172.17.1.0/24',
                                    ],
                                ],
                            ],
                            [
                                'namespaceSelector' => [
                                    'matchLabels' => [
                                        'project' => 'myproject',
                                    ],
                                ],
                            ],
                            [
                                'podSelector' => [
                                    'matchLabels' => [
                                        'role' => 'frontend',
                                    ],
                                ],
                            ],
                        ],
                        'ports' => [
                            [
                                'protocol' => 'TCP',
                                'port' => 6379,
                            ],
                        ],
                    ],
                ],
                'egress' => [
                    [
                        'to' => [
                            [
                                'ipBlock' => [
                                    'cidr' => '10.0.0.0/24',
                                ],
                            ],
                        ],
                        'ports' => [
                            [
                                'protocol' => 'TCP',
                                'port' => 5978,
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $networkPolicy = $client->networkPolicies()->create($networkPolicy);
        dump($networkPolicy);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $networkPolicy = new NetworkPolicy([
            'metadata' => [
                'name' => 'test-network-policy',
                'namespace' => 'default',
            ],
            'spec' => [
                'egress' => [
                    [
                        'to' => [
                            [
                                'ipBlock' => [
                                    'cidr' => '10.0.0.0/30',
                                ],
                            ],
                        ],
                        'ports' => [
                            [
                                'protocol' => 'TCP',
                                'port' => 5980,
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $networkPolicy = $client->networkPolicies()->patch($networkPolicy);
        dump($networkPolicy);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'test-network-policy';
        $endpoint = $client->networkPolicies()->find([ 'name' => $name]);
        
        $result = $client->networkPolicies()->delete($endpoint[0]);
        dump($result);
    }
}
