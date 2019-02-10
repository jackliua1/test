<?php
namespace application\admin\controller;
use think\console\command\make\Controller;
use think\Db;
use think\Loader;
use PHPExcel_IOFactory;
use PHPExcel;
class DingController extends CommonController
{
    //订单列表
    public function lists()
    {
        $data['time']=date('Y-m-d');
         $infr= Db::table('zxcms_goods')
            ->alias('g')
             ->join('zxcms_admin a','g.good_id = a.id')
            ->join('zxcms_jiage j','a.template_id = j.tem_id AND g.uid = j.comm_id')
             ->join('zxcms_commodity c','g.uid=c.id')
            ->where($data)
             ->group('g.gid')
            ->select();

        $result = array();
        foreach($infr as $val){

            $key = $val['username'].'_'.$val['ys'];
            if(!isset($result[$key])){
                $result[$key] = $val;
            }else{
                $result[$key]['number'] += $val['number'];

            }
        }

        $de= array_values($result);

        foreach($de as $ke=> $vals){
            $de[$ke]['zongjia']=$vals['number']*$vals['gongjin'];

        }

        $this->assign('de',$de);
        return $this->fetch();
    }
//导出数据到Excle表
    public function out()
    {
        //获取商家名称
        $date=$_POST['realname'];
           
        //查询用户信息
        $info = db('admin')->where('realname', $date)->find();

        //获取用户id
        $data['good_id'] = $info['id'];
        $data['time']=date('Y-m-d');
        //三表查询，用户表，商品表，订单表
        $infr= Db::table('zxcms_goods')
            ->alias('g')
            ->join('zxcms_admin a','g.good_id = a.id')
            ->join('zxcms_jiage j','a.template_id = j.tem_id AND g.uid = j.comm_id')
            ->join('zxcms_commodity c','g.uid=c.id')
            ->where($data)
            ->group('g.gid')
            ->select();
  
         foreach($infr as $ke=> $vals){
            $infr[$ke]['zongjias']=$vals['number']*$vals['gongjin'];

        }
        // echo "<pre>";
        //   var_dump($infr);die;
//         $result = array();
//         foreach($infr as $val){
//             $key = $val['username'].'_'.$val['good_id'];
//             if(!isset($result[$key])){
//                 $result[$key] = $val;
//             }else{
//                 $result[$key]['number'] += $val['number'];
//             }
//         }
//         $de= array_values($result);
//         $results = array();
//         foreach($infr as $vals){
// //            var_dump($val);
//             $key = $vals['username'].'_'.$vals['good_id'];
//             if(!isset($result[$key])){
//                 $results[$key] = $vals;
//             }else{
//                 $results[$key]['zongjias'] += $vals['zongjias'];
// //                var_dump($results);/
//             }
//         }
//         $infr= array_values($results);
//         echo "<pre>";
//         var_dump($infr);die;
//         if(count($des)>0){
//             foreach($des as $k=>$v){
//                 if($k==0){
//                     $temp = $v;
//                 }else{
//                     foreach($temp as $kk=>$vv){
//                         if(isset($v[$kk])){
//                             $n[$kk]=$v[$kk]+$temp[$kk];
//                             $temp = $n;
//                         }
//                     }
//                 }
//             }
//         }
//         $dse=array_merge($de,$temp);
//         echo "<pre>";
//         var_dump($dse);
//          foreach($dse as $ke=> $vals){
//             $dse[$ke]['zongjias']=$vals['number']*$vals['gongjin'];

//         }
//          echo "<pre>";
//        var_dump($dse);die;
        //2.加载PHPExcle类库
        vendor('PHPExcel.PHPExcel');
        //3.实例化PHPExcel类
        $objPHPExcel = new \PHPExcel();
        //4.激活当前的sheet表
        $objPHPExcel->setActiveSheetIndex(0);
        //5.设置表格头（即excel表格的第一行）
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '姓名')
            ->setCellValue('C1', '名称')
            ->setCellValue('D1', '重量')
            ->setCellValue('E1', '单位')
            ->setCellValue('F1', '价格')
            ->setCellValue('G1', '时间');
        


