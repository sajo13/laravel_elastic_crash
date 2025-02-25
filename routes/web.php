<?php

use Illuminate\Support\Facades\Route;
use MailerLite\LaravelElasticsearch\Facade as Elasticsearch;

Route::get('/', function () {

    $data = [
        'index' => 'my_index',  // The name of the index
        'body'  => [            // The document data to be stored
                'testField' => 'abc'
        ]
    ];
    
    $return = Elasticsearch::index($data);

    dd($return);

    // return view('welcome');
});
