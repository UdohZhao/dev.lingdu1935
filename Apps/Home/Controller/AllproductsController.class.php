<?php
namespace Home\Controller;
use Think\Controller;
class AllproductsController extends BaseController {
    public $id;
    public $db;
    // 初始化控制话构造方法
    public function _auto(){
      $this->id = intval($_GET['id']);
      $this->db = M('merchandise_article');
      $this->assign('nid',$this->id);
    }

    // 全部产品页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
          $this->assign('id',$this->id);
          // 类别配置
          $dataAllp = M('all_products')->where('nid='.$this->id)->find();
          $this->assign('dataAllp',$dataAllp);
          // 类别
          $dataMc = M('merchandise_categories')->where('nid='.$this->id.' AND status=1')->order('sort ASC')->select();
          $this->assign('dataMc',$dataMc);
          // mcid
          if ( intval($_GET['mcid']) > 0 ) {
              $mcid = $_GET['mcid'];
          }else{
              $mcid = $dataMc[0]['id'];
          }
          $this->assign('mcid',$mcid);
          // 类别产品
          $dataMa = $this->db->where('mcid='.$mcid.' AND status=1')->order('sort ASC')->limit('0,6')->select();
          $this->assign('dataMa',$dataMa);
          // display
          $this->display();
          die;
        }
    }
}