<?php
/**
 * User: lp
 * Time: 2019/10/27--14:08
 */
return [
    'routing'=>[
        'moudle'=>'index'
        ,'controller'=>'index'
        ,'method'=>'index'
    ]
    ,'exception'=>[
        'empty_class'=>'app\admin\controller\Index'
        ,'empty_method'=>'index'
    ]
    ,'database'=>[
         'db_dns'=>'mysql:host=localhost;dbname=lp'
        ,'db_user'=>'root'
        ,'db_pass'=>'root'
        ,'db_charset'=>'UTF8'
    ]
];
 