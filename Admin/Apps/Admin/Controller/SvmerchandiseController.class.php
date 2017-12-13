<?php
namespace Admin\Controller;
use Think\Controller;
class SvmerchandiseController extends BaseController {
    public $id;
    public $db;
    // 控制器构造方法
    public function _auto(){
        $this->id = intval($_GET['id']);
        $this->db = M('sv_merchandise');
    }

    // 单种商品页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
            // id
            if ( $this->id ) {
                $data = M('nav')->where('id='.$this->id)->find();
                $this->assign('data',$data);
                // 是否已经配置
                $dataSvm = $this->db->where('nid='.$this->id)->find();
                $this->assign('dataSvm',$dataSvm);
            }
            $this->display();
            die;
        }
        $data = $this->getData();
        if ( intval($_POST['id']) > 0 ) {
            unset($data['nid']);
            if ( $this->db->where('id='.$_POST['id'])->save($data) ) {
                $this->success('配置成功!','/Admin/Nav/listss');
            }else{
                $this->error('提交失败!');
            }
        }else{
          if ( $this->db->add($data) ) {
                $this->success('配置成功!','/Admin/Nav/listss');
          }else{
                $this->error('提交失败!');
          }
        }
    }

    // 初始化数据
    private function getData(){
        $data = array();
        if ( $_FILES['banner_path']['name'] != '' || $_FILES['bannerPath']['name'] != '' || $_FILES['merchandise_path']['name'] != '' || $_FILES['merchandisePath']['name'] != '' ) {
            // 文件上传
            $info = $this->upload();
            if ( !is_array($info) ) {
                $this->error($info);
            }else{
                $banner_path = I('post.banner_path');
                $merchandise_path = I('post.merchandise_path');
                // 获取上传图片地址
                if ( $_FILES['banner_path']['name'] != '' ) {
                  $banner_path = '/' . $info['banner_path']['savepath'] . $info['banner_path']['savename'];
                }
                if ( $_FILES['bannerPath']['name'] != '' ) {
                  $banner_path = '/' . $info['bannerPath']['savepath'] . $info['bannerPath']['savename'];
                }
                if ( $_FILES['merchandise_path']['name'] != '' ) {
                  $merchandise_path = '/' . $info['merchandise_path']['savepath'] . $info['merchandise_path']['savename'];
                }
                if ( $_FILES['merchandisePath']['name'] != '' ) {
                  $merchandise_path = '/' . $info['merchandisePath']['savepath'] . $info['merchandisePath']['savename'];
                }
            }
        }else{
            $banner_path = I('post.banner_path');
            $merchandise_path = I('post.merchandise_path');
        }
        $data['nid'] = $this->id;
        $data['banner_path'] = $banner_path;
        $data['show_title'] = I('post.show_title','','strip_tags');
        $data['descriptionss'] = I('post.descriptionss','','htmlspecialchars');
        $data['merchandise_path'] = $merchandise_path;
        $data['ctime'] = time();
        return $data;
    }



}