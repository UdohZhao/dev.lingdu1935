<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends BaseController {
    public $id;
    public $db;
    // 初始化控制话构造方法
    public function _auto(){
      $this->id = intval($_GET['id']);
      $this->db = M('article');
      $this->assign('nid',$this->id);
    }

    // 文章详情页面
    public function details(){
        // GET
        if ( IS_GET === true ) {
          $dataA = $this->db->where('nid='.$this->id.' AND status=1')->order('sort ASC')->find();
          $this->assign('dataA',$dataA);
          // display
          $this->display();
          die;
        }
    }

    // 文章列表页面
    public function listss(){
      // display
      $this->display();
    }
}