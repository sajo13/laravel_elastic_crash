<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\ReplicaSet;

class ReplicasetController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $replicaSets = $client->replicaSets()->find();
        foreach($replicaSets as $replicaSet) {
            dump($replicaSet->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->replicaSets()->exists('nginx-deployment-585449566');
        dump($exist);
    }
}
