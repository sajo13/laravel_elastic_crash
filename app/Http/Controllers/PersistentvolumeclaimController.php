<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\PersistentVolumeClaim;

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

    public function create()
    {
        $client = $this->initializeApiClient();

        $persistentVolumeClaim = new PersistentVolumeClaim([
            'apiVersion' => 'v1',
            'kind' => 'PersistentVolumeClaim',
            'metadata' => [
                'name' => 'my-pvc',
                'namespace' => 'default',
            ],
            'spec' => [
                'accessModes' => [
                    'ReadWriteOnce',
                ],
                'resources' => [
                    'requests' => [
                        'storage' => '2Gi',
                    ],
                ],
                'storageClassName' => 'standard',
            ],
        ]);

        $persistentVolumeClaim = $client->persistentVolumeClaims()->create($persistentVolumeClaim);
        dump($persistentVolumeClaim);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $persistentVolumeClaim = new PersistentVolumeClaim([
            'metadata' => [
                'name' => 'my-pvc',
                'namespace' => 'default',
            ],
            'spec' => [
                'resources' => [
                    'requests' => [
                        'storage' => '3Gi',
                    ],
                ],
            ],
        ]);

        $persistentVolumeClaim = $client->persistentVolumeClaims()->patch($persistentVolumeClaim);
        dump($persistentVolumeClaim);
    }

    public function delete()
    {
        $client = $this->initializeApiClient();

        $name = 'my-pvc';
        $endpoint = $client->persistentVolumeClaims()->find([ 'name' => $name]);
        
        $result = $client->persistentVolumeClaims()->delete($endpoint[0]);
        dump($result);
    }
}
