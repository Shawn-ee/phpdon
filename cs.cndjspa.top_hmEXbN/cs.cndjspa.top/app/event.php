<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 事件定义文件
return [
    'bind'      => [],

    'listen'    => [
        'AppInit'  => ['app\Common\listener\AppInit'],
        'HttpRun'  => [],
        'HttpEnd'  => ['app\Common\listener\HttpEndLog'],
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe'    =>    longbing_init_info_subscribe(),
];
