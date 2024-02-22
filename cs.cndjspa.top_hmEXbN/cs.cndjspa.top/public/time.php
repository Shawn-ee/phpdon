<?php
// +----------------------------------------------------------------------
// | Longbing [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright Chengdu longbing Technology Co., Ltd.
// +----------------------------------------------------------------------
// | Website http://longbing.org/
// +----------------------------------------------------------------------
// | Sales manager: +86-13558882532 / +86-13330887474
// | Technical support: +86-15680635005
// | After-sale service: +86-17361005938
// +----------------------------------------------------------------------


$time = rand(1,3);

\think\facade\Db::name('massage_service_coach_list')->where(['uniacid'=>666])->update(['order_num'=>\think\facade\Db::rwa("order_num+$time")]);