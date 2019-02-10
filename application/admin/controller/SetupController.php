<?php
namespace application\admin\controller;
use think\Db;
use think\model;
use think\db\Query;
class SetupController extends CommonController{

        public function setup(){
            //获取登录id

            return $this->fetch();
        }
        public function index(){
            $id=session('user_id');
            $data=input();
            if($data['setup']==null){
                $this->error('不能为空');
            }
            $data['uid']=$id;
            $data['time']=date('Y-m-d h:i:s');
            $data['msg']=1;
            $info=model('setup')->save($data);
            if($info){
                $this->success('添加成功','setup/alist');
            }else{
                $this->error('添加失败','setup/setup');
            }
        }
        //列表
        public function alist(){
            $info=db('setup')->select();
            foreach ($info as $k=>$v){
                if($k<0){
                    $k++;
                }
            }
            for($i=0;$i<$k+1;$i++){
                if($info[$i]['msg']==1){
                    $info[$i]['msg']='发布';
                }else {
                    $info[$i]['msg'] = '下架';

                }
            }
            $this->assign('info',$info);

            return $this->fetch();
        }
        //删除
        public function del(){
           $id=input('id');
            $res = db('setup')->where(['id' => $id])->delete();
            if ($res) {
                $this->success('操作成功','alist');
            } else {
                $this->error('操作失败');
            }
        }
        //发布
        public function release(){

            $id=input('id');
            $info = db('setup')->where(['id' => $id])->find();
            $info['msg']=1;


            $infos= db('setup')->where($id)->select();

            foreach ($infos as $k=>$v){
                if($k<0){
                    $k++;
                }
            }
            for($i=0;$i<$k+1;$i++){

             $date['msg']=   $infos[$i]['msg'];

                if($infos[$i]['msg']== 1){
                      $this->success('只能有一个发布');  exit;
                }else{

                    $res=  db('setup')->where(['id' => $id])->update($info);
                    if($res){
                        $this->success('发布成功','alist');
                    }else{
                        $this->error('发布失败');
                    }
                }
            }






            return $this->fetch('alist');
        }
        //下架
        public function lowerframe(){
            $id=input('id');

            $info = db('setup')->where(['id' => $id])->find();
            $info['msg']=0;
            $res = db('setup')->where(['id' => $id])->update($info);
            if ($res) {
                $this->success('下架成功','alist',1);
            } else {
                $this->error('下架失败');
            }
            return $this->fetch('alist');
        }


}

