<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\Certificate;

class CertificatesController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $certificates = $client->certificates()->find();

        foreach($certificates as $certificate) {
            dump($certificate->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->certificates()->exists('example-certificate');
        dump($exist);
    }

    public function create()
    {
        $client = $this->initializeApiClient();

        $certificates = new Certificate([
            "apiVersion" => "certmanager.k8s.io/v1alpha1",
            "kind" => "Certificate",
            "metadata" => [
                "name" => "my-cert",
                "namespace" => "default"
            ],
            "spec" => [
                "secretName" => "my-cert-tls",
                "issuerRef" => [
                    "name" => "my-issuer",
                    "kind" => "Issuer"
                ],
                "commonName" => "172.30.49.52",
                "dnsNames" => [
                    "172.30.49.52"
                ],
                "acme" => [
                    "config" => [
                        [
                            "http01" => [
                                "ingressClass" => "nginx"
                            ],
                            "domains" => [
                                "172.30.49.52"
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $certificates = $client->certificates()->create($certificates);
        dump($certificates);
    }

    public function update()
    {
        $client = $this->initializeApiClient();

        $certificates = new Certificate([
            "apiVersion" => "certmanager.k8s.io/v1alpha1",
            "kind" => "Certificate",
            "metadata" => [
                "name" => "my-cert",
                "namespace" => "default"
            ],
            "spec" => [
                "secretName" => "my-cert-tls",
                "issuerRef" => [
                    "name" => "my-issuer",
                    "kind" => "Issuer"
                ],
                "commonName" => "172.30.49.22",
                "dnsNames" => [
                    "172.30.49.22"
                ],
                "acme" => [
                    "config" => [
                        [
                            "http01" => [
                                "ingressClass" => "nginx"
                            ],
                            "domains" => [
                                "172.30.49.22"
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $certificates = $client->certificates()->patch($certificates);
        dump($certificates);
    }

    public Function delete() 
    {
        $client = $this->initializeApiClient();

        $name = 'issuers-example';
        $certificates = $client->certificates()->find([ 'name' => $name]);
        
        $result = $client->certificates()->delete($certificates[0]);
        dump($result);
    }
}
