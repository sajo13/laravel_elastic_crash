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

    // $params = [
    //     'index' => 'my_index',
    //     'id'    => 'my_id'
    // ];

    // // Get doc at /my_index/_doc/my_id
    // $return = Elasticsearch::get($params);
    // dd($return['_source']);


    // $params = [
    //     'index' => 'my_index',
    //     'body'  => [
    //         'query' => [
    //             'match' => [
    //                 'testField' => 'abc'
    //             ]
    //         ]
    //     ]
    // ];
    // $results = Elasticsearch::search($params);


    // $params = [
    //     'index' => 'my_index',
    //     'id'    => 'my_id',
    //     'body'  => [
    //         'doc' => [
    //             'testField' => 'abc1236'
    //         ]
    //     ]
    // ];
    
    // // Update doc at /my_index/_doc/my_id
    // $results = Elasticsearch::update($params);
    // dd($results);


    // $params = [
    //     'index' => 'my_index',
    //     'id'    => 'my_id'
    // ];
    
    // // Delete doc at /my_index/_doc_/my_id
    // $response = Elasticsearch::delete($params);
    // dd($response);

    // $params = ['index' => 'my_index'];
    // $response = Elasticsearch::indices()->delete($params);
    
    // $params = [
    //     'index' => 'my_index',
    //     'id'    => 'my_id',
    //     'body'  => '{"testField" : "abc"}'
    // ];
    
    // $response = Elasticsearch::index($params);

    // $params = [
    //     'index' => 'my_index2',
    //     'body' => [
    //         'settings' => [
    //             'number_of_shards' => 2,
    //             'number_of_replicas' => 0
    //         ]
    //     ]
    // ];
    
    // $response = Elasticsearch::indices()->create($params);

    // $params = [
    //     'index' => 'your_index',
    //     'id' => '1',             
    //     'body' => [
    //         'content' => 'quick brown fox',
    //         'time' => '2025-02-26T12:00:00',   
    //         'popularity' => 1000   
    //     ]
    // ];
    
    // // Index the document
    // $response = Elasticsearch::index($params);

    // $params['body'] = [
    //     'query' => [
    //         'match' => [
    //             'content' => 'quick brown fox'
    //         ]
    //     ],
    //     'sort' => [
    //         ['time' => ['order' => 'desc']],
    //         ['popularity' => ['order' => 'desc']]
    //     ]
    // ];
    // $response = Elasticsearch::search($params);

    // Simple search Query
    // $params = [
    //     'index' => 'my_index',
    //     'body'  => [
    //         'query' => [
    //             'match' => [
    //                 'testField' => 'abc'
    //             ]
    //         ]
    //     ]
    // ];
    
    // $response = Elasticsearch::search($params);

    // $json = '{
    //     "query" : {
    //         "match" : {
    //             "testField" : "abc"
    //         }
    //     }
    // }';
    
    // $params = [
    //     'index' => 'my_index',
    //     'body'  => $json
    // ];
    
    // $response = Elasticsearch::search($params);

    // $params = [
    //     'index' => 'my_index',
    //     'body'  => [
    //         'query' => [
    //             'match' => [
    //                 'testField' => 'abc'
    //             ]
    //         ]
    //     ]
    // ];
    
    // $response = Elasticsearch::search($params);
    
    // $milliseconds = $response['took'];
    // $maxScore     = $response['hits']['max_score'];
    
    // $score = $response['hits']['hits'][0]['_score'];
    // $doc   = $response['hits']['hits'][0]['_source'];
    // dd($doc);

    // $params = [
    //     'index' => 'my_index',
    //     'body'  => [
    //         'query' => [
    //             'bool' => [
    //                 'should' => [
    //                     [ 'term' => [ 'testField' => 'abc' ] ],
    //                     [ 'term' => [ 'testField2' => 'xyz' ] ],
    //                 ]
    //             ]
    //         ]
    //     ]
    // ];

    // $result = Elasticsearch::search($params);

    // $params = [
    //     'index' => 'my_index',
    //     'body'  => [
    //         'query' => [
    //             'bool' => [
    //                 'must' => [
    //                     [ 'term' => [ 'testField' => 'abc' ] ],
    //                 ]
    //             ]
    //         ]
    //     ]
    // ];

    // $result = Elasticsearch::search($params);

    //SO when filter and should are combined.
    //The result based on filter , should is optional condition.
    
    $params = [
        'index' => 'my_index',
        'body'  => [
            'query' => [
                'bool' => [
                    'filter' => [
                        'term' => [ 'my_field' => 'abc' ]
                    ],
                    'should' => [
                        'match' => [ 'my_other_field' => 'xyz' ]
                    ]
                ]
            ]
        ]
    ];
    $result = Elasticsearch::search($params);
    dd($result);
    // return view('welcome');
});

