<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/17
 * Time: 10:21
 */
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller
{
    // 构建登陆及验证方法
    public function login()
    {
        if (IS_POST) {
            $post = I('post.');
            // 加密密码
            $post['mg_pwd'] = getPwd($post['mg_pwd']);
            $model = M('manager');
            $data = $model -> where($post) -> find();
            if ($data) {
                // 存储用户
                session('mg_id',$data['mg_id']);//用户id信息
                session('mg_time',$data['mg_time']);//登陆时间
                session('mg_name',$data['mg_name']);//用户名
                session('role_id',$data['role_id']);//角色id
                // 修改成功登陆时间
                $model -> save(array('mg_id' => session('mg_id'),'mg_time' => time()));
                $this -> success('登陆成功',U('Index/index'),3);
            } else {
                $this -> error('用户名密码有误');
            }
        } else {
            $this -> display();
        }

    }
    // 退出方法
    public function logout()
    {
        // 清空session
        session(null);
        if(!session('?mg_id')){
            $this -> success('退出成功',U('Public/login'),3);
        }
    }
}