        //设置F列水平居中
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置单元格宽度
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(15);
        //6.循环刚取出来的数组，将数据逐一添加到excel表格。
        for($i=0;$i<count($infr);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$infr[$i]['good_id']);//用户id
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$infr[$i]['realname']);//添加姓名
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),$infr[$i]['username']);//添加商品名称
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),$infr[$i]['zongjias']);//添加重量
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),$infr[$i]['zhong']);//添加单位
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2),$infr[$i]['jiage']);//添加单位
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2),$infr[$i]['time']);//添加时间


        }
        // $objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2),$dse['zongjias']);//总计
        //7.设置保存的Excel表格名称
        $filename = '订单表'.date('ymd',time()).'.xls';
        //8.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('订单表');
        ob_end_clean();//清除缓冲区,避免乱码
        //9.设置浏览器窗口下载表格
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'"');
        //生成excel文件
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //下载文件在浏览器窗口
        $objWriter->save('php://output');
        exit;


    }
    //导出商品重量总和
    public function export(){
        $data=input('username');
        $date['username']=$data;
//        $data['time']=date('Y-m-d');
        $infr= Db::table('zxcms_goods')
            ->alias('a')
            ->field('username,number,time')
            ->join('zxcms_commodity w','a.uid = w.id')
            ->order('a.time desc')
//            ->group('number')
//            ->count('number')
            ->where($date)
            ->select();
            $arr=array();
        foreach ($infr as $k=>$v){
            if($k<=0){
                $k++;
            }
        }
//        var_dump($k);die;
        for($i=0;$i<$k+1;$i++){
            $arr[$i]=$infr[$i]['number'];

        }



        $infs['number']=array_sum($arr);
        $infs['username']=$infr['0']['username'];

//            var_dump($infs);die;
        //2.加载PHPExcle类库
        vendor('PHPExcel.PHPExcel');
        //3.实例化PHPExcel类
        $objPHPExcel = new \PHPExcel();
        //4.激活当前的sheet表
        $objPHPExcel->setActiveSheetIndex(0);
        //5.设置表格头（即excel表格的第一行）
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '姓名')
            ->setCellValue('C1', '名称')
            ->setCellValue('D1', '重量')
            ->setCellValue('E1', '时间');
        //设置F列水平居中
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置单元格宽度
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(30);
        //6.循环刚取出来的数组，将数据逐一添加到excel表格。
        for($i=0;$i<count($infs);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$infr[$i]['good_id']);//用户id
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$infr[$i]['realname']);//添加姓名
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),$infs[$i]['username']);//添加商品名称
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),$infs[$i]['number']);//添加重量
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),$infr[$i]['time']);//添加时间
        }
        //7.设置保存的Excel表格名称
        $filename = '订单表'.date('ymd',time()).'.xls';
        //8.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('订单表');
        ob_end_clean();//清除缓冲区,避免乱码
        //9.设置浏览器窗口下载表格
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'"');
        //生成excel文件
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //下载文件在浏览器窗口
        $objWriter->save('php://output');
        exit;

    }

    public function daocu(){
        $data['time']=date('Y-m-d');
        $infr= Db::table('zxcms_goods')
            ->alias('g')
            ->join('zxcms_admin a','g.good_id = a.id')
            ->join('zxcms_jiage j','a.template_id = j.tem_id')
            ->join('zxcms_commodity c','g.uid=c.id')
            ->where($data)
            ->group('g.gid')
            ->select();
//        var_dump($infr);die;
        $result = array();
//        foreach($infr as $val){
//            $key = $val['username'].'_'.$val['good_id'];
//            if(!isset($result[$key])){
//                $result[$key] = $val;
//            }else{
//                $result[$key]['number'] += $val['number'];
//            }
//        }
//        $de= array_values($result);
        foreach($infr as $val){

            $key = $val['username'].'_'.$val['ys'];
            if(!isset($result[$key])){
                $result[$key] = $val;
            }else{
                $result[$key]['number'] += $val['number'];

            }
        }

        $dse= array_values($result);

        foreach($dse as $ke=> $vals){
            $dse[$ke]['zongjia']=$vals['number']*$vals['gongjin'];

        }

//        $results = array();
//        foreach($de as $vals){
////            var_dump($val);
//            $key = $vals['username'].'_'.$vals['good_id'];
//            if(!isset($result[$key])){
//                $results[$key] = $vals;
//            }else{
//                $results[$key]['number'] += $vals['number'];
////                var_dump($results);/
//            }
//        }
//        $des= array_values($results);
//        if(count($des)>0){
//            foreach($des as $k=>$v){
//                if($k==0){
//                    $temp = $v;
//                }else{
//                    foreach($temp as $kk=>$vv){
//                        if(isset($v[$kk])){
//                            $n[$kk]=$v[$kk]+$temp[$kk];
//                            $temp = $n;
//                        }
//                    }
//                }
//            }
//        }
//        $dse=array_merge($de,$temp);
//        foreach($dse as $ke=> $vals){
//            echo "<pre>";
//            var_dump($vals);
//            $dse['zongjia']=$vals['number']*$vals['gongjin'];
//
//        }

        //2.加载PHPExcle类库
        vendor('PHPExcel.PHPExcel');
        //3.实例化PHPExcel类
        $objPHPExcel = new \PHPExcel();
        //4.激活当前的sheet表
        $objPHPExcel->setActiveSheetIndex(0);
        //5.设置表格头（即excel表格的第一行）
        $objPHPExcel->setActiveSheetIndex(0)
//            ->setCellValue('A1', 'ID')
//            ->setCellValue('B1', '姓名')
            ->setCellValue('A1', '名称')
            ->setCellValue('B1', '件数')
            ->setCellValue('C1', '单位')
            ->setCellValue('D1', '总量')
            ->setCellValue('E1', '时间');
//            ->setCellValue('H1', '总计');


        //设置F列水平居中
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置单元格宽度
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(15);
        //6.循环刚取出来的数组，将数据逐一添加到excel表格。
        for($i=0;$i<count($dse);$i++){
//            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$dse[$i]['good_id']);//用户id
//            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$dse[$i]['realname']);//添加姓名
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$dse[$i]['username']);//添加商品名称
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$dse[$i]['number']);//添加重量
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),$dse[$i]['zhong']);//添加单位
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),$dse[$i]['zongjia']);//添加单位
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),$dse[$i]['time']);//添加时间


        }
