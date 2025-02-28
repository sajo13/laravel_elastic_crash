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