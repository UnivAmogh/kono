<?php
return array (
        'jquery' => [ 
                'js' => [ 
                    'jquery.min.js', 
                ] 
        ],
        'jquery-ui' => [ 
                'baseCssUrl' => '/css',
                'js' => [ 
                        'jquery-ui.min.js' 
                ],
                'css' => [ 
                        'jquery-ui.min.css' 
                ],
                'depends' => [ 
                        'jquery' 
                ] 
        ],
        'font-awesome' => [
                'baseCssUrl' => '/css',
                'css' => [
                        'font-awesome.min.css',
                ],
        ],
        'bootstrap' => [
                'baseCssUrl' => '/css',
                'css' => [
                        'bootstrap.min.css',
                ],
                'js' => [
                        'bootstrap.min.js',
                ],
                'depends' => [
                        'jquery',
                        'font-awesome'
                ]
        ],                
);
