<?php
namespace Admin\Controller;
use Think\Controller;
class LayoutsController extends BaseController {
    // 控制器构造方法
    public function _auto(){
        // code...
    }
    // 头部
    public function headerss(){
        // display
        $this->display();
    }
    // 菜单
    public function menuss(){
        // display
        $this->display();
    }
    // 底部
    public function footerss(){
        // display
        $this->display();
    }


}