<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>购物车页面</title>
	<link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/cart.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">

	<script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
<script>
	//对+，-号标记为click事件,number为change,他们都 绑定同一个方法，传了两个参数，goods_id是为了区别不同的商品
      function change_number(flag,goods_id) {
		  //alert(goods_id);
		  //获取input的value值
		  var value = $('#goods_num_'+goods_id).val();
		  //alert(value);
		  if (flag == 'reduce') {
			  if (value == 1) {
				  alert('最少有一件商品');return false;
			  }
			  value--;

		  } else if(flag =='add') {
			  value++;
		  } else if(flag=='amount') {
			  //添加合法性判断


		  } else {
               alert('非法参数');return false;
		  }
	  //这里面要想改变value主要是改变其goods_number值,发送ajax值进change方法查询
		  $.ajax({
			  url:"<?php echo U('Cart/change_number');?>",
			  dataType:'json',
			  type:'post',
			  data:{goods_id:goods_id,amount:value},
			  success:function (data) {
				  console.log(data);
				  //根据id改变不同的value值
				  $('#goods_num_'+goods_id).val(value);
				  $('#price_'+goods_id).html(data.price);
				  $('#total').html(data.toatalprice)
			  }
		  })
	  }
	function rem(goods_id) {
		//因为这是一个JS事件，在ajax中this值不一样
		var _this = $('#del_'+goods_id);
		//发送ajax请求，
		$.ajax({
			url:'/index.php/Home/Cart/del/goods_id/'+goods_id,
			type:'get',
			dataType:'html',
			success:function (data) {
				console.log(data);
				//删除操作
				_this.parent().parent().remove();
				$('#total').html(data)
			}
		})
	}
</script>
	
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w990 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr">
				<ul>
					<li class="cur">1.我的购物车</li>
					<li>2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="mycart w990 mt10 bc">
		<h2><span>我的购物车</span></h2>
		<table>
			<thead>
				<tr>
					<th class="col1">商品名称</th>
					<th class="col3">单价</th>
					<th class="col4">数量</th>	
					<th class="col5">小计</th>
					<th class="col6">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td class="col1"><a href=""><img src="<?php echo ($vo["goods_small_logo"]); ?>" alt="" /></a>  <strong><a href="">【1111购物狂欢节】<?php echo ($vo["goods_name"]); ?></a></strong></td>
					<td class="col3">￥<span><?php echo ($vo["goods_price"]); ?></span></td>
					<td class="col4"> 
						<a href="javascript:;" class="reduce_num" onclick="change_number('reduce',<?php echo ($vo["goods_id"]); ?>)"></a>
						<input type="text" name="amount" value="<?php echo ($vo["goods_buy_number"]); ?>" class="amount" onchange="change_number('amount',<?php echo ($vo["goods_id"]); ?>)" id="goods_num_<?php echo ($vo["goods_id"]); ?>" />
						<a href="javascript:;" class="add_num" onclick="change_number('add',<?php echo ($vo["goods_id"]); ?>)" ></a>
					</td>
					<td class="col5">￥<span id="price_<?php echo ($vo["goods_id"]); ?>"><?php echo ($vo["goods_total_price"]); ?></span></td>
					<td class="col6"><a href="javascript:;" id="del_<?php echo ($vo["goods_id"]); ?>" onclick="rem(<?php echo ($vo["goods_id"]); ?>)">删除</a></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">购物金额总计： <strong>￥ <span id="total"><?php echo ($price); ?>.00</span></strong></td>
				</tr>
			</tfoot>
		</table>
		<div class="cart_btn w990 bc mt10">
			<a href="" class="continue">继续购物</a>
			<a href="<?php echo U('flow2');?>" class="checkout">结 算</a>
		</div>
	</div>
	<!-- 主体部分 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/Public/Home/images/xin.png" alt="" /></a>
			<a href=""><img src="/Public/Home/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/police.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
</body>
</html>