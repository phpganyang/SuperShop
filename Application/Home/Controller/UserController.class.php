<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/17
 * Time: 9:47
 */
namespace Home\Controller;
use Think\Controller;
use Think\Verify;

class UserController extends Controller
{
    // 构造方法
    public function _initialize(){
        // 防止用户登陆后还可以 访问登陆和注册
        $action = strtolower(ACTION_NAME);
        if(session('uid')){
            if($action == 'register' || $action =='login'){
                $this -> redirect('Index/index');
            }
        }
    }
    // 构造验证码
    // 实例化验证码类
    public function verify()
    {
        // 设置验证码参数
        $cfg = array(
            'useImgBg'  =>  false,           // 使用背景图片
            'fontSize'  =>  14,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  true,            // 是否添加杂点
            'imageH'    =>  34,               // 验证码图片高度
            'imageW'    =>  106,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
        );
        $verify = new Verify($cfg);
        // 生成图片
        $verify ->entry();
    }

    public function login()
    {
        if (IS_POST) {
            // 接受数据
            $post = I('post.');
            $verify = new Verify();
            //  验证验证码
            if ($post['checkcode'] !=$verify ->check($post['checkcode'])) {
                $this -> error('验证码有误'); exit();
            }
            // 处理密码
            $post['user_pwd'] = getPwd($post['user_pwd']);
            $info = M('User') -> where($post) -> find();
            // 判断是否成功
            if ($info) {
                 session('uid',$info['user_id']);
                 session('uname',$info['user_name']);
                // 判断是否是购物车来源
                if ($_GET['tc'] && $_GET['ta']) {
                    $this -> success('登陆成功',U("{$_GET['tc']}/{$_GET['ta']}"),3);
                } else {
                    $this -> success('登陆成功',U('Index/index'),3);
                }

            } else {
                $this -> error('用户名或密码错误');
            }
        } else {
            $this -> display();
        }

    }
    //  登录验证
    public function register()
    {
        if (IS_POST){
            $post = I('post.');
            // dump($post);die;
            // 实例化
            $verify = new Verify();
            // 验证验证码
            if ($post['checkcode'] !=$verify -> check($post['checkcode'])) {
                $this -> error('验证码有误'); exit();
            }
            $model = M('User');
            // 验证两次密码是否一致
            if ($post['user_pwd'] != $post['user_pwd1']) {
                $this -> error('两次密码不一致');
            }
            $data = $model -> where(array('user_name' => $post['user_name'])) -> find();
            if ($data) {
                $this -> error('用户名已存在');exit();
            }
            // 补全字段
            $post['add_time'] = time();
            $post['user_pwd'] = getPwd($post['user_pwd']);
            // 写入到数据表中
            $rst = $model -> add($post);
            if ($rst) {
                $this -> success('注册成功',U('login'),3);
            } else {
                $this -> error('注册失败');
            }
        } else {
            $this -> display();
        }
    }
    // 退出登陆
    public function loginout()
    {
        // 清除所有session值
        session(null);
        if (!session('?uid')) {
            $this -> success('退出成功',U('Index/index'),3);
        }
    }
}