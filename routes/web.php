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

#Match query - matches all books with given tags
Route::get('/match-with-tags', function () {
    $params = [
        'index' => 'books',
        'body' => [
            '_source' => false,
            'query' => [
                'match' => [
                    'tags' => 'Java programming'
                ]
            ],
                'highlight' => [
                'fields' => [
                    'tags' => new stdClass()
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/match-with-operator', function () {
    $params = [
        'index' => 'books',
        'body' => [
            '_source' => false,
            'query' => [
                'match' => [
                    'tags' => [
                        'query' => 'Design Pattern Programming',
                        'operator' =>  "AND"
                    ] 
                ]
            ],
                'highlight' => [
                'fields' => [
                    'tags' => new stdClass()
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/match-with-multi-fields', function () {
    $params = [
        'index' => 'books',
        'body' => [
            '_source' => false,
            'query' => [
                'multi_match' => [
                    'query'  => 'Java',
                    'fields' => ['tags', 'synopsis']
                ]
            ],
                'highlight' => [
                'fields' => [
                    'tags' => new stdClass(),
                    'synopsis' => new stdClass()
                ]
            ]
        ]
    ];
    $resp = Elasticsearch::search($params);
    dump($resp);
});