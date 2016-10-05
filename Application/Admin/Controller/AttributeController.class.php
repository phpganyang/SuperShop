<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/21
 * Time: 10:56
 */
namespace Admin\Controller;
class AttributeController extends  CommonController
{
    // 构建添加方法
    public function add()
    {
        if (IS_POST) {
            // 接受传递值
            $post = I('post.');
            // 替换atr_vals存在的中文逗号
            $post['attr_vals'] = str_replace('，',',',$post['attr_vals']);
            // 写入数据表
            $rst = M('Attribute') -> add($post);
            if ($rst) {
                $this -> success('添加成功');
            } else {
                $this -> error('添加失败');
            }
        } else {
            // 处理下拉列表
            $data = M('Type') -> select();
            $this -> assign('data',$data);
            $this -> display();
        }
    }
    public function showList()
    {
        // 实例化表格
        $model = M('Attribute');
        // 联表查询
        $sql = "select t1.*,t2.type_name from sp_attribute as t1,
                sp_type as t2 WHERE t1.type_id=t2.type_id ";
        $data = $model -> field('t1.*,t2.type_name') 
                       ->table('sp_attribute as t1,sp_type as t2') 
                       ->where('t1.type_id=t2.type_id')
                       -> select();
        $this -> assign('data',$data);
        $this -> display();
    }
}