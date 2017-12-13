<?php
namespace Wap\Controller;
use Think\Controller;
class ProductController extends BaseController {
    public $id;
    public $db;
    // 初始化构造方法
    public function _auto(){
      $this->db = M('merchandise_article');
    }

    // 产品首页
    public function index(){
        // GET
        if ( IS_GET === true ) {
          $data = $this->db->where('status=1')->order('sort ASC')->select();
          $this->assign('data',$data);
          // display
          $this->display();
          die;
        }
    }
}