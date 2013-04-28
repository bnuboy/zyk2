<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="/resource/css/notice.css" rel="stylesheet" />
    <link type="text/css" href="/resource/css/global.css" rel="stylesheet" />
    <link type="text/css" href="/resource/css/notice.css" rel="stylesheet" />
    <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
    <link type="text/css" href="/resource/css/webindex.css" rel="stylesheet" />
    <script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
    <script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
    <link rel="stylesheet" href="/resource/css/jquery-ui.css">
    <title><?=$HTML_BLOCK['title'];?></title>
  </head>
  <script>
    $( "#birthday" ).datepicker({ dateFormat: 'yymmdd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
    $(function(){
      $( "#start_time" ).datepicker({ dateFormat: 'yymmdd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
    })

    $().ready(function() {
        $.validator.setDefaults({
            submitHandler: function(form){
                form.submit();
            }
        });
        $("#sub_form").validate({
            errorPlacement: function(error, element) { //配置错误信息输出
                error.appendTo( element.parent() );
            },
            success: function(label) {
                label.text("正确").addClass("success"); //返回值
            },
            rules: {
            	"data[proName]": {required:true},
                "data[login_name]": {required:true, rangelength:[5,12], remote:"/index/checkreg?type=login_name"},
                "data[password]": {required:true, rangelength:[5,12]},
                "repassword": {required:true, equalTo:"#logpassword" },
                "data[name]": {required:true},
                "data[address]": {required:true},
                "data[email]": {required:true, email:true, remote:"/index/checkreg?type=email"},
                "data[student_id]": {required:true, rangelength:[2,12], remote:"/index/checkreg?type=student_id"},
                //"data[birthday]": {required:true},
                //"data[mobile]": {required:true},
                "data[organization_id]": {required:true},
                "data[type]": {required:true}
            },
            messages: {
                "data[login_name]": {required : "请填登录名",  rangelength:"长度为5-12位", remote:"此登录名已被占用"},
                "data[password]": {required : "请填写登陆密码",  rangelength:"密码长度为5-12位"},
                "repassword": {required:'请填写重复密码', equalTo:'两次密码不一致'},
                "data[name]": {required : "请填写姓名"},
                "data[address]": {required : "请填写地址"},
                "data[email]": {required : "请填写Email", email:"格式错误", remote:"此邮箱已被占用"},
                "data[student_id]": {required : "请填写学号", rangelength:"长度为2-12位", remote:"此学号已被占用"},
                //"data[birthday]": {required : "请填写生日"},
                //"data[mobile]": {required : "请填写电话"},
                "data[organization_id]": {required : "请选择院系"},
                "data[type]": {required : "请选择身份"}
            }
        });
    });
  </script>
 </head> 
<body>
    <!--头部-->
    <div class="p_topbg">
      <div class="counter" style="background:none;">
        <div class="indextoprav"><a title="设为首页" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://zyk.hncc.edu.cn');" href="javascript:;">设为首页</a>&nbsp;|&nbsp;<a href="javascript:window.external.AddFavorite('http://zyk.hncc.edu.cn', '高教资源')">加入收藏</a>&nbsp;|&nbsp;<a href="#" title="网站地图">网站地图</a></div>
      </div>
    </div>
    <!--头部 end-->
<div class="loginbox" style=" background:none;">    

      <div class="noticewarp" style="margin:auto;width:980px;background: none;background-color: white;">

        <div class="noticetit" style="width:100%">
          <h1>请选择身份</h1>
        </div>

        <div class="noticenwarp" style="width:900px;">
        	<a href="/index/register_tea">
	        	<div style="width:200px;height:120px;padding-top:80px;border:1px #ddd solid;text-align:center;float:left;margin:50px 0 20px 50px;font-size:28px;">
	        		教师
	        	</div>
	        </a>
	        <a href="/index/register_stu">
	          	<div style="width:200px;height:120px;padding-top:80px;border:1px #ddd solid;text-align:center;float:left;margin:50px 0 20px 50px;font-size:36px;">
	        		学生
	        	</div>
	        </a>

        </div>
        <div class="basebutbox" style=" width:650px;">
          <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1)" class="addbut" value="回首页" /></div>
        </div>
      </div>
    <!--中间内容 end-->

      <!--底部 -->
      <div class="footer" style="width:100%"><?=$HTML_BLOCK['footer'];?></div>
      <!--底部  end-->
      
    </div>
  </body>
</html>