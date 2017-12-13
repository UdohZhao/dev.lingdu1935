<?php
namespace Home\Controller;
use Think\Controller;
class SvmerchandiseController extends BaseController {
    public $id;
    public $db;
    // 初始化控制话构造方法
    public function _auto(){
      $this->id = intval($_GET['id']);
      $this->db = M('sv_merchandise_article');
      $this->assign('nid',$this->id);
    }

    // 单类产品页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
          $this->assign('id',$this->id);
          // 类别配置
          $dataSvm = M('sv_merchandise')->where('nid='.$this->id)->find();
          $this->assign('dataSvm',$dataSvm);
          $dataSvma = $this->db->where('svmid='.$dataSvm['nid'].' AND status=1')->order('sort ASC')->limit('0,6')->select();
          $this->assign('dataSvma',$dataSvma);
          // display
          $this->display();
          die;
        }
    }

}