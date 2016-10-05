<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/17
 * Time: 10:44
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Image;
use Think\Page;
use Think\Upload;

class GoodsController extends CommonController
{
    // 商品的展示页
    public function showList()
    {
        // 实例化模型
        $model = M('Goods');
        // 查询所有的记录数
        $count = $model -> count();
        // 实例化分页 类
        $page = new Page($count,3);
        $page -> lastSuffix = false;
        $page -> rollPage = 3;
        $page -> setConfig('prev','上一页');
        $page -> setConfig('next','下一页');
        $page -> setConfig('first','首页');
        $page -> setConfig('last','末页');
        // 查询数据
        $data = $model -> limit($page -> firstRow,$page -> listRows) -> select();
        // 传递分页方法
        $show = $page -> show();
        // 传递数据
        $this -> assign('data',$data);
        $this -> assign('show',$show);
        $this -> assign('count',$count);
        $this -> display();
    }
    // 商品的添加页
    public function add()
    {
        if(IS_POST){
            $post = I('post.');
            $post['add_time'] = $post['up_time'] = time();
            // 针对富文本编辑器进行特殊处理
            $post['goods_introduce'] = filterXSS($_POST['goods_introduce']);
            // 处理图片是上传操作
            if ($_FILES['goods_big_logo']['size'] > 0) {
                // 配置保存路径
                $cfg = array(
                    'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
                );
                $upload = new Upload($cfg);
                // 开始上传
                $info = $upload -> uploadOne($_FILES['goods_big_logo']);
                $post['goods_big_logo'] =UPLOAD_ROOT_PATH . $info['savepath'] .$info['savename'];
                // 制作缩略图，分三步
                // 1.打开图片
            $image = new Image();
            $image -> open(WORKING_PATH . $post['goods_big_logo']);
            // 2.制作缩略图
            $image -> thumb(150,150);
            // 3.保存图片
            $image -> save(WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' .$info['savename']);
            // 补上goods_small_logo字段
            $post['goods_small_logo'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
        }
        $model = M('Goods');
        $rst = $model -> add($post);
            // 由于新添加的jquery事件后导致表单的提交值发生改变,
            // 所以新创建个商品属性表来保存这些信息，所以表单提交值要加[]保证提交是数组,
            // 这样表格里值和goodsid字段就有了（表单提交成功后返回商品id），
            // 为了循环遍历将其构造成二维数组，key值就是返回json对象中的属性attr_id
            if ($rst) {
                foreach ($post['goods_attrs'] as $key => $value ) {
                           // $value也是一个数组,继续对其遍历
                    foreach ($value as $val) {
                        $attr['goods_id'] = $rst;
                        $attr['attr_value'] = $val;
                        $attr['attr_id'] = $key;
                        // dump($attr);die;
                        M('Goodsattr') -> add($attr);
                    }
                }
                $this -> success('添加成功',U('showList'),3);
            } else {
                $this -> error('添加失败',U('add'),3);
            }
        } else{
            $data = M('type') ->select();
            $this -> assign('data',$data);
            $this -> display();
        }

    }
    // 构建上传图片及删除图片的方法
    public function photos()
    {
        if(IS_POST){
            // 判断是否有文件需要处理（至少有一个文件成功）
            $flag = false;
            foreach ($_FILES['goods_pic']['error'] as $key => $value) {
                // 如果当前的错误=0,则表示文件上传成功
                if ($value == 0) {
                    $flag = true;
                    break;
                }
            }
            if($flag) {
                // 此处传值应用到了{$Think.get.id}获得页面传递过来的数值
                $id = I('post.goods_id');
                $cfg = array(
                    'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH
                );
                $upload = new Upload($cfg);
                // 多个数组上传
                $info = $upload -> upload($_FILES);
                // 使用addAll方法进行批量添加
                $model = M('Goodspics');
                // 添加数据,这里要对经过上传类处理后的值进行遍历，取出我们需要的值
                foreach ($info as $k => $v) {
                    $data[$k]['goods_id'] = $id;
                    $data[$k]['pic'] = UPLOAD_ROOT_PATH . $v['savepath'] . $v['savename'];
                }
                // dump($data);die;
                $rst = $model -> addAll($data);
                if($rst) {
                    $this -> success('添加成功');
                } else {
                    $this -> error('添加失败');
                }
            }
    
        }else{
            // 将数据库里的相关信息在模板中显示出来
            $model = M('Goodspics');
            $id = I('get.id');
            $data = $model -> where('goods_id=' . $id) -> select();
            $this -> assign('data',$data);
            $this -> display();
        }
    }
    // 构建删除图片的方法
    public function del_pic()
    {
        $id = I('get.id');
        // 实例化父类模型
        $model = M('Goodspics');
        // 要删除前先查询出要删除的数据
        $data = $model -> find($id);
        // 删除记录
        $rst = $model -> delete($id);
        // 删除存储的图片
        if ($rst) {
            unlink(WORKING_PATH . $data['pic']);
            echo 1;
        }
    }
    // 构建更新的方法
    public function edit()
    {
        if (IS_POST) {
            // 接收数据
            $post = I('post.');
            // 指定修改时间
            $post['upd_time'] = time();
            // 写入表
            $model = M('Goods');
            // 针对富文本编辑器防止XSS攻击，调用防止攻击函数，这里不能用I方法因为已经过滤了
            $post['goods_introduce'] = filterXSS($_POST['goods_introduce']);
            // 修改图片,判断是否有图片上传
            $file = $_FILES['goods_big_logo'];
            // 设置照片保存路径
            $cfg = array('rootPath' => WORKING_PATH.UPLOAD_ROOT_PATH);
            // 实例化上传类
            $upload = new Upload($cfg);
            // 对图片信息进行相关处理
            $info = $upload -> uploadOne($file);
        if ($info['size'] > 0){
              // goods_big_logo字段
            $post['goods_big_logo'] = UPLOAD_ROOT_PATH . $info['savepath'] .$info['savename'];
            // 处理缩略图
            // 1,实例化类
            $image = new Image();
            // 发开图片
            $image -> open(WORKING_PATH . $post['goods_big_logo']);
            // 处理缩略图
            $image -> thumb(150,150);
            // 保存图片
            $image -> save(WORKING_PATH . UPLOAD_ROOT_PATH .$info['savepath'] .'thumb_' .$info['savename']);
            // goods_small_logo字段
            $post['goods_small_logo'] = UPLOAD_ROOT_PATH .$info['savepath'] .'thumb_' . $info['savename'];
        }

            // 执行更新操作
            $rst = $model -> save($post);
            dump($rst);
            if($rst) {
                $this -> success('更新成功',U('showList'),3);
            } else {
                $this -> error('更新失败',U('edit',array('id' => $post['id'])),3);
            }
        } else {
            $id = I('get.id');
            // 实例化模型
            $model = M('Goods');
            $data = $model -> find($id);
            $this -> assign('data',$data);
            $this -> display();
        }
    }
    // 获取ajax请求方法
    public function getAttr()
    {
        // 判断是不是ajax请求
        if (IS_AJAX) {
            $id = I('get.type_id');
            //查询属性
            $data = M('Attribute') ->where('type_id ='.$id)->select();
            //转换成json
            echo json_encode($data);
            
        }
    }
    // 逻辑删除
    public function del()
    {
        $id=I('post.goods_id');
        dump($id);
        // 更新is_del字段
        $model = M('Goods');
        $rst = $model -> where('goods_id='.$id) -> setField('is_del',1);
         if ($rst) {
             echo 1;
         }
    }
}