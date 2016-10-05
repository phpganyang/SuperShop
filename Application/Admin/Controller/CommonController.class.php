<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/21
 * Time: 8:20
 */
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller
{
    // 编写构造方法.有两种（1）__construct(),
    // (2)TP中封装的构造方法_initialize
    public function __construct()
    {
        // 构造父类
        parent::__construct();
        // 判断用户是否登录，是否有权限
        $uid = session('mg_id');//获取用户id
        if (!$uid) {
            // 没有登录；让其回到登录页
            $url = U('Public/login');
            $script = "<script>top.location.href='$url'</script>";
            echo $script;die;
        }
        // 第二角度
        // 排除用户超级管理员
        if(session('role_id') >1 ) {
            // 权限判断
            // 有没有权限取决于role表里的AC字段
            $auth = M('Role') -> find(session('role_id'));
            $ac = strtolower( $auth['role_auth_ac'] . ',Index-index,Index-left,Index-top,Index-main');
            // 获取当前用户访问的控制器-方法
            $curr = strtolower(CONTROLLER_NAME . "-" .ACTION_NAME);
            // 判断字符串在不在另一个字符串中使用strpos函数
            if (strpos($ac,$curr) === false) {
                // 没有权限
                $this ->  error('您没有权限',U('Index/main'),3);
            }
        }
    }
}