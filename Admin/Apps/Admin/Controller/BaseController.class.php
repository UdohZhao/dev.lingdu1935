<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
   //控制器构造方法
   public function _initialize(){
      // session
      if ( !isset($_SESSION['userinfo']) )
      {
          redirect('/Admin/Login/index');
      }
      //控制器初始化
      if(method_exists($this,'_auto'))
          $this->_auto();
   }

   // 文件上传
   public function upload(){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     '../'; // 设置附件上传根目录
    $upload->savePath  =     'Public/uploads/'; // 设置附件上传（子）目录
    // 上传文件
    $info   =   $upload->upload();
    if(!$info) {// 上传错误提示错误信息
        return $upload->getError();
    }else{// 上传成功
        return $info;
    }
   }

}