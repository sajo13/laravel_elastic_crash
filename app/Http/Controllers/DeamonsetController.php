<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\DaemonSet;

class DeamonsetController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $daemonSets = $client->daemonSets()->find();
      
        foreach($daemonSets as $daemonSet) {
            dump($daemonSet->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->daemonSets()->exists('example-job');
        dump($exist);
    }
}
