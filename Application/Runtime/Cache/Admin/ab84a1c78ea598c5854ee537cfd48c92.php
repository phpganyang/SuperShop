<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span>基本信息</span></div>
        <form action="<?php echo U('add');?>" method="post">
            <ul class="forminfo">
                <li>
                    <label>管理职位名称</label>
                    <input name="role_name" placeholder="请输入权限名称" type="text" class="dfinput" /></li>
                <li>
                    <table class="tablelist">
                        <thead>
                        <tr>
                            <th>权限分类</th>
                            <th>权限</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($top)): $i = 0; $__LIST__ = $top;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
                                <td>
                                    <input type="checkbox" name="role_auth_ids[]" value="<?php echo ($vol["auth_id"]); ?>">
                                    <?php echo ($vol["auth_name"]); ?>

                                </td>
                                <td>
                                    <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["auth_pid"] == $vol["auth_id"] ): ?><input type="checkbox" name="auth_ids[]" value="<?php echo ($vo["auth_id"]); ?>" >
                                            <?php echo ($vo["auth_name"]); ?>&emsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                <li>
                    <label>控制器名</label>
                    <input name="role_c" placeholder="请输入控制器名称" type="text" class="dfinput" />
                </li>
                <li>
                    <label>方法名称</label>
                    <input name="role_a" placeholder="请输入方法名称" type="text" class="dfinput" />
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
//jQuery代码
$(function(){
    //给btnsubmit绑定点击事件
    $('#btnSubmit').on('click',function(){
        //表单提交
        $('form').submit();
    })
});
</script>
</html>