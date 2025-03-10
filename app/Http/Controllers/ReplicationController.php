<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\ReplicationController As RepController;

class ReplicationController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $replicaSets = $client->replicationControllers()->find();
        foreach($replicaSets as $replicaSet) {
            dump($replicaSet->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->replicaSets()->exists('test-replication');
        dump($exist);
    }
}
