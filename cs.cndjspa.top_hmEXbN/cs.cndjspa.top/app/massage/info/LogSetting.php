<?php
/**
 * Created by PhpStorm.
 * User: shuixian
 * Date: 2019/11/20
 * Time: 18:29
 */

$data = [

    'AdminShop' => [

        [

            'code_action'=> 'editCarte',

            'table'      => 'massage_service_shop_carte',

            'type'       => 1,

            'name'       => '商品分类',

            'text'       => '分类',

            'parameter'  => 'id',

            'method'     => 'post',

            'status'     => [

                -1 => 'del',

                1  => 'update'
             ]


        ],[

            'code_action'=> 'addCarte',

            'table'      => 'massage_service_shop_carte',

            'name'       => '商品分类',

            'text'       => '分类',

            'action'     => '添加'

        ]


    ],







];


return $data;





