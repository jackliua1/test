<?php

/**
 * 后台公共文件 
 * @file   Common.php  
 * @date   2016-8-24 18:28:34 
 * @author Zhenxun Du<5552123@qq.com>  
 * @version    SVN:$Id:$ 
 */

namespace application\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class CommonController extends Controller {

    protected $user_id;
    protected $user_name;

    public function __construct(\think\Request $request = null) {

        parent::__construct($request);

        if (!session('user_name')) {
//
            $this->error('请登陆');
        }
//
//        $this->user_id = session('user_id');
//        $this->user_name = session('user_name');
////
////        //权限检查
//        if (!$this->_checkAuthor($this->user_id)) {
//////            $this->error('你无权限操作');
//        }
////
////        //记录日志
////        $this->_addLog();
    }

    /**
     * 权限检查
     */
    private function _checkAuthor($user_id) {

        if (!$user_id) {
            return false;
        }
        if($user_id==1){
            return true;
        }
        $c = strtolower(request()->controller());
        $a = strtolower(request()->action());

        if (preg_match('/^public_/', $a)) {
            return true;
        }
        if ($c == 'index' && $a == 'index') {
            return true;
        }
        $menu = model('Menu')->getMyMenu($user_id);
        foreach ($menu as $k => $v) {
            if (strtolower($v['c']) == $c && strtolower($v['a']) == $a) {
                return true;
            }
        }
        return false;
    }

    /**
     * 记录日志
     */
//    private function _addLog() {
//
//        $data = array();
//        $data['querystring'] = request()->query()?'?'.request()->query():'';
//        $data['m'] = request()->module();
//        $data['c'] = request()->controller();
//        $data['a'] = request()->action();
//        $data['userid'] = $this->user_id;
//        $data['username'] = $this->user_name;
//        $data['ip'] = ip2long(request()->ip());
//        $arr = array('Index/index','Log/index','Menu/index');
//        if (!in_array($data['c'].'/'.$data['a'], $arr)) {
//            db('admin_log')->insert($data);
//        }
//    }
    function uploadPic()
    {
        //上传配置
        $config = array(
            'maxSize'  => 3145728, //上传文件大小
            //根路径 D:\itcast\php9\tp_shop\Uploads/2017-06-02/5930d34b4e8eb.jpg
            //可以PHP中有个__DIR__
            'rootPath' => UPLOAD, //
        );
        $upload = new \Think\Upload($config); //实例化上传类
        $info   = $upload->upload(); //上传的方法
        if (!$info) {
            echo $upload->getError();exit; //获取错误信息
        }
        return $info;
    }
    public function initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        if(!session('') || !session('id')){
            $this->error('请先登录！',url('login/index'));
        }
    }

}