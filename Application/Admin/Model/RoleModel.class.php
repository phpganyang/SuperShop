<?php
/**
 * Created by PhpStorm.
 * User: 洋
 * Date: 2016/9/20
 * Time: 9:45
 */
namespace Admin\Model;
use Think\Model;

class RoleModel extends Model
{
    public function saveAuth($data)
    {
      //处理表单提交过来的auth_ids字段
        $post['role_auth_ids'] = implode(',',$data['auth_ids']);
        //处理主键
        $post['role_id'] = $data['role_id'];
        //处理控制器和方法,首先查询这些字段并获得相应的值
        $model = M('Auth');
        $auth = $model -> where("auth_pid > 0 and auth_id in({$post['role_auth_ids']})") -> select();
       //数据要存入role表中，对ac字段进行处理
        $ac = "";
        foreach ($auth as $k => $v) {
                  $ac .= $v['auth_c'] . '-' . $v['auth_a'] . ',';
        }
        //去除最后一个逗号,这里用到函数rtrim
        $post['role_auth_ac'] = rtrim($ac,',');
        //更新提交的数据，因为这是在模型里面，所以这里直接可以用this代替模型
        return $this -> save($post) ;
    }

    public function addAuth($data)
    {
        //处理表单提交过来的auth_ids字段
        $post['role_auth_ids'] = implode(',',$data['auth_ids']);
        //处理主键
        //、$post['role_id'] = $data['role_id'];
        //处理控制器和方法,首先查询这些字段并获得相应的值
        $model = M('Auth');
        $auth = $model -> where("auth_pid > 0 and auth_id in({$post['role_auth_ids']})") -> select();
        //数据要存入role表中，对ac字段进行处理
        $ac = "";
        foreach ($auth as $k => $v) {
            $ac .= $v['auth_c'] . '-' . $v['auth_a'] . ',';
        }
        //去除最后一个逗号,这里用到函数rtrim
        $post['role_auth_ac'] = rtrim($ac,',');
        //更新提交的数据，因为这是在模型里面，所以这里直接可以用this代替模型
        return $post ;
    }
   
}