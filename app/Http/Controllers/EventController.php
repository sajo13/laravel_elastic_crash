<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Event;

class EventController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $events = $client->events()->find();
        foreach($events as $event) {
            dump($event->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->events()->exists('laravel-replicationcontroller-v5xc8.182ba52f85d700d6');
        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $service = new Event([
            'apiVersion' => 'v1',
            'kind' => 'Event',
            'metadata' => [
                'name' => 'nginx-1-event',
                'namespace' => 'default',
            ],
            'type' => 'Normal',
            'reason' => 'Started',
            'message' => 'Started container nginx',
            'involvedObject' => [
                'kind' => 'Pod',
                'name' => 'nginx-1',
                'namespace' => 'default',
            ],
        ]);        
        
        $service = $client->events()->create($service);
        dump($service);
    }

    public Function update() 
    {
        $client = $this->initializeApiClient();

        $service = new Event([
            'metadata' => [
                'name' => 'nginx-1-event',
                'namespace' => 'default',
            ],
            'type' => 'Normal',
            'reason' => 'Stopped',
            'message' => 'Stopped container nginx'
        ]);        
        
        $service = $client->events()->patch($service);
        dump($service);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'nginx-1-event';
        $events = $client->events()->find([ 'name' => $name]);
        $result = $client->events()->delete($events[0]);
        dump($result);
    }
}
