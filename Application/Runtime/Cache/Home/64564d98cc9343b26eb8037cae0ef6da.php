<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/fillin.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">

	<script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/Public/Home/js/cart2.js"></script>

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
		<div class="flow fr flow2">
			<ul>
				<li>1.我的购物车</li>
				<li class="cur">2.填写核对订单信息</li>
				<li>3.成功提交订单</li>
			</ul>
		</div>
	</div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
	<div class="fillin_hd">
		<h2>填写并核对订单信息</h2>
	</div>
	<form action="" method="post">
		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息</h3>
				<div class="address_select">
					<ul>
						<li class="cur">
							<input type="radio" name="cgn_id" value="555" checked="checked" />王超平 北京市 昌平区 建材城西路金燕龙办公楼一层 13555555555
						</li>
						<li>
							<input type="radio" name="cgn_id" value="333" />王超平 湖北省 武汉市  武昌 关山光谷软件园1号201 13333333333
						</li>
					</ul>
				</div>
			</div>
			<!-- 收货人信息  end-->

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式</h3>
				<div class="pay_select">
					<table>
						<tr class="cur">
							<td class="col1"><input type="radio" value="0" name="order_pay" checked='checked' />支付宝</td>
							<td class="col2">使用支付宝付款</td>
						</tr>
						<tr>
							<td class="col1"><input type="radio" value="1" name="order_pay" />微信</td>
							<td class="col2">使用微信付款</td>
						</tr>
						<tr>
							<td class="col1"><input type="radio" value="2" name="order_pay" />银行卡</td>
							<td class="col2">使用银行卡在线付款</td>
						</tr>
					</table>
				</div>
			</div>
			<!-- 支付方式  end-->

			<!-- 发票信息 start-->
			<div class="receipt">
				<h3>发票信息</h3>
				<div class="receipt_select">
					<ul>
						<li>
							<label for="">发票抬头：</label>
							<input type="radio" name="order_fapiao_title" checked="checked" value="0" class="personal" />个人
							<input type="radio" name="order_fapiao_title" value="1" class="company"/>单位
							<input type="text" class="txt company_input" disabled="disabled" name="order_fapiao_company" />
						</li>
						<li>
							<label for="">发票内容：</label>
							<input type="radio" name="order_fapiao_content" checked="checked" value="明细" />明细
							<input type="radio" name="order_fapiao_content" value="办公用品" />办公用品
							<input type="radio" name="order_fapiao_content" value="体育休闲" />体育休闲
							<input type="radio" name="order_fapiao_content" value="耗材" />耗材
						</li>
					</ul>
				</div>
			</div>
			<!-- 发票信息 end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
					<tr>
						<th class="col1">商品</th>
						<th class="col3">价格</th>
						<th class="col4">数量</th>
						<th class="col5">小计</th>
					</tr>
					</thead>
					<tbody>
					<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
							<td class="col1"><a href=""><img src="<?php echo ($vol["goods_small_logo"]); ?>" alt="" /></a> <strong><a href=""><?php echo ($vol["goods_name"]); ?></a></strong></td>
							<td class="col3">￥<?php echo ($vol["goods_price"]); ?></td>
							<td class="col4"><?php echo ($vol["goods_buy_number"]); ?></td>
							<td class="col5"><span>￥<?php echo ($vol["goods_total_price"]); ?></span></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="5">
							<ul>
								<li>
									<span><?php echo ($price["number"]); ?> 件商品，总商品金额：</span>
									<em>￥<?php echo ($price["price"]); ?></em>
								</li>
								<li>
									<span>应付总额：</span>
									<em>￥<?php echo ($price["price"]); ?></em>
								</li>
							</ul>
						</td>
					</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		</div>
	</form>
	<div class="fillin_ft">
		<a href="javascript:;" id='btnsubmit'><span>提交订单</span></a>
		<p>应付总额：<strong>￥<?php echo ($price["price"]); ?>元</strong></p>

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
<script type="text/javascript">
	$(function(){
		//给提交订单按钮添加点击事件
		$('#btnsubmit').on('click',function(){
			//提交表单
			$('form').submit();
		});
	});
</script>
</html>