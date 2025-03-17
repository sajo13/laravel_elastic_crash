<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Deployment;

class DeployController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $deployments = $client->deployments()->find();
      
        foreach($deployments as $deployment) {
            dump($deployment->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->deployments()->exists('ngnix-deployment');
   
        dump($exist);
    }

    public function create()
    {
        $client = $this->initializeApiClient();

        $deployment = new Deployment([
            'apiVersion' => 'apps/v1',
            'kind' => 'Deployment',
            'metadata' => [
                'name' => 'phpmyadmin-deployment',
                'labels' => [
                    'app' => 'phpmyadmin',
                ],
            ],
            'spec' => [
                'replicas' => 1,
                'selector' => [
                    'matchLabels' => [
                        'app' => 'phpmyadmin',
                    ],
                ],
                'template' => [
                    'metadata' => [
                        'labels' => [
                            'app' => 'phpmyadmin',
                        ],
                    ],
                    'spec' => [
                        'containers' => [
                            [
                                'name' => 'phpmyadmin',
                                'image' => 'phpmyadmin/phpmyadmin',
                                'ports' => [
                                    [
                                        'containerPort' => 80,
                                    ],
                                ],
                                'env' => [
                                    [
                                        'name' => 'PMA_HOST',
                                        'value' => 'your-mysql-service-name',
                                    ],
                                    [
                                        'name' => 'PMA_PORT',
                                        'value' => '3306',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $deployments = $client->deployments()->create($deployment);
        dump($deployments);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $deployment = new Deployment([
            'metadata' => [
                'name' => 'phpmyadmin-deployment',
                'labels' => [
                    'app' => 'phpmyadmin',
                ],
            ],
            'spec' => [
                'replicas' => 3,
                'selector' => [
                    'matchLabels' => [
                        'app' => 'phpmyadmin',
                    ],
                ],
            ],
        ]);

        $deployments = $client->deployments()->patch($deployment);
        dump($deployments);
    }
}
