<?php

/**
 *  
 * @file   Index.php  
 * @date   2016-8-23 16:03:10 
 * @author Zhenxun Du<5552123@qq.com>  
 * @version    SVN:$Id:$ 
 */  

namespace application\admin\controller;

class IndexController extends CommonController{
    /**
     * 后台首页
     */
    public function index(){
        $uid=  session('user_id');
        $info = db('admin_home')->where('id',$uid)->select();
        $this->assign('info', $info);
        return $this->fetch();
    }
    public function logout() {
        session('user_name', null);
        session('user_id', null);
        cookie('user_name', null);
        cookie('user_id', null);
        $this->success('退出成功', 'login/index');
    }

    public function welcome(){

        return $this->fetch();
    }
    public function login(){
        session('user_name', null);
        session('user_id', null);
        cookie('user_name', null);
        cookie('user_id', null);
        $this->success('', 'login/index');

    }
    
}