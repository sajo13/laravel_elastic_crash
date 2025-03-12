<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\PersistentVolume;

class PersistentvolumeController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $persistentVolumes = $client->persistentVolume()->find();
      
        foreach($persistentVolumes as $persistentVolume) {
            dump($persistentVolume->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->persistentVolume()->exists('my-persistent-volume');
        dump($exist);
    }
}
