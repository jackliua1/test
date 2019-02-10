<?php
namespace application\admin\controller;
use think\Loader;
use think\Db;
use think\image;
use think\Request;
use think\db\Query;
class PriceController extends CommonController{
    //价格列表
    public function lists(){

        $infr= Db::table('zxcms_price')
            ->alias('a')
            ->join('zxcms_commodity w','a.price_id = w.id')
            ->join('zxcms_template c','a.template_id = c.id')
            ->select();

        $this->assign('infr',$infr);
        return $this->fetch();

    }
    //显示商品
    public function add(){
        $admin_id=session('user_id');
        $info=db('commodity')->where('admin_id',$admin_id)->select();
        $infr=db('template')->where('user_id',$admin_id)->select();
        $this->assign('infr',$infr);
        $this->assign('info',$info);
        return $this->fetch();

    }
    //修改商品价格
    public function update()
    {
        $id=input('id');

        //通过id查找产品
        $dates = db('price')->where('template_id', $id)->find();
        $this->assign('dates',$dates);
        return $this->fetch();
    }
    //删除
    public function dell(){
        $data=input('id');
        $data=db('price')->delete($data);
        if($data){
            $this->success('删除成功','lists');
        }else{
            $this->error('删除失败');
        }
    }
    //添加价格
    public function adds(){
        $id=session('user_id');

        $data=input();

        $de['username']=$data['username'];
        $date['user_name']=$data['user_name'];
        $der['price_template']=$data['price_template'];
        $info=db('admin')->where('uid',$id)->find();
//        var_dump($info);die;
        $infos=db('commodity')->where('username',$de['username'])->find();
        $infose=db('template')->where('price_template', $der['price_template'])->find();
        $datas['uid']=$info['id'];
//        $datas['username']=$data['username'];
        $datas['price']=$data['price'];
        $datas['user_name']=$info['user_name'];
        $datas['price_id']=$infos['id'];
        $datas['template_id']=$infose['id'];

        $dates=db('price')->insert($datas);
        if($dates){
            $this->success('添加成功','lists');
        }else{
            $this->error('操作失败','add');
        }



    }
    //修改价格
    public function updata(){
        $date=input();
        $infr=db('price')->update($date);
        if($infr){
            $this->success('修改成功','price/lists');
        }else{
            $this->error('修改失败');
        }


    }

}