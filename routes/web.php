<?php

use Illuminate\Support\Facades\Route;
use MailerLite\LaravelElasticsearch\Facade as Elasticsearch;

Route::get('/', function () {

    // $data = [
    //     'index' => 'my_index',  // The name of the index
    //     'body'  => [            // The document data to be stored
    //             'testField' => 'abc'
    //     ],
    //     'id' => 'my_id',
    // ];
    
    // $return = Elasticsearch::index($data);

    $params = [
        'index' => 'my_index',
        'id'    => 'my_id'
    ];

    // Get doc at /my_index/_doc/my_id
    $return = Elasticsearch::get($params);
    dd($return['_source']);

    // return view('welcome');
});
