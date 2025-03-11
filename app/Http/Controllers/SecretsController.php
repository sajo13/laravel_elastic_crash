<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Secret;

class SecretsController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $secrets = $client->secrets()->find();
        foreach($secrets as $secret) {
            dump($secret->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->secrets()->exists('default-token-trplz');
        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $secret = new Secret([
            'apiVersion' => 'v1',
            'kind' => 'Secret',
            'metadata' => [
                'name' => 'dotfile-secret',
            ],
            'data' => [
                '.secret-file' => 'dmFsdWUtMg0KDQo='
            ],
        ]);        
        
        $secret = $client->secrets()->create($secret);
        dump($secret);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $secret = new Secret([
            'metadata' => [
                'name' => 'dotfile-secret',
            ],
            'data' => [
                '.secret-file' => 'dtest123456='
            ],
        ]);        
        
        $secret = $client->secrets()->patch($secret);
        dump($secret);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'dotfile-secret';
        $service = $client->secrets()->find([ 'name' => $name]);
        $result = $client->secrets()->delete($service[2]);
        dump($result);
    }
}
