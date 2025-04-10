<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Pod;

class PodController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $pods = $client->pods()->find();
        dd($pods[9]);
        foreach($pods as $pod) {
            dump($pod->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->pods()->exists('example-job2-dj7js');

        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $pod = new Pod([
            'apiVersion' => 'v1',
            'kind' => 'Pod',
            'metadata' => [
                'name' => 'laravel-app-pod',
            ],
            'spec' => [
                'containers' => [
                    [
                        'name' => 'laravelapp',
                        'image' => 'laravel_elastic_crash_laravelapp:latest',
                        'ports' => [
                            [
                                'containerPort' => 8000
                            ]
                        ]
                    ]
                ]
            ]
        ]);
        
        $pod = $client->pods()->create($pod);
        dump($pod);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $updatePod = new Pod([
            'metadata' => [
                'name' => 'laravel-app-pod',
            ],
            'spec' => [
                'containers' => [
                    [
                        'name' => 'laravelapp',
                        'image' => 'laravel_elastic_crash_laravelapp:old',
                    ]
                ]
            ]
        ]);

        $pod = $client->pods()->patch($updatePod);
        dump($pod);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'laravel-app-pod';
        $namespaceModel = $client->pods()->find([ 'name' => $name]);
        $namespace = $client->pods()->delete($namespaceModel[9]);
        dump($namespace);
    }
}
