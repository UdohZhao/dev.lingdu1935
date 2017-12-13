<?php
namespace Wap\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public $id;
    public $db;
    // 初始化构造方法
    public function _auto(){
    }

    // Wap首页
    public function index(){
        // GET
        if ( IS_GET === true ) {
          $dataMa = M('merchandise_article')->where('type=2 AND status=1')->order('sort ASC')->select();
          $dataSvma = M('sv_merchandise_article')->where('type=2 AND status=1')->order('sort ASC')->select();
          $this->assign('data',array_merge($dataMa,$dataSvma));
          // display
          $this->display();
          die;
        }
    }
}