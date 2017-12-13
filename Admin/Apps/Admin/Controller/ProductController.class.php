<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends BaseController {
    public $id;
    public $db;
    // 控制器构造方法
    public function _auto(){
      $this->id = intval($_GET['id']);
      $this->dbma = M('merchandise_article');
      $this->dbsvma = M('sv_merchandise_article');
    }

    // 产品发布页面
    public function index(){
        // GET
        if ( IS_GET === true ) {
            // id
            if ( $this->id ) {
                if ( $_GET['type'] == 2 ) {
                    $db = $this->dbsvma;
                    $this->assign('type',$_GET['type']);
                }else{
                    $db = $this->dbma;
                }
                $data = $db->where('id='.$this->id)->select();
                $this->assign('data',$data[0]);
            }
            //  mc svm
            $nav = M('nav')->where(' status=1 AND type=1 ')->order('sort ASC')->limit('0,1')->select();
            $this->assign('navName',$nav[0]['cname']);
            $dataMc = M('merchandise_categories')->where('nid='.$nav[0]['id'])->order('sort ASC')->select();
            $this->assign('dataMc',$dataMc);
            $dataSvm = M('nav')->where(' status=1 AND type=2 ')->order('sort ASC')->select();
            $this->assign('dataSvm',$dataSvm);
            // display
            $this->display();
            die;
        }
        // mcid svmid
        if ( $_POST['mcid'] == 0 && $_POST['svmid'] == 0 ) {
            $this->error('请按需要选择产品类型!');
        }
        // data
        $data = $this->getData();
        if ( $data['mcid'] != 0 && $data['svmid'] == 0 ) {
            if ( intval($_POST['id']) > 0 ) {
                if ( $_POST['type'] == 2 ) {
                    $db = $this->dbsvma;
                }else{
                    $db = $this->dbma;
                }
                if ( $db->where('id='.$_POST['id'])->save($data) ) {
                    $this->success('更新成功!','/Admin/Product/listssMc');
                }else{
                    $this->error('提交失败!');
                }
            }else{
               // 防止重复添加
               $mcid = $data['mcid'];
               $title = $data['title'];
               if ( $this->dbma->where("mcid='$mcid' AND title='$title'")->find() ) {
                    $this->error('请勿重复添加!');
               }
               if ( $this->dbma->add($data) ) {
                    $this->success('添加成功!','/Admin/Product/listssMc');
               }else{
                    $this->error('提交失败!');
               }
            }
        }
        if ( $data['svmid'] != 0 && $data['mcid'] == 0 ) {
            if ( intval($_POST['id']) > 0 ) {
                if ( $_POST['type'] == 2 ) {
                    $db = $this->dbsvma;
                }else{
                    $db = $this->dbma;
                }
                if ( $db->where('id='.$_POST['id'])->save($data) ) {
                    $this->success('更新成功!','/Admin/Product/listssSvm');
                }else{
                    $this->error('提交失败!');
                }
            }else{
               // 防止重复添加
               $svmid = $data['svmid'];
               $title = $data['title'];
               if ( $this->dbsvma->where("svmid='$svmid' AND title='$title'")->find() ) {
                    $this->error('请勿重复添加!');
               }
                if ( $this->dbsvma->add($data) ) {
                    $this->success('添加成功!','/Admin/Product/listssSvm');
                }else{
                    $this->error('提交失败!');
                }
            }
        }
        if ( $data['mcid'] != 0 && $data['svmid'] != 0 ) {
            if ( intval($_POST['id']) > 0 ) {
                $this->error('修改时请勿选择两项类别!');
            }
           // 防止重复添加
           $mcid = $data['mcid'];
           $svmid = $data['svmid'];
           $title = $data['title'];
           if ( $this->dbma->where("mcid='$mcid' AND title='$title'")->find() ) {
                $this->error('请勿重复添加!');
           }
           if ( $this->dbsvma->where("svmid='$svmid' AND title='$title'")->find() ) {
                $this->error('请勿重复添加!');
           }
           if ( $this->dbma->add($data) ) {
            if ( $this->dbsvma->add($data) ) {
                $this->success('添加成功!');
            }else{
                $this->error('提交失败!');
            }
           }else{
                $this->error('提交失败!');
           }
        }
    }

    // 初始化数据
    private function getData(){
        $data = array();
        // 文件上传
        if ( $_FILES['picture_path']['name'] != '' || $_FILES['picturePath']['name'] != '' ) {
            $info = $this->upload();
            if ( !is_array($info) ) {
                $this->error($info);
            }else{
                if ( $info['picture_path']['savepath'] != '' ) {
                    $picture_path = '/' . $info['picture_path']['savepath'] . $info['picture_path']['savename'];
                }
                if ( $info['picturePath']['savepath'] != '' ) {
                    $picture_path = '/' . $info['picturePath']['savepath'] . $info['picturePath']['savename'];
                }
            }
        }else{
            $picture_path = I('post.picture_path');
        }
        $data['title'] = I('post.title','','strip_tags,htmlspecialchars');
        $data['picture_path'] = $picture_path;
        $data['mcid'] = I('post.mcid');
        $data['svmid'] = I('post.svmid');
        $data['original_cost'] = I('post.original_cost','','strip_tags,htmlspecialchars');
        $data['promotion_price'] = I('post.promotion_price','','strip_tags,htmlspecialchars');
        $data['sort'] = I('post.sort','','intval');
        $data['type'] = 0;
        $data['status'] = I('post.status');
        $data['ctime'] = time();
        return $data;
    }

    // 产品类别列表
    public function listssMc(){
        // id
        $this->assign('id',$this->id);
        // search
        if ( isset($_POST['search']) ) {
            $sWhere = " AND title like '%".$_POST['search']."%' ";
        }
        $count      = $this->dbma->where('mcid='.$this->id)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 产品类别
        $dataMa = $this->dbma->where('mcid='.$this->id.$sWhere)->limit($Page->firstRow.','.$Page->listRows)->order('sort ASC')->select();
        $this->assign('dataMa',$dataMa);
        $this->assign('page',$show);// 赋值分页输出
        $categoryName = M('merchandise_categories')->where('id='.$this->id)->getField('category_name');
        $this->assign('categoryName',$categoryName);
        // display
        $this->display();
    }

    // 单类产品列表
    public function listssSvm(){
        // search
        if ( isset($_POST['search']) ) {
            $sWhere = " AND title like '%".$_POST['search']."%' ";
        }
        // 单类产品
        $dataNav = M('nav')->where(' status=1 AND type=2 ')->order('sort ASC')->select();
        $this->assign('dataNav',$dataNav);
        if ( $this->id )  {
            $nid = $this->id;
        }else if ( $dataNav ) {
            $nid = $dataNav[0]['id'];
        }else{
            $nid = '';
        }
        // nid
        $this->assign('nid',$nid);
        $count      = $this->dbsvma->where('svmid='.$nid)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 单类产品文章
        $dataSvm = $this->dbsvma->where('svmid='.$nid.$sWhere)->order('sort ASC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('dataSvm',$dataSvm);
        $this->assign('page',$show);// 赋值分页输出
        // display
        $this->display();
    }

    // typeCommon
    public function typeCommon(){
        if ( IS_GET === true ) {
        if ( intval($_GET['id']) > 0 ) {
            if ( $_GET['mtype'] == 2 ) {
                $db = $this->dbsvma;
            }else{
                $db = $this->dbma;
            }
            $data['type'] = $_GET['type'];
            $data['ctime'] = time();
            if ( $db->where('id='.$_GET['id'])->save($data) ) {
                $this->success('更新成功!',$_SERVER['HTTP_REFERER']);
            }else{
                $this->error('提交失败!');
            }
         }
        }
    }



}