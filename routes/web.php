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

Route::get('/aggregation-stats', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'all_stats' => [
                    'stats' => [
                        'field' => 'deaths'
                    ]
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/aggregation-extended-stats', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'date' => [
                    'extended_stats' => [
                        'field' => 'deaths'
                    ]
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/aggregation-cardinality', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'date' => [
                    'cardinality' => [
                        'field' => 'date'
                    ]
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/aggregation-death-asc', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'mytophits' => [
                    'terms' => [
                        'field' => 'deaths',
                        'size' => 10
                    ],
                    'aggs' => [
                        'tops' => [
                            'top_hits' => [
                                'sort' => [
                                    [
                                        'deaths' => 'asc'
                                    ]
                                ],
                                '_source' => [
                                    'includes' => 'country'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/aggregation-bucket', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'bucket' => [
                    'histogram' => [
                        'field' => 'deaths',
                        'interval' => 50000,
                        'min_doc_count' => 1
                    ]
                ]
            ]
        ]
    ];

    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/aggregation-range-bucket', function () {
    $params = [
        'index' => 'covid',
        'body' => [
            'aggs' => [
                'range' => [
                    'range' => [
                        "field" => 'deaths',
                        'ranges' => [
                            ['from' => 0, 'to' => 50000],
                            ['from' => 50000, 'to' => 100000],
                            ['from' => 100000, 'to' => 200000],
                            ['from' => 200000, 'to' => 400000]
                        ]
                    ]
                ]
            ]
        ]
    ];

    $resp = Elasticsearch::search($params);
    dump($resp);
});