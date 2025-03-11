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
}
