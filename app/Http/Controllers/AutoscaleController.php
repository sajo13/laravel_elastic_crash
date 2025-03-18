<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\HorizontalPodAutoscaler;

class AutoscaleController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $autoScalers = $client->horizontalPodAutoscalers()->find();
      
        foreach($autoScalers as $autoScaler) {
            dump($autoScaler->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->horizontalPodAutoscalers()->exists('example-autoscaler');
        dump($exist);
    }
}
