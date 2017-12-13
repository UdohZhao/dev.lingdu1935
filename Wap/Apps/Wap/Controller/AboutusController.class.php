<?php
namespace Wap\Controller;
use Think\Controller;
class AboutusController extends BaseController {
    public $id;
    public $db;
    // 初始化构造方法
    public function _auto(){
      $this->id = 7;
      $this->db = M('article');
    }

    // 关于我们首页
    public function index(){
        // GET
        if ( IS_GET === true ) {
          $data = $this->db->where('nid='.$this->id.' AND status=1')->order('sort ASC')->find();
          $this->assign('data',$data);
          // display
          $this->display();
          die;
        }
    }
}