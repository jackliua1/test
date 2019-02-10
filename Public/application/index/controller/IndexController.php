<?php

/**
 *  
 * @file   Index.php  
 * @date   2016-8-23 16:03:10 
 * @author Zhenxun Du<5552123@qq.com>  
 * @version    SVN:$Id:$ 
 */  

namespace application\index\controller;
use think\Db;
use think\model;
use think\db\Query;
class IndexController extends CommonController
{
    /**
     *
     */

    public $user_id;
    public $u_id;

    public function __construct()
    {
        parent::__construct();
        $this->user_id = session('user_id');
        $data = db('admin')->where('id', $this->user_id)->find();
        $this->assign('id', $this->user_id);
        $this->u_id = $data['uid'];
    }

    public function index()
    {

        return $this->fetch();
    }

    //显示商家所有的商品
    public function gouhuo()
    {

        $id = session('user_id');

        $data = db('admin')->where('id', $id)->find();
        $this->assign('id', $id);
        $date['uid'] = $data['uid'];
        $datas['id'] = $data['uid'];
        $ids['time']=date('Y-m-d');
        $dates = db('classs')->where('uid', $date['uid'])->select();
        $data = db('commodity')->where('admin_id', $datas['id'])->select();
        $datr['time']=date('Y-m-d');
        $datrs = db('goods')->where('time',$datr['time'])->select();
        $this->assign('datrs', $datrs);
        $this->assign('dates', $dates);
        $this->assign('data', $data);
        return $this->fetch();
    }

    //库存列表
    public function kucunliebiao()
    {
        //登录id
        $id = session('user_id');

        $info = db('goods')->where('good_id', $id)->select();
        $data['good_id'] = $info['0']['good_id'];
        $data['time']=date('Y-m-d');
        $infr = Db::table('zxcms_stock')
            ->alias('a')
            ->join('zxcms_commodity w', 'a.uid = w.id')
            ->where($data)
            ->order('a.time desc')
            ->select();
        $this->assign('infr', $infr);
        return $this->fetch();
    }

    //购货单
    public function book()
    {
        //获取用户id
        $id = session('user_id');
        $info = db('goods')->where('good_id', $id)->select();
        $das['good_id'] = $info['0']['good_id'];
//        var_dump($das);
        $das['time'] = date('Y-m-d');
        $infr= Db::table('zxcms_goods')
            ->alias('a')
            ->where($das)
            ->field('username,number,file,good_id,uid,time')
            ->join('zxcms_commodity w','a.uid = w.id')
            ->order('w.username,a.number')
            ->distinct('a.number')
            ->group("w.username")
            ->select();
//        var_dump($infr);
        $this->assign('infr', $infr);

        return $this->fetch('book');

    }

    //库存盘点
    public function stock()
    {
        $id = session('user_id');
        $date['good_id']=$id;
        $data = db('admin')->where('id', $id)->find();
        $datee['good_id']=$data['id'];
        $datee['time']=date('Y-m-d');
        $this->assign('id', $id);
        $date['uid'] = $data['uid'];
        $dates = db('classs')->where('uid', $date['uid'])->select();
        $infr= Db::table('zxcms_goods')
            ->alias('a')
            ->where($datee)
            ->field('username,number,file,good_id,uid')
            ->join('zxcms_commodity w','a.uid = w.id')
            ->order('w.username,a.number')
            ->distinct('a.number')
            ->group("w.username")
            ->select();
        $this->assign('dates', $dates);
        $this->assign('infr', $infr);
        return $this->fetch();
    }


//退出登录
    public function login(){
        session('user_name', null);
        session('user_id', null);
        cookie('user_name', null);
        cookie('user_id', null);
        $this->success('', 'login/index');

    }
    //添加商品的数据库
    public function adds(){
        $id=  session('user_id');
        if($_POST) {
            $post = $_POST;
            //对数组进行循环
            $goodsarr = array();
            $i=$j=0;
            foreach($post['arr'] as $k=>$v){

                if($v['name']=='number'){
                    //如果数量大于0 记录数量
                    if($v['value']>0){
                        $goodsarr[$i]['number'] = $v['value'];
                        $i++;
                    }
                }else{
                    //记录id
                    if($goodsarr[$j]['number']>0){
                        $goodsarr[$j]['uid'] = $v['value'];
                        $j++;

                    }
                }
            }
        }
//        var_dump($goodsarr);die;
        foreach ($goodsarr as $k=>$v){
                if($k<0){
                    $k++;
                }
        }
//        var_dump($k);die;
        for($i=0;$i<$k+1;$i++){
            $goodsarr[$i]['time']=date('Y-m-d');
        }
        for($i=0;$i<$k+1;$i++){
            $goodsarr[$i]['good_id']=$id;
        }
        $der['id']=$id;

        $der['time']=date('Y-m-d');
        $data = db('goods')->where('good_id',$der['id'])->select();
//        var_dump($data);die;
        if($der['id']!==$data['0']['good_id']){
            $res = model('goods')->saveAll($goodsarr);
            echo json_encode($res);
        }else{
            foreach ($data as $k=>$v){
                if($k<0){
                    $k++;
                }
            }
            for($i=0;$i<$k+1;$i++){
                $goodsarr[$i]['id']=$data[$i]['id'];
                $goodsarr[$i]['id']=$data[$i]['id'];
                $goodsarr[$i]['id']=$data[$i]['id'];   ;
            }

            $res = model('goods')->saveAll($goodsarr);
            echo json_encode($res);
        }




    }
    //购货单查询
    public function edis(){

        $data = input('');

        $infr= Db::table('zxcms_goods')
            ->alias('a')
            ->join('zxcms_commodity w','a.uid = w.id')
            ->where($data)
            ->select();
//        var_dump($infr);die;
        $this->assign('infr', $infr);
        return $this->fetch('book');
    }
    //库存查询
    public function dis(){

        $data = input('');
        $data['time']=date('Y-m-d');
        $infr= Db::table('zxcms_stock')
            ->alias('a')
            ->join('zxcms_commodity w','a.uid = w.id')
            ->where($data)
            ->order('a.time desc')
            ->select();

        $this->assign('infr', $infr);
        return $this->fetch('kucunliebiao');


    }

