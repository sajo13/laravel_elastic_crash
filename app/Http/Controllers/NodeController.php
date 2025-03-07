<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Node;

class NodeController extends Controller
{
    use KubernatesAPiClient;

    public Function index() 
    {
        $client = $this->initializeApiClient();

        $jobs = $client->nodes()->find();
        foreach($jobs as $job) {
            dump($job->getMetadata('name'));
        }
    }

    public Function exist() 
    {
        $client = $this->initializeApiClient();
        $exist = $client->nodes()->exists('prophz-sajo');

        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $nodeModel = new Node([
                "kind" => "Node",
                "apiVersion"=> "v1",
                "metadata"=> [
                  "name"=> "first-node",
                  "labels"=> [
                    "name"=> "my-first-k8s-node"
                  ]
                ]
        ]);
        $node = $client->nodes()->create($nodeModel);
        dump($node);
    }
}
