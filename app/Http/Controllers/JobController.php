<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Job;

class JobController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $jobs = $client->jobs()->find();
      
        foreach($jobs as $job) {
            dump($job->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->jobs()->exists('example-job');
        dd($client->jobs());
        dump($exist);
    }
}
