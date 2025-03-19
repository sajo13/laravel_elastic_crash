<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Role;

class RoleController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $roles = $client->roles()->find();
      
        foreach($roles as $role) {
            dump($role->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->roles()->exists('pod-reader');
        dump($exist);
    }

    public function create()
    {
        $client = $this->initializeApiClient();

        $role = new Role([
            "apiVersion" => "rbac.authorization.k8s.io/v1",
            "kind" => "Role",
            "metadata" => [
                "namespace" => "default",
                "name" => "pod-reader2"
            ],
            "rules" => [
                [
                    "apiGroups" => [""],
                    "resources" => ["pods"],
                    "verbs" => ["get", "watch", "list"]
                ]
            ]
        ]);

        $role = $client->roles()->create($role);
        dump($role);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $role = new Role([
            "metadata" => [
                "namespace" => "default",
                "name" => "pod-reader2"
            ],
            "rules" => [
                [
                    "apiGroups" => [""],
                    "resources" => ["pods"],
                    "verbs" => ["get", "list"]
                ]
            ]
        ]);

        $role = $client->roles()->patch($role);
        dump($role);
    }
}
