<?php
namespace Admin\Controller;
use Think\Controller;
class SiteController extends BaseController {
    public $id;
    public $db;
    // 控制器构造方法
    public function _auto(){
      $this->id = intval($_GET['id']);
      $this->db = M('site');
    }
    // 站点配置页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
            $data = $this->db->find();
            $data['banner_path'] = unserialize($data['banner_path']);
            $this->assign('data',$data);
            // display
            $this->display();
            die;
        }
        // data
        $data = $this->getData();
        if ( $this->id > 0 ) {
          if ( $this->db->where('id='.$this->id)->save($data) ) {
            $this->success('配置成功!','/Admin/Site/index');
          }else{
            $this->error('提交失败!');
          }
        }else{
          if ( $this->db->add($data) ) {
            $this->success('配置成功!','/Admin/Site/index');
          }else{
            $this->error('提交失败!');
          }
        }
    }

    // 初始化数据
    public function getData(){
        $data = array();
        $logo_path = I('post.logo_path');
        $banner_path = I('post.banner_path');
        // 文件上传
        if ( $_FILES['logo_path']['name'][0] != '' || $_FILES['banner_path']['name'][0] != '' ) {
            $info = $this->upload();
            if ( !is_array($info) ) {
                $this->error($info);
            }else{
                foreach ( $info AS $k => $v ) {
                  if ( $v['key'] == 'logo_path' ) {
                    $logo_path = '/' . $v['savepath'] . $v['savename'];
                  }else{
                    $bannerPath[] = '/' . $v['savepath'] . $v['savename'];
                  }
                }
                // 检测是否上传文件
                if ( $bannerPath ) {
                  // 序列化
                  $banner_path = serialize($bannerPath);
                }
            }
        }
        $data['logo_path'] = $logo_path;
        $data['banner_path'] = $banner_path;
        $data['site_name'] = I('post.site_name','','strip_tags,htmlspecialchars');
        $data['copyright'] = I('post.copyright','','strip_tags,htmlspecialchars');
        $data['status'] = I('post.status');
        $data['ctime'] = time();
        return $data;
    }

}