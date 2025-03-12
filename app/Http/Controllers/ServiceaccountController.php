<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\KubernatesAPiClient;
use Maclof\Kubernetes\Models\ServiceAccount;

class ServiceaccountController extends Controller
{
    use KubernatesAPiClient;

    public function index()
    {
        $client = $this->initializeApiClient();

        $serviceAccounts = $client->serviceAccounts()->find();
      
        foreach($serviceAccounts as $serviceAccount) {
            dump($serviceAccount->getMetadata('name'));
        }
    }

    public function exist()
    {
        $client = $this->initializeApiClient();
        $exist = $client->serviceAccounts()->exists('my-service-account');
        dump($exist);
    }
}
