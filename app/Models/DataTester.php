<?php

namespace App\Models;
use App\Models\Transaction;


class DataTester 
{
    private static $data = [
                [
                    'faktur' => 'tr0986',
                    'item' => [
                        'handuk',
                        'sabun',
                        'sampo',
                    ]
                ],
                [
                    'faktur' => 'tr0986',
                    'item' => [
                        'handuk',
                        'sabun',
                        'sampo',
                    ]
                ],
                [
                    'faktur' => 'tr0926',
                        'item' => [
                        'sabun',
                        'sampo',
                        'wipol'
                    ]
                ],
                [
                    'faktur' => 'tr0966',
                    'item' => [
                        'handuk',
                        'sampo',
                        'wipol'
                    ]
                ],
                [
                    'faktur' => 'tr0766',
                    'item' => [
                        'sikat',
                        'handuk',
                        'sampo',
                        'wipol'
                    ]
                    ],
                [
                    'faktur' => 'tr0966',
                    'item' => [
                        'handuk',
                        'wipol'
                    ]
                ],
                [
                    'faktur' => 'tr0966',
                    'item' => [
                        'handuk',
                        'wipol'
                    ]
                ],
                [
                    'faktur' => 'tr0766',
                    'item' => [
                        'sikat',
                        'handuk',
                        'sampo',
                        'wipol'
                    ]
                    ],
                    [
                    'faktur' => 'tr0766',
                    'item' => [
                        'sikat',
                        'handuk',
                        'sampo',
                        'wipol'
                    ]
                    ],
                    [
                    'faktur' => 'tr0766',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ],
                    [
                    'faktur' => 'tr0766',
                    'item' => [
                        'odol',
                        'handuk',
                        'sampo',
                        'wipol'
                    ]
                    ],
                    [
                    'faktur' => 'tr0766',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ], 

                    [
                    'faktur' => 'tr07da6',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ], 

                    [
                    'faktur' => 't2366',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ], 

                    [
                    'faktur' => 'tr432766',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ], 

                    [
                    'faktur' => 'tr212334566',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ], 

                     [
                    'faktur' => 'tr23da6',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ], 

                     [
                    'faktur' => 'trdad4566',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ], 

                     [
                    'faktur' => 'tr2dasdt566',
                    'item' => [
                        'sikat',
                        'odol',
                        'sampo',
                        'wipol'
                    ]
                    ], 
        ]; 


        public static function all(){
            return self::$data;
        }


        public static function transaction(){
            $result = [];
            $transactions = Transaction::where("status_id", "!=" , 5)->get();
            
            foreach ($transactions as $transaction) {
                $lists = [];

                foreach ($transaction->list_transaction as $list) {
                    
                    array_push($lists, $list->item->slug);

                }

                $set_transaction = [
                    'faktur' => $transaction->code,
                    'item' => $lists
                ];

                array_push($result,$set_transaction);

            }

            return $result;


        }

         
}
