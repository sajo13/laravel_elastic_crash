<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\ConfigMap;

class ConfigmapController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $configMaps = $client->configMaps()->find();
        foreach($configMaps as $configMap) {
            dump($configMap->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->configMaps()->exists('kube-root-ca.crt');
        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $ConfigMap = new ConfigMap([
            'apiVersion' => 'v1',
            'kind' => 'ConfigMap',
            'metadata' => [
                'name' => 'game-demo',
            ],
            'data' => [
                'player_initial_lives' =>  '3',
                'ui_properties_file_name' => 'user-interface.properties'
            ]
        ]);        
        
        $ConfigMap = $client->configMaps()->create($ConfigMap);
        dump($ConfigMap);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $ConfigMap = new ConfigMap([
            'metadata' => [
                'name' => 'game-demo',
            ],
            'data' => [
                'player_initial_lives' =>  '5',
                'ui_properties_file_name' => 'user-interface.properties2'
            ]
        ]);        
        
        $ConfigMap = $client->configMaps()->patch($ConfigMap);
        dump($ConfigMap);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'game-demo';
        $configMaps = $client->configMaps()->find([ 'name' => $name]);
        $result = $client->configMaps()->delete($configMaps[1]);
        dump($result);
    }
}
