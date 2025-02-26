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

    $params = [
        'index' => 'my_index',
        'body'  => [
            'query' => [
                'bool' => [
                    'should' => [
                        [ 'term' => [ 'testField' => 'abc' ] ],
                        [ 'term' => [ 'testField2' => 'xyz' ] ],
                    ]
                ]
            ]
        ]
    ];

    $result = Elasticsearch::search($params);
    dd($result);
    // return view('welcome');
});
