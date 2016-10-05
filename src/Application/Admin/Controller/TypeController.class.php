<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/21
 * Time: 10:17
 */
namespace Admin\Controller;
class TypeController extends CommonController
{
    //添加商品类型
    public function add()
    {
        if (IS_POST) {
           $post = I('post.');
            // 实例化模型
           $rst = M('Type') -> add($post);
            if ($rst) {
                $this -> success('添加成功',U('showList'),3);
            } else {
                $this -> error('添加失败');
            }
        } else {
           $this -> display();
        }
    }
    // 显示商品列表页
    public function showList()
    {
        // 实例化模型
        $model = M('Type');
        // 查询
        $data = $model -> select();
        // 传递参数
        $this -> assign('data',$data);
        // 展示
        $this -> display();
    }
}