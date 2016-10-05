<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/20
 * Time: 9:29
 */
namespace Admin\Controller;
use Think\Controller;

class RoleController extends CommonController 
{
    // showList方法.展示用户组/角色信息
    public function showList()
    {
    // 实例化模型(role)表
    $model = M('Role');
    // 查询
    $data = $model -> select();
    // 传递数据
    $this -> assign('data',$data);
        // 展示模板
    $this -> display();
    }
    // setAuth方法展示权限
    public  function  setAuth ()
    {
        if(IS_POST){
            // 接受数据
            $post = I('post.');
            // 这里要用到自定义的模型方法，所以实例化模型应该用D方法
            $model = D('Role');
            //  写入自定义的方法
            $rst = $model ->saveAuth($post);
            if ($rst) {
                $this -> success('权限更新成功',U('showList'),3);
            } else {
                $this -> erroe('权限更新失败');
            }
        } else {
        // 接受id
            $id = I('get.role_id');
            // 实例化模型
            $model = M('Role');
            $info = $model -> find($id);
            // 设置权限首先需要将顶级权限和非顶级权限全列出来
            $top = M('Auth') -> where("auth_pid = 0") -> select();
            $cate = M('Auth') -> where("auth_pid > 0") -> select();
           // 传递数据给模板
            $this -> assign('top',$top);
            $this -> assign('cate',$cate);
            $this -> assign('info',$info);
            // 展示模板
           $this -> display();
        }
    }
    // 构建删除方法
    public function del()
    {
        $id = I('get.auth_id');
    }
    // 添加方法
    public function add()
    {
        if (IS_POST) {
            $post = I('post.');
            $model = D('Role');
            $post = $model -> addAuth($post);
            $post['role_name'] = I('post.role_name');
            $rst = $model -> add($post);
            if ($rst) {
                $this -> success('添加成功',U('showList'),3);
            } else {
                $this -> error('添加失败');
            }
        } else {
            // 实例化模型
            $model = M('Auth');
            // 查询
            $top = $model -> where('auth_pid = 0') -> select();
            $cate = $model -> where('auth_pid > 0') ->select();
            $this -> assign('top',$top);
            $this -> assign('cate',$cate);
            $this -> display();
        }
    }
}