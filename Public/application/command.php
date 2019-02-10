<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

return [

    'default_module'        => 'index',
       // 默认控制器名
    'default_controller'    => 'login',
   // 默认操作名
   'default_action'        => 'index',

    'TMPL_PARSE_STRING' => array(
        //为了兼容不同的服务器系统我们使用__ROOT__来获取根路径
        '__HOME__'   => __ROOT__ . '/Public/Home/',
        '__ADMIN__'  => __ROOT__ . '/Public/Admin/',
        '__UPLOAD__' => __ROOT__ . '/uploads/',
    ),
    session([
        'prefix'     => 'index',
        'type'       => '',
        'auto_start' => true,
    ]),
            session([
            'prefix'     => 'admin',
            'type'       => '',
            'auto_start' => true,
        ])
];