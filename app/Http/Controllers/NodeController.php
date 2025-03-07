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

        $nodes = $client->nodes()->find();
        foreach($nodes as $node) {
            dump($node->getMetadata('name'));
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

    public Function patch() 
    {
        $client = $this->initializeApiClient();

        $nodeModel = new Node([
            "kind" => "Node",
            "apiVersion"=> "v1",
            "metadata"=> [
                "name"=> "first-node",
                "labels"=> [
                    "name"=> "my-first-k8s-node-update"
                ],
                "annotations" => [
                    "node.alpha.kubernetes.io/ttl" => "1"
                ]             
            ],
            "spec" => [
                "podCIDRs" => [""]
            ]
        ]);
        $node = $client->nodes()->patch($nodeModel);
        dump($node);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $nodeName = 'first-node';
        $nodeModel = $client->nodes()->find([ 'name' => $nodeName]);

        $node = $client->nodes()->delete($nodeModel[0]);
        dump($node);
    }
}
