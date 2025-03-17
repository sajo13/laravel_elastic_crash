<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\CronJob;

class CronjobController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $cronJobs = $client->cronJobs()->find();
      
        foreach($cronJobs as $job) {
            dump($job->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->cronJobs()->exists('example-job');
        dump($exist);
    }
}
