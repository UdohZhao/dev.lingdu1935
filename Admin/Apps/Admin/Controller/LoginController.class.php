<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

    // verify code
    public function verifyCode(){
      $Verify = new \Think\Verify(array('length'=>4));
      $Verify->entry();
    }

    // index
    public function index(){
        if ( IS_GET === true ) {
            // display
            $this->display();
            die;
        }
        // data
        $data = $this->getData();
        $username = $data['username'];
        $password = md5(crypt($data['password'],substr($data['password'],0,2)));
        // rememberAccount
        if ( $_POST['rememberAccount'] == 1 ) {
         setcookie("username",$username,time()+3600*3600*24);
        }else{
         setcookie("username",'',time()-1);
        }
        // 检测验证码
        $code = check_verify($data['code']);
        if ($code === false) { $this->error('验证码错误!'); }
        // 检测用户是否存在
        $user = M("admin_user"); // 实例化User对象
        // 查找status值为1name值为think的用户数据
        $data = $user->where("username='$username' AND password='$password'")->find();
        if ( $data === NULL ) {
          $this->error('账号或者密码错误!');
        }
        else{
          $_SESSION['userinfo'] = $data;
          redirect('/Admin/Index/index');
        }
    }

    // 初始化数据
    private function getData(){
      $data = array();
      $data['username'] = I('post.username','','strip_tags');
      $data['password'] = I('post.password','','strip_tags');
      $data['code'] = I('post.code','','strip_tags');
      return $data;
    }

    // 退出
    public function logout(){
        // 销毁session
        session('[destroy]');
        header('Location:/Admin/Login/index');
    }

}
