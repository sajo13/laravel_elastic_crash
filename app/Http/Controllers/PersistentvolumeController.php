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

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $persistentVolume = new PersistentVolume([
            'apiVersion' => 'v1',
            'kind' => 'PersistentVolume',
            'metadata' => [
                'name' => 'my-persistent-volume',
            ],
            'spec' => [
                'capacity' => [
                    'storage' => '5Gi',
                ],
                'accessModes' => [
                    'ReadWriteOnce',
                ],
                'persistentVolumeReclaimPolicy' => 'Retain',
                'storageClassName' => 'standard',
                'hostPath' => [
                    'path' => '/mnt/data',
                ],
            ],
        ]);     

        $persistentVolume = $client->persistentVolume()->create($persistentVolume);
        dump($persistentVolume);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $persistentVolume = new PersistentVolume([
            'metadata' => [
                'name' => 'my-persistent-volume',
            ],
            'spec' => [
                'accessModes' => [
                    'ReadWriteMany',
                ],
                'persistentVolumeReclaimPolicy' => 'Delete',
            ],
        ]);     

        $persistentVolume = $client->persistentVolume()->patch($persistentVolume);
        dump($persistentVolume);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'my-persistent-volume';
        $endpoint = $client->persistentVolume()->find([ 'name' => $name]);
        
        $result = $client->persistentVolume()->delete($endpoint[0]);
        dump($result);
    }
}
