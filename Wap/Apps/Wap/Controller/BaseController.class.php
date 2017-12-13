<?php
namespace Wap\Controller;
use Think\Controller;
class BaseController extends Controller {
   // 控制器构造方法
   public function _initialize(){
      // 站点信息
      $data = M('site')->find();
      $data['banner_path'] = unserialize($data['banner_path']);
      $this->assign('dataSite',$data);
      //控制器初始化
      if(method_exists($this,'_auto'))
          $this->_auto();
   }

}