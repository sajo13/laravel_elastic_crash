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

    public function create()
    {
        $client = $this->initializeApiClient();

        $role = new RoleBinding([
            "apiVersion" => "rbac.authorization.k8s.io/v1",
            "kind" => "RoleBinding",
            "metadata" => [
                "name" => "pod-reader-binding2",
                "namespace" => "default"
            ],
            "subjects" => [
                [
                    "kind" => "ServiceAccount",
                    "name" => "my-service-account",
                    "namespace" => "default"
                ]
            ],
            "roleRef" => [
                "kind" => "Role",
                "name" => "pod-reader",
                "apiGroup" => "rbac.authorization.k8s.io"
            ]
        ]);

        $role = $client->roleBindings()->create($role);
        dump($role);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $rolebind = new RoleBinding([
            "metadata" => [
                "name" => "pod-reader-binding2",
                "namespace" => "default"
            ],
            "subjects" => [
                [
                    "kind" => "ServiceAccount",
                    "name" => "my-service-account2",
                    "namespace" => "default"
                ]
            ],
            "roleRef" => [
                "kind" => "Role",
                "name" => "pod-reader",
                "apiGroup" => "rbac.authorization.k8s.io"
            ]
        ]);

        $rolebind = $client->roleBindings()->patch($rolebind);
        dump($rolebind);
    }
}
