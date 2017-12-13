<?php
namespace Wap\Controller;
use Think\Controller;
class NewsController extends BaseController {

    // 初始化构造方法
    public function _auto(){

    }

    // 新闻首页
    public function index(){
        // GET
        if ( IS_GET === true ) {

          // display
          $this->display();
          die;
        }
    }

    // 详情页面
    public function details(){
        // GET
        if ( IS_GET === true ) {

          // display
          $this->display();
          die;
        }
    }

}