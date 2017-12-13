<?php
namespace Admin\Controller;
use Think\Controller;
class AllproductsController extends BaseController {
    public $id;
    public $db;
    //控制器构造方法
    public function _auto(){
        $this->id = intval($_GET['id']);
        $this->db = M('all_products');
    }
    // 全部商品配置页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
            // id
            if ( $this->id ) {
                $data = M('nav')->where('id='.$this->id)->find();
                $this->assign('data',$data);
                // 是否已经配置
                $dataAp = $this->db->where('nid='.$this->id)->find();
                $this->assign('dataAp',$dataAp);
            }
            // display
            $this->display();
            die;
        }
        // 组装数据
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
        // banner_path bannerPath
        if ( $_FILES['banner_path']['name'] != '' || $_FILES['bannerPath']['name'] != '' ) {
            // 文件上传
            $info = $this->upload();
            if ( !is_array($info) ) {
                $this->error($info);
            }else{
                if ( $_FILES['banner_path']['name'] != '' ) {
                    // 获取上传图片地址
                    $banner_path = '/' . $info['banner_path']['savepath'] . $info['banner_path']['savename'];
                }
                if ( $_FILES['bannerPath']['name'] != '' ) {
                    // 获取上传图片地址
                    $banner_path = '/' . $info['bannerPath']['savepath'] . $info['bannerPath']['savename'];
                }
            }
        }else{
            $banner_path = I('post.banner_path');
        }
        $data['nid'] = $this->id;
        $data['banner_path'] = $banner_path;
        $data['show_title'] = I('post.show_title','','strip_tags');
        $data['ctime'] = time();
        return $data;
    }

}