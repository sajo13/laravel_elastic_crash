<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Issuer;

class IssuerController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $issuers = $client->issuers()->find();
      
        foreach($issuers as $issuer) {
            dump($issuer->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->issuers()->exists('example-issuer');
        dump($exist);
    }

    public function create()
    {
        $client = $this->initializeApiClient();

        $issuer = new Issuer([
            "apiVersion" => "certmanager.k8s.io/v1alpha1",
            "kind" => "Issuer",
            "metadata" => [
                "name" => "my-issuer",
                "namespace" => "default"
            ],
            "spec" => [
                "acme" => [
                    "server" => "https://acme-v02.api.letsencrypt.org/directory",
                    "email" => "admin@example.com",
                    "privateKeySecretRef" => [
                        "name" => "acme-private-key"
                    ],
                    "solvers" => [
                        [
                            "http01" => [
                                "ingress" => [
                                    "class" => "nginx"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $issuer = $client->issuers()->create($issuer);
        dump($issuer);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $issuer = new Issuer([
            "metadata" => [
                "name" => "my-issuer",
                "namespace" => "default"
            ],
            "spec" => [
                "acme" => [
                    "server" => "https://acme-v02.api.letsencrypt.org/directory",
                    "email" => "admin123@example.com",
                    "privateKeySecretRef" => [
                        "name" => "acme-private-key"
                    ]
                ]
            ]
        ]);

        $issuer = $client->issuers()->patch($issuer);
        dump($issuer);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'issuers-example';
        $issuers = $client->cronJobs()->find([ 'name' => $name]);
        
        $result = $client->issuers()->delete($issuers[0]);
        dump($result);
    }
}
