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


Route::get('/aggregation-sum', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'all_deaths' => [
                    'sum' => [
                        'field' => 'deaths'
                    ]
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/aggregation-min', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'min_cases' => [
                    'min' => [
                        'field' => 'cases'
                    ]
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/aggregation-max', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'max_critical' => [
                    'max' => [
                        'field' => 'critical'
                    ]
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});