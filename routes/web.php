<?php

use Illuminate\Support\Facades\Route;
use MailerLite\LaravelElasticsearch\Facade as Elasticsearch;

Route::get('/aggregation-average', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'avg_deaths' => [
                    'avg' => [
                        'field' => 'deaths'
                    ]
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});