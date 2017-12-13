<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {

    // 初始化控制话构造方法
    public function _auto(){
      // 选中标示
      $this->assign('nid','index');
    }

    // 前台首页
    public function index(){
        // GET
        if ( IS_GET === true ) {
          // 热销榜单
          $dataMa = M('merchandise_article')->where('type=2 AND status=1')->order('sort ASC')->select();
          $dataSvma = M('sv_merchandise_article')->where('type=2 AND status=1')->order('sort ASC')->select();
          $dataMShot = array_reverse(array_merge($dataMa,$dataSvma));
          $this->assign('dataMShot',$dataMShot);
          // 新品上市
          $dataMa = M('merchandise_article')->where('type=1 AND status=1')->order('sort ASC')->select();
          $dataSvma = M('sv_merchandise_article')->where('type=1 AND status=1')->order('sort ASC')->select();
          $dataMSnew = array_reverse(array_merge($dataMa,$dataSvma));
          $this->assign('dataMSnew',$dataMSnew);
          // 单类产品
          $dataNav = M('nav')->where('type=2 AND status=1')->order('sort ASC')->find();
          $dataSvm = M('sv_merchandise')->where('nid='.$dataNav['id'])->find();;
          $this->assign('dataSvm',$dataSvm);
          $dataSvma = M('sv_merchandise_article')->where('svmid='.$dataSvm['nid'].' AND status=1')->order('sort ASC')->select();
          $this->assign('dataSvma',$dataSvma);
          // display
          $this->display();
          die;
        }
    }

}