<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/20
 * Time: 11:16
 */
namespace Admin\Controller;
use Think\Controller;

class AuthController extends CommonController
{ 
    // 构建展示页面
    public function showList()
    {
        // 获取数据
        $data = M('Auth')->select();
        // 使用无线级分类函数,注意修改函数类参数
        $data = getTree($data);
        // 传递数据
        $this -> assign('data',$data);
        // 显示模板
        $this -> display();
    }    
    // 添加权限功能
    public function add() 
    {
        if(IS_POST){
            // 获取数据
            $post = I('post.');
            // 实例化模型
            $model = M('auth');
            // 数据入库
            $rst = $model -> add($post);
            if ($rst) {
                $this -> success('添加权限成功',U('showList'),3);
            } else {
                $this -> error('添加失败');
            }
        } else {
            // 实例化模型
            $model = M('Auth');
            // 在下拉列表中显示父级,查询
            $data = $model -> where("auth_pid = 0") -> select();
            // 传递数据
            $this -> assign('data',$data);
            // 显示模板
            $this -> display();
        }
    }
    // 构建更新方法
    public function edit()
    {
        if (IS_POST) {
            // 接受数据
            $post = I('post.');
            // 实例化模型
            $model = M('Auth');
            // 调用更新方法
            $rst = $model -> save($post);
            if ($rst) {
                $this -> success('更新成功',U('showList'),3);
            } else {
                $this -> error('更新失败');
            }
        } else {
            // 接受id
            $id = I('get.auth_id');
            // 实例化模型
            $model = M('Auth');
            // 传递出下拉列表的选项
            $op = $model -> where("auth_pid = 0") -> select();
            // 查询数据
            $data = $model -> find($id);
            // 传递数据
            $this -> assign('data',$data);
            $this -> assign('op',$op);
            // 调用模板
            $this -> display();
        }
    }
    // 删除方法
    public function del()
    {
        $id = I('get.auth_id');
        // 实例化模型
        if(M('Auth')-> where('auth_pid='.$id) -> count() > 0) {
            $this -> error('请先删除子分类');
        } else {
            if ( M('Auth') -> delete($id))
            {
                $this -> success('删除成功');
            } else {
                $this -> error('删除失败');
            }
        }
    }
}