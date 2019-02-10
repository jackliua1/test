<?php
namespace application\index\controller;
use think\console\command\make\Controller;

class BookController extends CommonController{

    public function index(){

        return $this->fetch();
    }

}