Route::get('/search-with-scroll', function () {
    $params = [
        'scroll' => '30s',
        'size'   => 50,
        'index'  => 'my_index',
        'body'   => [
            'query' => [
                'match_all' => new \stdClass()
            ]
        ]
    ];

    $response = Elasticsearch::search($params);

    // dd($response);
    while (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {
        $scroll_id = $response['_scroll_id'];

        $response = Elasticsearch::scroll([
            'body' => [
                'scroll_id' => $scroll_id,
                'scroll' => '30s'
            ]
        ]);
    }
});

Route::get('/index-with-routing-parameter', function () {
    $params = [
        'index'     => 'my_index',
        'id'        => 'my_id2',
        'routing'   => 'company_xyz',
        'body'      => [ 'testField2' => 'abc2']
    ];

    $resp = Elasticsearch::index($params);
    dd($resp);
});

Route::get('/bulk-index-with-batches', function () {
    $params = ['body' => []];

    for ($i = 1; $i <= 1000; $i++) {
        $params['body'][] = [
            'index' => [
                '_index' => 'my_index',
                '_id'    => $i
            ]
        ];
    
        $params['body'][] = [
            'my_field'     => 'my_value',
            'second_field' => 'some more values'
        ];    

        // Every 1000 documents stop and send the bulk request
        if ($i % 1000 == 0) {
            $responses = Elasticsearch::bulk($params);

            // erase the old bulk request
            $params = ['body' => []];

            // unset the bulk response when you are done to save memory
            unset($responses);
        }
    }

    // Send the last batch if it exists
    if (!empty($params['body'])) {
        $responses = Elasticsearch::bulk($params);
    }
});

Route::get('/search-with-match', function () {
    $params = [
        'index'  => 'books',
        'body'   => [
            'query' => [
                'match' => [
                    "author" => "Joshua"
                ]
            ]
        ]
    ];

    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/search-with-ids', function () {
    $params = [
        'index'  => 'books',
        'body'   => [
            'query' => [
                'ids' => [
                    "values" => [1,2]
                ]
            ]
        ]
    ];

    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/search-with-terms', function () {
    $params = [
        'index'  => 'books',
        'body'   => [
            'query' => [
                'terms' => [
                    "author" =>  ["joshua", "joseph"]
                ]
            ]
        ]
    ];

    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/search-with-range', function () {
    $params = [
        'index'  => 'books',
        "_source" => "amazon_rating", 
        'body'   => [
            'query' => [
                'range' => [
                    "amazon_rating" =>  ["gte" => 4.5, "lte" => 5]
                ]
            ]
        ]
    ];

    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/search-with-prefix', function () {
    $params = [
        'index'  => 'books',
        "_source" => "title", 
        'body'   => [
            'query' => [
                'prefix' => [
                    "title" =>  [
                        "value" => "con"
                    ]
                ]
            ]
        ]
    ];

    $resp = Elasticsearch::search($params);
    dump($resp);
});

Route::get('/search-with-highlight', function () {
    $params = [
        'index' => 'books',
        'body' => [
            '_source' => false,
            'query' => [
                'wildcard' => [
                    'title' => [
                        'value' => '*st'
                    ]
                ]
            ],
            'highlight' => [
                'fields' => [
                    'title' => new stdClass()
                ]
            ]
        ]
    ];

    $response = Elasticsearch::search($params);
    dump($response);
});

Route::get('/fuzzy-search', function () {
    $params = [
        'index' => 'books',
        'body' => [
            '_source' => false,
            'query' => [
                'fuzzy' => [
                    'title' => [
                        'value' => 'kaava',
                        'fuzziness' => 2
                    ]
                ]
            ],
            'highlight' => [
                'fields' => [
                    'title' => new stdClass()
                ]
            ]
        ]
    ];

    $response = Elasticsearch::search($params);
    dump($response);
});