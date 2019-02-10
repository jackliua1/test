<?php
namespace application\index\controller;
use think\Controller;
use think\Loader;
class LoginController extends Controller
{
    public function index()
    {

        if ($_POST['dosubmit']) {
            $username = input('post.user_name');
            $password = input('post.password');

            if (!$username) {
                $this->error('用户名不能为空');
            }
            if (!$password) {
                $this->error('密码不能为空');
            }

            $info = db('admin')->field('id,user_name,password')->where('user_name', $username)->find();

            if (!$info) {
                $this->error('用户不存在');
            }

            if (md5($password) != $info['password']) {
                $this->error('密码不正确');
            } else {
                session('user_name', $info['user_name']);
                session('user_id', $info['id']);
                if (input('post.islogin')) {
                    cookie('user_name', encry_code($info['user_name']));
                    cookie('user_id', encry_code($info['id']));
                }

                //记录登录信息
//                Loader::model('Admin')->editInfo(1, $info['id']);
                $this->success('登入成功', 'index/index');
            }
        } else {
            if (session('user_name')) {
                $this->success('您已登入', 'index/index');
            }

            if (cookie('user_name')) {
                $username = encry_code(cookie('user_name'),'DECODE');
                $info = db('admin')->field('id,user_name,password')->where('user_name', $username)->find();
                if ($info) {
                    //记录
                    session('user_name', $info['user_name']);
                    session('user_id', $info['id']);
//                    Loader::model('Admin')->editInfo(1, $info['id']);
                    $this->success('登入成功', 'index/index');
                }
            }

            $this->view->engine->layout(false);
            return $this->fetch();
        }
    }

}

