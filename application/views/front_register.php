<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="/resource/css/global.css" rel="stylesheet" />
    <link type="text/css" href="/resource/css/notice.css" rel="stylesheet" />
    <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>

    <title><?=$HTML_BLOCK['title'];?></title>


  </head>
  <script>
    $( "#birthday" ).datepicker({ dateFormat: 'yymmdd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
    $(function(){
      $( "#start_time" ).datepicker({ dateFormat: 'yymmdd',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
    })
  </script>
  <script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function(){
      $('#sub_form').validate({
        //					debug:true,
        errorElement: "span",
        focusCleanup:true,
        Onsubmit:true,
        success: function(label) {
          //label.addClass("success");
        },
        rules:{
          login_name:{
            required : true,
            remote:"/front/checkuser",
            rangelength:[4,16]
          },
          password:{
            required:true,
            rangelength:[6,16]
          },
          name:{
            required : true,
            maxlength:10
          },
          repassword:{
            required:true,
            rangelength:[6,16],
            equalTo:"#password"
          },
          address:{
            required : true,
            maxlength:30
          },
          email:{
            required :true,
            email:true
          },
          student_id:{
            required : true,
            maxlength:20
          },
          birthday:{
            required : true,
            maxlength:8
          },
          mobile:{
            required : true,
            digits:true ,
            maxlength:11,
            minlength:11
          }
        },
        messages:{
          login_name:{
            required : "<div class='tegisnote'>不能为空</div>",
            remote:"<div class='tegisnote'>用户已存在</div>",
            rangelength: "<div class='tegisnote'>用户名须在4-16之间</div>"
          },
          password:{
            required:"<div class='tegisnote'>不能为空</div>",
            rangelength:"<div class='tegisnote'>字符必须在6-16之间</div>"
          },
          name:{
            required : "<div class='tegisnote'>不能为空</div>",
            maxlength: "<div class='tegisnote'>不能超过10个字</div>"
          },
          repassword:{
            required:"<div class='tegisnote'>不能为空</div>",
            rangelength:"<div class='tegisnote'>字符必须在6-16之间</div>",
            equalTo:"<div class='tegisnote'>两次输入的密码不一致</div>"
          },
          address:{
            required : "<div class='tegisnote'>不能为空</div>",
            maxlength: "<div class='tegisnote'>不能超过30个字</div>"
          },
          email:{
            required : "<div class='tegisnote'>不能为空</div>",
            email:"<div class='tegisnote'>请输入正确的邮箱</div>"
          },
          student_id:{
            required : "<div class='tegisnote'>不能为空</div>",
            maxlength: "<div class='tegisnote'>不能超过20个字</div>"
          },
          birthday:{
            required : "<div class='tegisnote'>不能为空</div>",
            maxlength:"<div class='tegisnote'>日期格式不对</div>"
          },
          mobile:{
            required :"<div class='tegisnote'>不能为空</div>",
            digits:"<div class='tegisnote'>输入正确的电话</div>" ,
            maxlength:"<div class='tegisnote'>电话号码最大11位</div>",
            minlength:"<div class='tegisnote'>电话号码最少11位</div>"
          }
        }
      })
    })
  </script>
  <script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
  <link rel="stylesheet" href="/resource/css/jquery-ui.css">
    <form action="/front/user_addup" enctype="multipart/form-data" method="post" id="sub_form">

      <div class="noticewarp" style="margin-left:221px;width:980px;background: none;background-color: white;">

        <div class="noticetit">
          <h1>注册</h1>
        </div>

        <div class="noticenwarp">

          <div class="noticekatebox" style="padding-top:30px;">
            <div class="maddpword">登陆名：</div>
            <div class="maddness"><input name="login_name" type="text"/></div>
            <div ><span class="must_star" >*</span></div>
            <div class="maddpword">登录密码：</div>

            <div class="maddness"><input name="password" type="password" id="password"/></div>
            <div ><span class="must_star" >*</span></div>
          </div>

          <div class="noticekatebox" style="padding-bottom:10px;">
            <div class="maddpword">姓名：</div>

            <div class="maddness"><input name="name" type="text"/></div>
            <div ><span class="must_star" >*</span></div>
            <div class="maddpword">重复密码：</div>

            <div class="maddness"><input name="repassword" type="password"/></div>
            <div ><span class="must_star" >*</span></div>
          </div>

          <div class="noticekatebox" style="padding-bottom:10px;">
            <div class="maddpword">地址：</div>

            <div class="maddness"><input name="address" type="text"/></div>
            <div ><span class="must_star" >*</span></div>
            <div class="maddpword">邮件地址：</div>

            <div class="maddness"><input name="email" type="text"/></div>
            <div ><span class="must_star" >*</span></div>
          </div>
          <div class="noticekatebox" style="padding-bottom:10px;">
            <div class="maddpword">学号：</div>
            <div class="maddness"><input name="student_id" type="text"/></div>
            <div ><span class="must_star" >*</span></div>
            <div class="maddpword">生日：</div>

            <div class="maddness"><input id="start_time" name="birthday" type="text"/></div>
            <div ><span class="must_star" >*</span></div>
          </div>
          <div class="noticekatebox" style="padding-bottom:10px;">
            <div class="maddpword">性别：</div>

            <div class="maddness" style="padding-top:6px">
              <label><input checked style="width:30px;height:12px;" name="gender" value="m" type="radio"/><span style="font-size:14px">男</span></label>
              &nbsp;<label><input style="width:30px;height:12px;" name="gender" value="f" type="radio"/><span style="font-size:14px">女</span></label>
            </div>
            <div class="maddpword">电话：</div>

            <div class="maddness"><input name="mobile" type="text"/></div>
            <div ><span class="must_star" >*</span></div>
          </div>
          <div class="noticekatebox" style="padding-bottom:10px;">
            <div class="maddpword">所属院系：</div>

            <div class="maddness">
              <select style="padding:6px;" name="organization_id" >
                <?php
                foreach ( $organization_list as $organization )
                {
                ?>
                  <option value="<?= $organization->id ?>"><?= $organization->view_name ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="maddpword">个人主页：</div>

            <div class="maddness"><input name="website" type="text"/></div>
          </div>
          <div class="noticekatebox" style="padding-bottom:150px;">
            <div class="maddpword">个人简介：</div>

            <div class="addpease">
              <textarea  name="description"></textarea>
            </div>
          </div>

          <div class="noticekatebox" style="padding-bottom:10px;">
            <div class="maddpword">选择身份：</div>

            <div class="maddness">
              <select style="padding:6px;" name="type" >
                <?php
                foreach ( $USER_TYPE as $key =>$value )
                {
                ?>
                  <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

        </div>
        <div class="basebutbox">
          <div class="addbutdel"><input type="button" onclick="location.href='/admin_user/worker'" class="addbut" value="取消" /></div>
          <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
        </div>
      </div>
    </form>
    <!--中间内容 end-->

    <!--底部 -->
    <div class="footer boxShadow"><?=$HTML_BLOCK['footer'];?></div>
    <!--底部  end-->

    </body>
</html>