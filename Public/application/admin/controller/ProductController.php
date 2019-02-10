<?php
namespace application\admin\controller;
use think\Loader;
use think\db;
use think\image;
class ProductController extends CommonController
{


    //产品列表
    public function lists()
    {
        //获取登录用户id
        $uid=session('user_id');
        $info = db('commodity')->where('admin_id',$uid)->select();
        $this->assign('info', $info);
        return $this->fetch();
    }

    //产品添加页面类的获取
    public function info()
    {
	
var_dump("111111111111");die;
        $uid=session('user_id');
        $info = db('classs')->where('uid',$uid)->select();
        $this->assign('info', $info);

        return $this->fetch();
    }

    //商品添加到数据库
    public function add()
    {

        $data = input('');
        $data['uid']=session('user_id');
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
		var_dump($info);die;
        //调用上传图片函数
        $dates=  $info->getsaveName();
        //替换路径
       $der= str_replace("\\","/","$dates");

        $data['file']=$der;
        $data['admin_id']=$data['uid'];
        $res = model('commodity')->allowField(true)->save($data);
        if ($res) {
            $this->success('操作成功','lists');
        } else {
            $this->error('操作失败');

        }
}

        //产品添加页面
    public function data()
{
    return $this->fetch();
}
    //添加产品类
    public function adds()
    {
        //获取form表单提交数据
        $data = input();
        $date=session('user_id');
        $data['uid']=$date;
        if ($data['ys'] == null) {
            $data['ys'] = 0;
        }
        //写到数据库
        $res = model('classs')->save($data);

        if ($res) {
            $this->success('操作成功','index');
        } else {
            $this->error('操作失败');
        }
    }
    //产品类列表
    public function index(){
        //获取登录人id
        $uid=session('user_id');
        //从数据库取产品类
        $info = db('classs')->where('uid',$uid)->select();
        $this->assign('info', $info);
        return $this->fetch();

}
//产品分类获取要修改的类
    public function id(){
        //获取产品id
        $id=input('id');
        //通过id查找产品
        $info = db('classs')->find($id);
        $this->assign('info', $info);
        return $this->fetch();
    }
    //修改产品分类
    public function edit(){
        //获取form表单提交数据
        $data=input();
            //修改产品写到数据库
        $res = model('classs')->update($data);

        if ($res) {
            $this->success('操作成功','index');
        } else {
            $this->error('操作失败');
        }

    }
    //删除分类
    public function del(){
        //获取分类id
        $id = input('id');
        //删除分类
        $res = db('classs')->where(['id' => $id])->delete();
        if ($res) {
            $this->success('操作成功', url('index'));
        } else {
            $this->error('操作失败');
        }
    }
    //产品删除
    public function  dell(){
        //获取产品id
        $id = input('id');
        //通过产品id进行删除产品
        $res = db('commodity')->where(['id' => $id])->delete();
        if ($res) {
            $this->success('操作成功', url('lists'));
        } else {
            $this->error('操作失败');
        }

    }
    //修改产品
    public function update(){
        $data=input();
        $res = model('commodity')->update($data);
        if ($res) {
            $this->success('操作成功','index');
        } else {
            $this->error('操作失败');
        }

    }
//修改商品
    public function updata(){
        //获取登录人的UID
        $uid=session('user_id');
        //查询产品
        $inf = db('classs')->where('uid',$uid)->select();
        $this->assign('inf', $inf);
        $id = input('id');
        $info = db('commodity')->find($id);
        $this->assign('info', $info);
        return $this->fetch();
    }

//    function uploadPic()
//    {
//        //上传配置
//        $config = array(
//            'maxSize'  => 3145728, //上传文件大小
//            //根路径 D:\itcast\php9\tp_shop\Uploads/2017-06-02/5930d34b4e8eb.jpg
//            //可以PHP中有个__DIR__
//            'rootPath' => UPLOAD, //
//        );
//        $upload = new \Think\Upload($config); //实例化上传类
//        $info   = $upload->upload(); //上传的方法
//        if (!$info) {
//            echo $upload->getError();exit; //获取错误信息
//        }
//        return $info;
//    }


}











