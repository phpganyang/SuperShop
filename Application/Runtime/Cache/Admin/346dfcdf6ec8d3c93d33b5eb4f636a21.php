<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/plugins/ue/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/plugins/ue/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/Public/plugins/ue/lang/zh-cn/zh-cn.js"></script>
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
        <form action="<?php echo U('add');?>" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>商品名称</label>
                    <input name="goods_name" placeholder="请输入商品名称" type="text" class="dfinput" /><i>名称不能超过30个字符</i></li>
                <li>
                    <label>商品价格</label>
                    <input name="goods_price" placeholder="请输入商品价格" type="text" class="dfinput" /><i></i></li>
                <li>
                    <label>商品数量</label>
                    <input name="goods_number" placeholder="请输入商品数量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品重量</label>
                    <input name="goods_weight" placeholder="请输入商品重量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品图片</label>
                    <input name="goods_big_logo"  type="file"  />
                </li>
                <li>
                    <label>商品类型</label>
                    <select name="type_id" class="dfinput">
                        <option value="0">--请选择--</option>
                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["type_id"]); ?>"><?php echo ($vo["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <i></i>
                </li>
                <!--
                <li><label>是否审核</label><cite><input name="" type="radio" value="" checked="checked" />是&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="radio" value="" />否</cite></li>
                -->
                <li>
                    <label>商品描述 <textarea id="ue" name="goods_introduce" placeholder="请输入商品描述" cols="" rows="" style="width:600px;height:400px;"></textarea></label>

                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script>
    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('ue',{toolbars: [[
        'fullscreen', 'source', '|', 'undo', 'redo', '|',
        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
        'directionalityltr', 'directionalityrtl', 'indent', '|',
        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
        'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
        'simpleupload', 'insertimage', 'emotion'
    ]]});

    $(function(){
       //给btn绑定点击事件
       $('#btnSubmit').on('click',function () {
           $('form').submit();
       })
        //给商品类型添加一个切换事件或者换成id
        $('select[name=type_id]').on('change',function () {
            //获取值
            var id =$(this).val();
            var _this = $(this);
            //alert(id);
            //发送ajax请求，y用get请求，注意返回的格式是json
            $.get('/index.php/Admin/Goods/getAttr/type_id/'+id ,function (data) {
                //console.log(data)
                //处理返回的data值,对其对象进行遍历
                $.each(data,function (index,el) {
                    //console.log(el);
                    //定义字符串,为了后面的拼接
                    var str = "<li><label>";
                    //判断类型，根据Attr表里的attr_sel字段来判断是使用input还是select
                    if(el.attr_sel == 0){
                       //input类型
                        str += el.attr_name + "</label><input name='goods_attrs["+el.attr_id+"][]' placeholder='请输入商品的" + el.attr_name + "' type='text' class='dfinput' /></li>";
                    } else{
                        //select类型
                         str += "<a href='javascript:;' class='add'>[+]</a>" + el.attr_name + "</label><select name='goods_attrs["+el.attr_id+"][]' class='dfinput' ><option value='0'>--请选择--</option>";
                    //处理选项
                    var vals = el.attr_vals.split(',');
                     //对vals进行循环
                        for(var i = 0;i < vals.length;i++){
                       str += "<option value='" + vals[i] + "'>" + vals[i] + "</option>"; 
                    } 
                    str += "</select><i></i></li>";
                    console.log(str);
                    //console.log(vals);
                }
                    _this.parent().after(str);
                });
            },'json');             
        });
         //给+绑定点击事件,因为此事件现在没有,固用live 
         $('.add').live('click',function(){
            //事件处理程序
            //获取li对象信息,将add的dom对象克隆给li
            var li = $(this).parent().parent().clone();
            //去除a标签
            li.find('a').remove();
            //在label后面内部前面加一个a标签
            li.find('label').prepend("<a href='javascript:;' class='del'>【-】</a>")
            //console.log(li);
            //追加新的li元素
            $(this).parent().parent().after(li);
         });
         //给未来事件添加删除方法
        $('.del').live('click',function(){
            $(this).parent().parent().remove();
        })
    })
</script>
</html>