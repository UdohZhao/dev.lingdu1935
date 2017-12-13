<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends BaseController {
    public $id;
    public $db;
    // 控制器构造方法
    public function _auto(){
      $this->id = intval($_GET['id']);
      $this->db = M('article');
    }

    // 文章页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
            $dataNav = M('nav')->where('type=3 OR type=4 AND status=1')->order('sort ASC')->select();
            $this->assign('dataNav',$dataNav);
            // id
            if ( $this->id ) {
              $data = $this->db->where('id='.$this->id)->find();
              $this->assign('data',$data);
            }
            // display
            $this->display();
            die;
        }
        // data
        $data = $this->getData();
        // id
        if ( intval($_POST['id']) > 0 )
        {
            if ( $this->db->where('id='.$_POST['id'])->save($data) ) {
                $this->success('更新成功!','/Admin/Article/listss');
            }else{
                $this->error('提交失败!');
            }
        }else{
          if ( $this->db->add($data) ) {
              $this->success('发布成功!','/Admin/Article/listss');
          }else{
              $this->error('提交失败!');
          }
        }
    }

    // 初始化数据
    public function getData(){
        $data = array();
        $data['nid'] = I('post.nid');
        $data['title'] = I('post.title','','strip_tags,htmlspecialchars');
        $data['content'] = I('post.content','','html_entity_decode');
        $data['sort'] = I('post.sort','','intval');
        $data['status'] = I('post.status');
        $data['ctime'] = time();
        return $data;
    }

    // 文章列表
    public function listss(){
        $dataNav = M('nav')->where('type=3 OR type=4 AND status=1')->order('sort ASC')->select();
        $this->assign('dataNav',$dataNav);
        // nid
        if ( $this->id ) {
            $nid = $this->id;
        }else if ( $dataNav ) {
            $nid = $dataNav[0]['id'];
        }else{
            $this->error('未知错误!');
        }
        $this->assign('nid',$nid);
        // search
        if ( isset($_POST['search']) ) {
            // sWhere
            $sWhere = " AND title like '%".$_POST['search']."%'";
        }
        // 数据分页
        $count      = $this->db->where('nid='.$nid)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // data
        $data = $this->db->where('nid='.$nid.$sWhere)->order('sort ASC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('data',$data);
        $this->assign('page',$show);// 赋值分页输出
        // display
        $this->display();
    }

}