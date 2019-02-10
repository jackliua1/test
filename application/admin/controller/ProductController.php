<?php
namespace application\admin\controller;
use think\Loader;
use think\db;
use think\image;
use think\Request;
use think\db\Query;
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
        $uid=session('user_id');
        $info = db('classs')->where('uid',$uid)->select();

        $this->assign('info', $info);

        return $this->fetch();
    }

    //商品添加到数据库
    public function add()
    {
        $file = request()->file("file");



        // 移动到框架应用根目录/public/uploads/form/ 目录下
//       var_dump(ROOT_PATH);
        if($file){
            $info = $file->validate(['size'=>600678,'ext'=>'jpg,png,jpeg'])->move(ROOT_PATH .'public'.DS.'uploads');

            if($info) {
                // 成功上传后 获取上传目录
                $img = $info->getSaveName();
                $imgpath = DS . $img;
                $data = $_POST;
                $data['file'] = str_replace(DS, "/", $imgpath);
                $data['admin_id'] = session('user_id');

                $result = db('commodity')->insert($data);


            }
        }
        echo json_encode($result);
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
//        var_dump($data);die;
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
        $id = input();

        $file = request()->file("file");



        // 移动到框架应用根目录/public/uploads/form/ 目录下
//       var_dump(ROOT_PATH);
        if($file){
            $info = $file->validate(['size'=>600678,'ext'=>'jpg,png,jpeg'])->move(ROOT_PATH .'public'.DS.'uploads');

            if($info) {
                // 成功上传后 获取上传目录
                $img = $info->getSaveName();
                $imgpath = DS . $img;
                $data = $_POST;
                $data['file'] = str_replace(DS, "/", $imgpath);

                $data['admin_id'] = session('user_id');

                $result = db('commodity')->update($data);

                if ($result) {
                        $this->success('操作成功','lists');
                    } else {
                        $this->error('操作失败');
                    }
            }
        }

    }
//修改商品
    public function updata(){
        //获取登录人的UID
        $uid=session('user_id');
        //查询产品
//        $inf = db('classs')->where('uid',$uid)->select();
//
//        $this->assign('inf', $inf);
        $id = input();
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
             //模板显示页面
            public function listse(){
            $id=session('user_id');
            $info=db('template')->where('user_id',$id)->select();
            $this->assign('info',$info);
                    return $this->fetch();
            }
            //添加模板页面
            public function addse(){


                return $this->fetch();
            }
            //添加模板
            public function addr(){
                $id=session('user_id');

                $data=input();

                $data['user_id']=$id;

                $info=db('template')->insert($data);

                $ok=db('template')->where($data)->find();
                if(request() -> isPost())        {
                    vendor("PHPExcel.PHPExcel"); //方法一
                        $objPHPExcel =new \PHPExcel();
                        //获取表单上传文件
                         $file = request()->file('file');
                         $info = $file->validate(['ext' => 'xlsx'])->move(ROOT_PATH . 'public');
                         //上传验证后缀名,以及上传之后移动的地址  E:\wamp\www\bick\public

                    if($info) {
                        $exclePath = $info->getSaveName();  //获取文件名
                                        $file_name = ROOT_PATH . 'public' . DS . $exclePath;//上传文件的地址
                                        $objReader =\PHPExcel_IOFactory::createReader("Excel2007");
                                        $objPHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8

             $excel_array=$objPHPExcel->getsheet(0)->toArray();   //转换为数组格式

             array_shift($excel_array);  //删除第一个数组(标题);

                        foreach($excel_array as $k=>$v) {
                            $datas[$k]['tem_id'] =$ok['id'];
                            $datas[$k]['comm_id'] = $v[0];
                            $datas[$k]['jiage'] = $v[1];
                            $datas[$k]['usernames'] = $v[2];
                            $datas[$k]['danwei'] = $v[3];
                            $datas[$k]['leiming'] = $v[4];
                            $datas[$k]['guige'] = $v[5];
                            $datas[$k]['price'] = $v[6];
                            $datas[$k]['modulation'] = $v[7];

            }
                      //往数据库添加数据

                        $number = count($datas);
                        $num = 0;
                        foreach ($datas as $k => $v){
                            $rs = Db::name('jiage')->insert($v);
                            if ($rs){
                                $num ++;
                            }
                        }
                                    if($number == $num){
                                        $this->success('操作成功！', url('listse'));
                                    }else{
                                        $this->error('操作失败！');
                                    }
                                    }else{
                                        echo $file->getError();
                                    }
                                }
                                return $this->fetch();
                    }
            //修改模板
            public function dates(){
            $id=$_GET['id'];
                $info=db('template')->where($id)->find();
                $this->assign('info',$info);
                return $this->fetch();
            }
            //修改模板
            public function datas(){
                $data=input();
//        var_dump($data);die;
                $res = db('template')->update($data);
                if ($res) {
                    $this->success('操作成功','listse');
                } else {
                    $this->error('操作失败');
                }

            }
            public function delll(){
                $id = input('id');
                //通过产品id进行删除产品
                $res = db('template')->where(['id' => $id])->delete();
                if ($res) {
                    $this->success('操作成功', url('listse'));
                } else {
                    $this->error('操作失败');
                }

            }
            //库存列表
            public function kucuen(){
            $rs =db('kecun')->select();
       $this->assign('info',$rs);

                return $this->fetch();     
                 }
                 public function kucentianjia(){
                    if(request() -> isPost())        {
                    vendor("PHPExcel.PHPExcel"); //方法一
                        $objPHPExcel =new \PHPExcel();
                        //获取表单上传文件
                         $file = request()->file('file');

                         $info = $file->validate(['ext' => 'xlsx'])->move(ROOT_PATH . 'public');
                         //上传验证后缀名,以及上传之后移动的地址  E:\wamp\www\bick\public

                    if($info) {
                        $exclePath = $info->getSaveName();  //获取文件名
                                        $file_name = ROOT_PATH . 'public' . DS . $exclePath;//上传文件的地址
                                        $objReader =\PHPExcel_IOFactory::createReader("Excel2007");
                                        $objPHPExcel =$objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8

             $excel_array=$objPHPExcel->getsheet(0)->toArray();   //转换为数组格式

             array_shift($excel_array);  //删除第一个数组(标题);

                        foreach($excel_array as $k=>$v) {
                            $datas[$k]['k_nume'] = $v[0];
                           
            }
                      //往数据库添加数据
                        $rs = db('kecun')->delete(true);
                    // db::table('zxcms_kecun') -> delete(true);
                        $number = count($datas);
                     
                        $num = 0;
                       
                        foreach ($datas as $k => $v){

                            $rs =db('kecun')->insert($v);
                            if ($rs){
                                $num ++;
                            }
                        }
                                    if($number == $num){
                                        $this->success('操作成功！', url('kucuen'));
                                    }else{
                                        $this->error('操作失败！');
                                    }
                                    }else{
                                        echo $file->getError();
                                    }
                                }

                    return $this->fetch();  
                 }
                 public function dells(){
                      //获取分类id
                        $id = input('id');
                        //删除分类
                        $res = db('kecun')->where(['id' => $id])->delete();
                        if ($res) {
                            $this->success('操作成功', url('kucuen'));
                        } else {
                            $this->error('操作失败');
                        }


                 }


}











