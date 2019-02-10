<?php
namespace application\admin\controller;
use think\Db;
use think\model;
use think\db\Query;
class SonghuoController extends CommonController{

       public function lists(){
           $info = db('admin')->select();

           $this->assign('data', $info);
           return $this->fetch();


       }
       public function index(){
           $data = input();
          $datas['time'] =$data['time'];
           $datas['good_id']=$data['realname'];
       
           $data= Db::table('zxcms_goods')
               ->alias('g')
                 ->field('g.gid,j.id,a.realname,j.jiage,c.username,g.time,g.number,c.gongjin,j.num,c.zhong,g.num,g.prices,a.mobile')
               ->join('zxcms_admin a','g.good_id = a.id')
               ->join('zxcms_jiage j','a.template_id = j.tem_id AND g.uid = j.comm_id')
               ->join('zxcms_commodity c','g.uid=c.id')
               ->where($datas)
               ->group('g.gid')
               ->select();
               if($data==null){
               $this->error('店铺没有订货', url('lists'));
               }else{
                $i=1;
                foreach($data as $ke=> $vals){
                  
                       $data[$ke]['zongjia']=$vals['num']*$vals['prices'];
                       $data[$ke]['zongjias']=$i;
                       $i++;
                        // $de[$ke]['zongjias']=$vals['number']*$vals['gongjin'];

                   }
                  
                    $sum=array();
                   for($i=0;$i<=count($data);$i++){
                  
                       $sum['zongjia']+=$data[$i]['zongjia'];
                       $sum['num']+=$data[$i]['num'];
                   }
           
                     $sum['numbers']=$this->convertMoney( $sum['zongjia']);
                     $sum['time']=date('Y-m-d');
                    $sum['times']= date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
                    $info = db('admin')->select();

                    $this->assign('data', $info);
                     $this->assign("datas",$data);
                     $this->assign("sum",$sum);

               

               }
             
         
           return $this->fetch('lists');

       }
       //查询
       public function indexs(){
           $info = db('admin')->select();
           $this->assign('data', $info);

           return $this->fetch();

       }
       public function query(){
           $data = input();

           $where['good_id']=$data['realname'];
           $where['time'] = array('between', array($data['time'],$data['times']));
           $datas= Db::table('zxcms_goods')
               ->alias('g')
               ->join('zxcms_admin a','g.good_id = a.id')
               ->join('zxcms_jiage j','a.template_id = j.tem_id AND g.uid = j.comm_id')
               ->join('zxcms_commodity c','g.uid=c.id')
               ->where($where)
               ->group('g.gid')
               ->select();

                foreach($datas as $ke=> $vals){
                       $datas[$ke]['zongjia']=$vals['num']*$vals['prices'];
                        // $de[$ke]['zongjias']=$vals['number']*$vals['gongjin'];

                   }
                   for($i=0;$i<=count($datas);$i++){
                       $sum['zongjia']+=$datas[$i]['zongjia'];
                        $sum['num']+=$datas[$i]['num'];
                   }
            $info = db('admin')->select();
           $this->assign('data', $info);
           $this->assign("datas",$datas);
           $this->assign("sum",$sum);
           return $this->fetch('indexs');
       }      
//    function cny($ns)
//    {
//        static $cnums = array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"),
//        $cnyunits = array("圆","角","分"),
//        $grees = array("拾","佰","仟","万","拾","佰","仟","亿");
//        list($ns1,$ns2) = explode(".",$ns,2);
//        $ns2 = array_filter(array($ns2[1],$ns2[0]));
//        $ret = array_merge($ns2,array(implode("", cny_map_unit(str_split($ns1), $grees)), ""));
//        $ret = implode("",array_reverse(cny_map_unit($ret,$cnyunits)));
//        return str_replace(array_keys($cnums), $cnums,$ret);
//    }
//
//    function cny_map_unit($list,$units)
//    {
//        $ul = count($units);
//        $xs = array();
//        foreach (array_reverse($list) as $x)
//        {
//            $l = count($xs);
//            if($x!="0" || !($l%4))
//            {
//                $n=($x=='0'?'':$x).($units[($l-1)%$ul]);
//            }
//            else
//            {
//                $n=is_numeric($xs[0][0]) ? $x : '';
//            }
//            array_unshift($xs, $n);
//        }
//        return $xs;
//    }
    function convertMoney($num) {
        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角元拾佰仟万拾佰仟亿";
        $num = round($num, 2);  //输入金额四舍五入
        $num = $num * 100;
        if (strlen($num) > 10) {
            return "金额太大，请检查";
        }
        $i = 0;
        $c = "";
        while (1) {
            if ($i == 0) {
                $n = substr($num, strlen($num)-1, 1);
            } else {
                $n = $num % 10;
            }
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            $num = $num / 10;
            $num = (int)$num;
            if ($num == 0) {
                break;
            }
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            $m = substr($c, $j, 6);
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j-3;
                $slen = $slen-3;
            }
            $j = $j + 3;
        }
        if (substr($c, strlen($c)-3, 3) == '零') {
            $c = substr($c, 0, strlen($c)-3);
        }
        if (empty($c)) {
            return "零元整";
        }else{
            return $c . "整";
        }
    }


}

