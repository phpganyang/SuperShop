<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".click").click(function() {
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function() {
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function() {
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function() {
            $(".tip").fadeOut(100);
        });

    });
        function del(goods_id) {
            var _this = $('#del_'+goods_id);
            console.log(_this);
          $.ajax({
              url:"<?php echo U('del');?>",
              dataType:'html',
              type:'post',
              data:{goods_id:goods_id},
              success:function (data) {
                  console.log(data)
                  if(data==1)
                  {
                      _this.parent().parent().remove();
                  }
              }
          })
        }
    </script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据表</a></li>
            <li><a href="#">基本内容</a></li>
        </ul>
    </div>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
               <a href="<?php echo U('add');?>"> <li><span><img src="/Public/Admin/images/t01.png" /></span>添加</li></a>
                <li><span><img src="/Public/Admin/images/t02.png" /></span>修改</li>
                <li><span><img src="/Public/Admin/images/t03.png" /></span>删除</li>
                <li><span><img src="/Public/Admin/images/t04.png" /></span>统计</li>
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>id</th>
                    <th>商品名称</th>
                    <th>商品价格</th>
                    <th>商品库存</th>
                    <th>商品重量</th>
                    <th>商品缩略图</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td>
                        <input name="" type="checkbox" value="<?php echo ($vo["goods_id"]); ?>" />
                    </td>
                    <td><?php echo ($vo["goods_id"]); ?></td>
                    <td><?php echo ($vo["goods_name"]); ?></td>
                    <td><?php echo ($vo["goods_price"]); ?></td>
                    <td><?php echo ($vo["goods_number"]); ?></td>
                    <td><?php echo ($vo["goods_weight"]); ?></td>
                    <td><img src="<?php echo ($vo["goods_small_logo"]); ?>"></td>
                    <td><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></td>
                    <td>
                        <a href="/index.php/Admin/Goods/photos/id/<?php echo ($vo["goods_id"]); ?>" class="tablelink">相册</a>
                        <a href="#" class="tablelink">查看</a> <a href="javascript:;" class="tablelink" id="del_<?php echo ($vo["goods_id"]); ?>" onclick="del(<?php echo ($vo["goods_id"]); ?>)"> 删除</a>
                    <a href="/index.php/Admin/Goods/edit/id/<?php echo ($vo["goods_id"]); ?>" class="tablelink">更新</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagin">
            <div class="message">共<i class="blue"><?php echo ($count); ?></i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
            <div class="paginList">
                <?php echo ($show); ?>
            </div>
        </div>
        <div class="tip">
            <div class="tiptop"><span>提示信息</span>
                <a></a>
            </div>
            <div class="tipinfo">
                <span><img src="/Public/Admin/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>
            <div class="tipbtn">
                <input name="" type="button" class="sure" value="确定" />&nbsp;
                <input name="" type="button" class="cancel" value="取消" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</body>

</html>