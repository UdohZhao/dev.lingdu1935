<?php
namespace Admin\Controller;
use Think\Controller;
class McategoriesController extends BaseController {
    public $id;
    public $db;
    //控制器构造方法
    public function _auto(){
        $this->id = intval($_GET['id']);
        $this->db = M('merchandise_categories');
    }

    // 产品类别页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
            // 导航类别 1
            $dataNav = M('nav')->where('status=1 AND type=1')->order('sort ASC')->select();
            $this->assign('dataNav',$dataNav);
            if ( $this->id ) {
                $dataMc = $this->db->where('id='.$this->id)->select();
                $this->assign('dataMc',$dataMc[0]);
            }
            // display
            $this->display();
            die;
        }
        // data
        $data = $this->getData();
        if ( intval($_POST['id']) > 0 ) {
            if ( $this->db->where('id='.$_POST['id'])->save($data) ) {
                $this->success('更新成功!','/Admin/Mcategories/listss');
            }else{
                $this->error('提交失败!');
            }
        }else{
            $nid = $data['nid'];
            $category_name = $data['category_name'];
            // 防止重复添加
            if ( $this->db->where("nid='$nid' AND category_name='$category_name'")->find() ) {
                $this->error('请勿重复添加!');
            }else{
                if ( $this->db->add($data) ) {
                    $this->success('添加成功!','/Admin/Mcategories/listss');
                }else{
                    $this->error('提交失败!');
                }
            }
        }
    }

    // 初始化数据
    private function getData(){
        $data = array();
        $data['nid'] = I('post.nid');
        $data['category_name'] = I('post.category_name','','strip_tags,htmlspecialchars');
        $data['sort'] = I('post.sort','','intval');
        $data['status'] = I('post.status');
        $data['ctime'] = time();
        return $data;
    }

    // 产品类别列表
    public function listss(){
        // search
        if ( isset($_POST['search']) ) {
            // sWhere
            $sWhere = " AND category_name like '%".$_POST['search']."%'";
        }
        // 导航类别 1
        $dataNav = M('nav')->where('status=1 AND type=1')->order('sort ASC')->select();
        if ( $this->id )  {
            $nid = $this->id;
        }else if ( $dataNav ) {
            $nid = $dataNav[0]['id'];
        }else{
            $nid = '';
        }
        $this->assign('nid',$nid);
        $count      = $this->db->where('nid='.$nid)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $dataMc = $this->db->where('nid='.$nid.$sWhere)->order('sort ASC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('dataNav',$dataNav);
        $this->assign('dataMc',$dataMc);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }



}