//        $objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2),$dse['number']);//总计
        //7.设置保存的Excel表格名称
        $filename = '总订单表'.date('ymd',time()).'.xls';
        //8.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('总订单表');
        ob_end_clean();//清除缓冲区,避免乱码
        //9.设置浏览器窗口下载表格
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'"');
        //生成excel文件
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //下载文件在浏览器窗口
        $objWriter->save('php://output');
        exit;
    }

    public function indexs(){

         $info = db('admin')->select();
        $data['time']=date('Y-m-d');
        $infr= Db::table('zxcms_goods')
            ->field('g.gid,j.id,a.realname,j.jiage,c.username,g.time,g.number,c.gongjin,j.num,c.zhong,g.num,g.prices')
            ->alias('g')
            ->join('zxcms_admin a','g.good_id = a.id')
            ->join('zxcms_jiage j','a.template_id = j.tem_id AND g.uid = j.comm_id')
            ->join('zxcms_commodity c','g.uid=c.id')
            ->where($data)
            ->group('g.gid')
            ->select();
        foreach($infr as $ke=> $vals){
            $infr[$ke]['zongjia']=$vals['number']*$vals['gongjin'];

        }


        $this->assign('de',$info);
        $this->assign('desc',$infr);
        return $this->fetch();
    }
    //添加实际发货量
  //   public function addse(){
  //       $date=input('id');
  //       $info = db('goods')->find($date);
       
  //       $infos = db('commodity')->find($info['uid']);
  //        $this->assign('info',$info);
       
  // $this->assign('infos',$infos);
  //   return $this->fetch();
  //   }
    //添加实际总量和价格
    public function updates(){

            $date=input();
 
            $data['gid']=$date['gid'];
             $data['num']=$date['num'];
            $data['prices']=$date['prices'];

             $res = db('goods')->update($data);
             if ($res) {
            $this->success('操作成功','indexs');
        } else {
            $this->error('操作失败');
        }



    }
    public function yong(){
         $info = db('admin')->select();
        $this->assign('de',$info);
        $date=$_POST['realname'];
 
        //查询用户信息
        $info = db('admin')->where('realname', $date)->find();


        //获取用户id
        $data['good_id'] = $info['id'];
        $data['time']=date('Y-m-d');
        //三表查询，用户表，商品表，订单表
        $infr= Db::table('zxcms_goods')
            ->alias('g')
            ->field('a.realname,j.id,c.username,j.jiage,g.num,g.time,g.number,c.gongjin,c.zhong,g.gid,g.prices')
            ->join('zxcms_admin a','g.good_id = a.id')
            ->join('zxcms_jiage j','a.template_id = j.tem_id AND g.uid = j.comm_id')
            ->join('zxcms_commodity c','g.uid=c.id')
            ->where($data)
            ->group('g.gid')
            ->select();
           

        foreach($infr as $ke=> $vals){
            $infr[$ke]['zongjia']=$vals['number']*$vals['gongjin'];

        }

         $this->assign("desc",$infr);
         return $this->fetch('yong');

    }
}