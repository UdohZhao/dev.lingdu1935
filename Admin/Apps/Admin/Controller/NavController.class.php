<?php
namespace Admin\Controller;
use Think\Controller;
class NavController extends BaseController {
    public $id;
    public $db;
    //控制器构造方法
    public function _auto(){
        // id db
        $this->id = intval($_GET['id']);
        $this->db = M('nav');
    }

    // 导航页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
            // id
            if ( $this->id ) {
                $data = $this->db->where('id='.$this->id)->find();
                $this->assign('data',$data);
            }
            $this->display();
            die;
        }
        $data = $this->getData();
        $type = $data['type'];
        $cname = $data['cname'];
        // id
        if ( intval($_POST['id']) > 0 ) {
            // 修改
            if ( $this->db->where('id='.$_POST['id'])->save($data) ){
                $this->success('修改成功!','/Admin/Nav/listss');
            }else{
                $this->error('提交失败!');
            }
        }else{
            // 防止重复添加
            if ( $this->db->where("type='$type' AND cname='$cname'")->find() ){
                $this->error('请勿重复在该类型下添加相同导航名称!');
                die;
            }
            // 添加
            if ( $this->db->add($data) ){
                $this->success('添加成功!','/Admin/Nav/listss');
            }else{
                $this->error('提交失败!');
            }
        }
    }

    // 初始化数据
    private function getData(){
        $data = array();
        $data['cname'] = I('post.cname','','strip_tags');
        $data['type'] = I('post.type','','intval');
        $data['sort'] = I('post.sort','','intval');
        $data['status'] = I('post.status','','intval');
        $data['ctime'] = time();
        return $data;
    }

    // 导航列表页
    public function listss(){
        // search
        if ( isset($_POST['search']) ) {
            $search = $_POST['search'];
            // WHERE
            $WHERE = " cname like '%$search%' ";
        }
        $count      = $this->db->where("status='1'")->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $data = $this->db->where($WHERE)->order("sort ASC")->limit($Page->firstRow.','.$Page->listRows)->select();
        // 赋值数据集
        $this->assign('data',$data);
        // 赋值分页输出
        $this->assign('page',$show);
        $this->display();
    }

}