    //切换分类
    public function qhattr(){
        $attr_name = $_POST['attr_name'];
//        var_dump($attr_name);die;
        if(!$attr_name){
            $data['status'] = 0;
            $data['msg'] = "非法操作";
            echo json_encode($data);
        }
        $where = "uid=".$this->u_id;
        if($attr_name != '全部'){
            $where .= " and ys='$attr_name'";
        }
        $goods_list = db('commodity')->where($where)->select();
//        var_dump($goods_list);
        $data['status'] = 1;
        $data['data'] = $goods_list;
        echo json_encode($data);
    }

            //盘点时间查询
            public function stockTime(){
                $data = input('');
                $id=  session('user_id');
                $date['good_id']=$id;
                $infr= Db::table('zxcms_stock')
                    ->alias('a')
                    ->join('zxcms_commodity w','a.uid = w.id')
                    ->where($data)
                    ->order('a.time desc')
                    ->where($date)
                    ->select();
                $this->assign('infr', $infr);
                return $this->fetch('kucunliebiao');


            }

    //库存盘点写到数据库
    public function addr(){
        $id=  session('user_id');
        if($_POST) {
            $post = $_POST;
            //对数组进行循环
            $goodsarr = array();
            $i=$j=0;
            foreach($post['arr'] as $k=>$v){

                if($v['name']=='number'){
                    //如果数量大于0 记录数量
                    if($v['value']>0){
                        $goodsarr[$i]['number'] = $v['value'];
                        $i++;
                    }
                }else{
                    //记录id
                    if($goodsarr[$j]['number']>0){
                        $goodsarr[$j]['uid'] = $v['value'];
                        $j++;

                    }
                }
            }
        }
//        var_dump($goodsarr);die;
        foreach ($goodsarr as $k=>$v){
            if($k<0){
                $k++;
            }
        }
//        var_dump($k);die;
        for($i=0;$i<$k+1;$i++){
            $goodsarr[$i]['time']=date('Y-m-d');
        }
        for($i=0;$i<$k+1;$i++){
            $goodsarr[$i]['good_id']=$id;
        }
     $der['time']=date('Y-m-d');
        $data = db('stock')->where('time',$der['time'])->select();

        if(date('Y-m-d')!==$data['0']['time']){
            $res = model('stock')->saveAll($goodsarr);
            echo json_encode($res);
        }else{
            $goodsarr['0']['id']=$data['0']['id'];
            $goodsarr['1']['id']=$data['1']['id'];
            $res = model('stock')->saveAll($goodsarr);
            echo json_encode($res);
        }
    }
    public function books(){
        $data = input('');
        $id=  session('user_id');
        $date['good_id']=$id;
        $infr= Db::table('zxcms_stock')
            ->alias('a')
            ->join('zxcms_commodity w','a.uid = w.id')
            ->where($data)
            ->order('a.time desc')
            ->where($date)
            ->select();
        $this->assign('infr', $infr);
        return $this->fetch('book');


    }
}