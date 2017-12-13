<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {
    //控制器构造方法
    public function _auto(){

    }

    public function index(){
        // GET
        if ( IS_GET === true ) {
            $this->display();
            die;
        }
    }

}