<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\RoleBinding;

class RolebindController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $roleBindings = $client->roleBindings()->find();
      
        foreach($roleBindings as $roleBinding) {
            dump($roleBinding->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->roleBindings()->exists('pod-reader-binding');
        dump($exist);
    }
}
