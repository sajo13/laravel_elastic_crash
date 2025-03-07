<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\NamespaceModel;

class NamespaceController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $namespaces = $client->namespaces()->find();
        foreach($namespaces as $namespace) {
            dump($namespace->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->namespaces()->exists('kube-system');

        dump($exist);
    }

    public Function create() 
    {
        $client = $this->initializeApiClient();

        $namespace = new NamespaceModel([
            "apiVersion" => "v1",
            "kind" => "Namespace",
            "metadata" => [
                "name" => "first-namespace"
            ]
        ]);
        $namespace = $client->namespaces()->create($namespace);
        dump($namespace);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'first-namespace';
        $namespaceModel = $client->namespaces()->find([ 'name' => $name]);
        $namespace = $client->namespaces()->delete($namespaceModel[4]);
        dump($namespace);
    }
}
