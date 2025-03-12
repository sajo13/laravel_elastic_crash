<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\PersistentVolume;

class PersistentvolumeclaimController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $persistentVolumeClaims = $client->persistentVolumeClaims()->find();
      
        foreach($persistentVolumeClaims as $persistentVolumeClaim) {
            dump($persistentVolumeClaim->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->persistentVolumeClaims()->exists('my-pvc');
        dump($exist);
    }
}
