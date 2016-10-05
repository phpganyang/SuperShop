<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    // 设置首页
    public function index(){
        $this-> display();
    }
    // 设置左侧边栏显示
    public function left(){
        // 1.从session获取当前的用户 id
        $role_id = session('role_id');
        $model = M('Auth');//直接查询auth表。因为其拥有所有权限
        // 2.判断登陆人员身份
        if ($role_id == 1) {
            // 超级管理员
            $top = $model -> where('auth_pid = 0') -> select();//顶级菜单
            $cate = $model -> where('auth_pid > 0') -> select();//非顶级菜单
            // dump($cate);die;
        } else {
            // 普通人员
            $role = M('Role') -> find($role_id);//用户组信息,通过用户组id查询到权限信息
            $top = $model -> where("auth_pid = 0 and auth_id in ({$role['role_auth_ids']})") -> select(); //顶级菜单
            $cate = $model -> where("auth_pid > 0 and auth_id in ({$role['role_auth_ids']})") -> select();
        }
        // 传递数据
        $this -> assign('top',$top);
        $this -> assign('cate',$cate);
        $this-> display();
    }
    //  设置主页显示
    public function main(){

        $this-> display();
    }
    // 设置置顶显示
    public function top(){
        $this-> display();
    }
    
}