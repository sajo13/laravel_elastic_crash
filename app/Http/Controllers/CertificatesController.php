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
}
