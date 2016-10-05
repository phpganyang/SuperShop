<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/25
 * Time: 9:35
 */
namespace Home\Controller;
use Think\Controller;
use Tools\Cart;

class CartController extends Controller
{
    // 获取ajax请求后添加购物车
    public function add()
    {
        $goods_id = I('post.goods_id');
        // dump($goods_id);
        // 实例化购物车Cart类
        $cart = new Cart();
        // dump($cart);die;
        // 获取商品信息goods_id后查询商品表
        $rst = M('Goods') -> find($goods_id);
        // 拼装数据
        $data['goods_id'] = $goods_id;
        $data['goods_name'] = $rst['goods_name'];
        $data['goods_price'] = $rst['goods_price'];
        $data['goods_buy_number'] = 1;
        $data['goods_total_price'] = $rst['goods_price'] * $data['goods_buy_number'];
        // 交给购物车类去添加
        $cart -> add($data);//没有返回值
        // dump($cart);die;
        // 添加成功后显示数量,返回json对象
        echo json_encode($cart->getNumberPrice());
    }
    // 购物车展示页
    public function flow1()
    {
        // 要求读取购物车中的数据
        $cart = new Cart();
        // 调用cart类方法读取
        $data = $cart -> getCartInfo();

        // 获取商品id(1,2,3),implode分割字符串
        $ids = implode(',',array_keys($data));//array_keys获取数组中的键值
        // dump($ids);die;
        // 查询商品缩略图
        $info = M('Goods') -> field('goods_id,goods_small_logo') -> select($ids);
        // dump($info);//die;
        // 合并$data和$info
        foreach ($data as $key => $value) {
            foreach ($info as $k=> $val) {
                  if($value['goods_id']==$val['goods_id'])
                  $data[$key]['goods_small_logo'] = $val['goods_small_logo'];
            }
        }
       // dump($data);
        // 获取总价格
        $price = $cart -> getNumberPrice();
        // dump($price);
        // 传递数据
        $this -> assign('data',$data);
        $this -> assign('price',$price['price']);
        //
        $this -> display();
    }
    // 修改购物车内商品数量的值
    public function change_number()
    {
       // 获取ajax传递的值
        $post = I('post.');
        // dump($post);
        // 此时实例化的cart类里存有数值
        $cart = new Cart();
        // 根据cart类中的修改方法修改购物车内的值
        $price = $cart ->changeNumber($post['amount'],$post['goods_id']);
        // dump($price);
        // 修改完商品数量后总价格也跟着改变
        $total = $cart-> getNumberPrice();
        $totalprice = $total['price'];
        // 将数据进行json编译
        echo json_encode(array('price'=>$price,'toatalprice'=>$totalprice));
    }
    // 删除购物车内的商品
    public function del()
    {
        $goods_id = I('get.goods_id');
        // 例化cart类
        $cart = new Cart();
        // 删除制定购物车内的物品
        $cart ->del($goods_id);
        // 重新更新总价值
        $price = $cart ->getNumberPrice();
        echo $price['price'];
    }
    // flow2展示模板
    public function flow2()
    {
        if (IS_POST) {
            // 接收数据
            $post = I('post.');
            // 处理数据表的数据
            // 订单表
            // 处理数据user_id  order_number  order_price  add_time   upd_time
            // 实例化购物车类
            $cart = new Cart();
            // 获取商品的数量和总价
            $total = $cart -> getNumberPrice();
            $post['user_id'] = session('uid');
            $post['order_number'] = 'agy' . date('YmdHis') . mt_rand(100000,999999);
            $post['order_price'] = $total['price'];
            $post['add_time'] = $post['upd_time'] = time();
            // 接收保存的订单id
            $oid = M('Order') -> add($post);
            // 订单-商品表
            // 处理数据order_id  goods_id	goods_price goods_number  goods_total_price
            // 先从购物车中读取商品信息
            $info = $cart -> getCartInfo();
            foreach ($info as $key => $value) {
                // 补充字段
                $data['order_id'] = $oid;
                $data['goods_id'] = $value['goods_id'];
                $data['goods_price'] = $value['goods_price'];
                $data['goods_number'] = $value['goods_buy_number'];
                $data['goods_total_price'] = $value['goods_total_price'];
                M('OrderGoods') -> add($data);
            }

            // 清空购物车
            $cart -> delall();

            // 订单支付
            echo '订单创建成功...';
            // 定义heml表单和JS代码，提交给浏览器
        } else {
            // 在结算之前先判断是否登录，如果登陆就直接进入folw2页面,
            // 如果没登陆就先登陆，然后跳转回flow2(回调地址)
            // 判断用户是否正常登陆,?uid判断用户是否存在，存在就返回true
            if (!session('?uid')) {
                // 用户没有登录
                $this -> error('请先登录',U('User/login',array('tc' => 'Cart','ta' => 'flow2')),3);
            } else {
                // 要求读取购物车中的数据
                $cart = new Cart();
                // 调用cart类方法读取
                $data = $cart -> getCartInfo();

                // 获取商品id(1,2,3),implode分割字符串
                $ids = implode(',',array_keys($data));//array_keys获取数组中的键值
                // dump($ids);die;
                // 查询商品缩略图
                $info = M('Goods') -> field('goods_id,goods_small_logo') -> select($ids);
                // dump($info);//die;
                // 合并$data和$info
                foreach ($data as $key => $value) {
                    foreach ($info as $k => $val) {
                        if ($value['goods_id'] == $val['goods_id'])
                            $data[$key]['goods_small_logo'] = $val['goods_small_logo'];
                    }
                }
                // dump($data);
                // 获取总价格
                $price = $cart -> getNumberPrice();
                // dump($price);
                // 传递数据
                $this -> assign('data',$data);
                $this -> assign('price',$price);
                $this -> display();
            }
        }
    }
}