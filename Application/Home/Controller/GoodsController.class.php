<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/17
 * Time: 9:37
 */
namespace Home\Controller;
use Think\Controller;

class GoodsController extends Controller{
    // 商品展示方法
    public function showlist()
    {
        // 实例化方法
        $model = M('Goods');
        // 查询
        $data = $model -> select();
        // 传递数据
        $this -> assign('data',$data);
        $this -> display();
    }
    // 对添加商品属性进行操作的方法 
    public function detail() 
    {
        $goods_id = I('get.goods_id');
        // 查询
        $data = M('Goods') -> find($goods_id);
        // 显示颜色，内存等值的sql语句,group_concat将查询出的几行内容变成列
        // $sql = "SELECT t1.attr_id,t1.attr_name,GROUP_CONCAT(t2.attr_value)
        // as attr_values FROM sp_attribute as t1 ,sp_goodsattr as t2
        // WHERE t1.attr_id = t2.attr_id and t2.goods_id=14
        // and t1.attr_sel='1' GROUP BY t1.attr_id";
        // 执行连贯操作
        $rst = M('Goodsattr') 
            -> field('t1.attr_id,t1.attr_name,
            GROUP_CONCAT(t2.attr_value) as attr_values')
            -> table('sp_attribute as t1 ,sp_goodsattr as t2')
            -> where("t1.attr_id = t2.attr_id and 
            t2.goods_id={$data['goods_id']} and t1.attr_sel='1'")
            ->group('t1.attr_id')
            ->select();
        // 查询后得到一个二维数组,为了方便传递模板后遍历，将$rst数组中的value值拼接成数组
          foreach ($rst as $key => $value) {
              $rst[$key]['attr_vals'] = explode(',',$value['attr_values']);
          }
        // dump($rst);die;
        // 商品介绍
        $sql = "SELECT t1.attr_id,t2.attr_name, t1.attr_value FROM 
                sp_attribute as t2 ,sp_goodsattr as t1 
                WHERE t1.attr_id = t2.attr_id and t1.goods_id=14 
                and t2.attr_sel='0'";
        $single = M() -> field(' t1.attr_id,t2.attr_name, t1.attr_value')
                      -> table('sp_attribute as t2 ,sp_goodsattr as t1')
                      -> where("t1.attr_id = t2.attr_id and 
                      t1.goods_id={$data['goods_id']} and t2.attr_sel='0'")
                      ->select();
        // 传递数据
        $this -> assign('rst',$rst); 
        $this -> assign('single',$single);
        $this -> assign('data',$data);
        $this -> display();
    }
}