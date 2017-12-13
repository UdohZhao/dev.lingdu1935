<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
   // 控制器构造方法
   public function _initialize(){
      // 站点信息
      $data = M('site')->find();
      $data['banner_path'] = unserialize($data['banner_path']);
      $this->assign('dataSite',$data);
      // 站点导航
      $dataNav = M('nav')->where('status=1')->order('sort ASC')->select();
      foreach ( $dataNav AS $k => $v ) {
          // if
          if ( $v['type'] == 1 ) {
            $dataNav[$k]['jumpUrl'] = '/Allproducts/index/id/'.$v['id'];
          }else if ( $v['type'] == 2 ) {
            $dataNav[$k]['jumpUrl'] = '/Svmerchandise/index/id/'.$v['id'];
          }else if ( $v['type'] == 3 ) {
            $dataNav[$k]['jumpUrl'] = '/Article/listss/id/'.$v['id'];
          }else if ( $v['type'] == 4 ) {
            $dataNav[$k]['jumpUrl'] = '/Article/details/id/'.$v['id'];
          }else{
            $dataNav[$k]['jumpUrl'] = '/';
          }
      }
      $this->assign('dataNav',$dataNav);
      // 控制器初始化
      if(method_exists($this,'_auto'))
          $this->_auto();
   }

}
