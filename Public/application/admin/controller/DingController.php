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
            ->alias('a')
            ->join('zxcms_admin c','c.id = a.good_id')
            ->join('zxcms_commodity w','a.uid = w.id')
            ->order('a.time desc')
            ->where($data)
            ->select();
        $this->assign('infr',$infr);
        return $this->fetch();
    }
//导出数据到Excle表
    public function out()
    {
        //获取商家名称
        $date=input('username');

        //查询用户信息
        $info = db('admin')->where('user_name', $date)->select();
//        var_dump($info);die;
        //获取用户id
        $data['good_id'] = $info['0']['id'];
        $data['time']=date('Y-m-d');
//     var_dump($dates);die;
        //三表查询，用户表，商品表，订单表
        $infr= Db::table('zxcms_goods')
            ->alias('a')
            ->join('zxcms_admin c','c.id = a.good_id')
            ->join('zxcms_commodity w','a.uid = w.id')
            ->order('a.time desc')
            ->where($data)
            ->select();
//var_dump($infr);die;
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
        for($i=0;$i<count($infr);$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$infr[$i]['good_id']);//用户id
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$infr[$i]['realname']);//添加姓名
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),$infr[$i]['username']);//添加商品名称
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),$infr[$i]['number']);//添加重量
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),$infr[$i]['time']);//添加时间
        }
        //7.设置保存的Excel表格名称
        $filename = '订单表'.date('ymd',time()).'.xls';
        //8.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('订单表');
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
//            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),$infr[$i]['good_id']);//用户id
//            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),$infr[$i]['realname']);//添加姓名
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),$infs['username']);//添加商品名称
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),$infs['number']);//添加重量
//            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),$infr[$i]['time']);//添加时间
        }
        //7.设置保存的Excel表格名称
        $filename = '订单表'.date('ymd',time()).'.xls';
        //8.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('订单表');
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
}