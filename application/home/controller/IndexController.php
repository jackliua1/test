<?php

/**
 *  
 * @file   Index.php  
 * @date   2016-8-23 16:03:10 
 * @author Zhenxun Du<5552123@qq.com>  
 * @version    SVN:$Id:$ 
 */  

namespace application\home\controller;
use think\model;
use think\db\Query;
use think\Loader;
class IndexController extends CommonController{
    /**
     * 后台首页
     */
    public function index(){
        $info = db('admin_id')->select();
        $this->assign('info', $info);
        return $this->fetch();
    }


    public function welcome(){
        $info = db('admin_home')->select();
        $this->assign('info', $info);
        return $this->fetch('welcome');
    }


//添加用户
    public function admin_add(){

        return $this->fetch('admin_add');
    }
    //用户列表
    public function lists(){
        $info = db('admin_home')->select();
        var_dump($info);
        $this->assign('info', $info);

        return $this->fetch();

    }
    //用户写到数据库
    public function adds(){
        $data=input('post.');
        $date['password']= md5($data['password']);
        $te['toke']=time();
        $ds=array_merge($date,$te);
        $info=array_merge($data,$ds);
        $res = db('admin_home')->insert($info);
        if($res){
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }




    }
    //退出登录
    public function logout() {
        session('user_name', null);
        session('user_id', null);
        cookie('user_name', null);
        cookie('user_id', null);
        $this->success('退出成功', 'login/index');
    }
    
    
}