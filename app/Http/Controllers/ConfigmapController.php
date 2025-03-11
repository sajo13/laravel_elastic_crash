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
}
