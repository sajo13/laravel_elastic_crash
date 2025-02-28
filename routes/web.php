<?php

use Illuminate\Support\Facades\Route;
use MailerLite\LaravelElasticsearch\Facade as Elasticsearch;

Route::get('/match-all', function () {
    $params = [
        'index' => 'books',
        'body' => [
            'query' => [
                'match_all' => new stdClass()
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/match-all-boost', function () {
    $params = [
        'index' => 'books',
        'body' => [
            'query' => [
                'match_all' => ['boost' => 2.0]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});