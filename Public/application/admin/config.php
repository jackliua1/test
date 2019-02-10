<?php
return array(
    //'配置项'=>'配置值'
    //普通配置我们使用键=>值（字符串）
    //模板常量的配置我们使用键=>值（数组）
    'TMPL_PARSE_STRING' => array(
        //为了兼容不同的服务器系统我们使用__ROOT__来获取根路径
        '__HOME__'   => __ROOT__ . '/Public/Home/',
        '__ADMIN__'  => __ROOT__ . '/Public/Admin/',
        '__UPLOAD__' => __ROOT__ . '/Uploads/',
    ),
    'SHOW_PAGE_TRACE'   => true,

    'DB_TYPE'           => 'mysql', // 数据库类型
    'DB_HOST'           => 'localhost', // 服务器地址
    'DB_NAME'           => 'tpshop', // 数据库名
    'DB_USER'           => 'root', // 用户名
    'DB_PWD'            => '', // 密码
    'DB_PORT'           => '3306', // 端口
    'DB_PREFIX'         => 'tp_', // 数据库表前缀
    'URL_MODEL'         => 1,
    //加载公共函数库文件
    'LOAD_EXT_FILE'     => 'treeList',
);
