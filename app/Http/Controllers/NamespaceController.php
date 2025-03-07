<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Node;

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
}
