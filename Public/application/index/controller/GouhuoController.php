<?php
namespace application\index\controller;
class GouhuoController extends CommonController{
    public function gouhuo(){
$data=input();
var_dump($data);

        return $this->fetch();

    }



}