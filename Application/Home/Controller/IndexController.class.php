<?php

namespace Home\Controller;

use Common\Controller\HomeBaseController;

/**
 * 登陆首页
 */
class IndexController extends HomeBaseController {

    /**
     * 首页
     */
    public function index() {
        if (check_login()) {
            $this->redirect(U('Admin/Index/index'));
        }
        $this->display();
    }

    /**
     * 验证登陆
     */
    public function checkLogin() {
        $username = I('post.username', '');
        $password = I('post.password', '');
        $verify = I('post.verify', '');
        if (empty($username)) {
            $this->error('用户名不能为空');
        }
        if (empty($password)) {
            $this->error('密码不能为空');
        }
        if (!check_verify($verify)) {
            $this->error('验证码错误');
        }
        $data = M('users')->where("`username`='{$username}'")->find();
        if (empty($data)) {
            $this->error('该用户不存在');
        }
        if($data['password'] != md5($password)) {
            $this->error('密码错误');
        }
        session('userInfo', $data);
        $this->redirect(U('Admin/Index/index'));
    }

    /**
     * 验证码
     */
    public function showVerify() {
        show_verify();
    }

}
