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
    <form action="/index/register" enctype="multipart/form-data" method="post" id="sub_form">

      <div class="noticewarp" style="margin:auto;width:980px;background: none;background-color: white;">

        <div class="noticetit" style="width:100%">
          <h1>注册</h1>
        </div>

        <div class="noticenwarp" style="width:900px;">
        
          <div class="noticekatebox" style="padding-top:30px;width:900px;">
            <div class="maddpword">项目名称：</div>
            <div class="maddness" style="width:305px;"><input name="data[proName]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">等级：</div>
            <div class="maddness" style="width:330px;"><input name="data[rank]" type="password" id="logpassword"/><span class="must_star" >*</span></div>
          </div>

          <div class="noticekatebox" style="padding-top:30px;width:900px;">
            <div class="maddpword">登录名：</div>
            <div class="maddness" style="width:305px;"><input name="data[login_name]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">登录密码：</div>
            <div class="maddness" style="width:330px;"><input name="data[password]" type="password" id="logpassword"/><span class="must_star" >*</span></div>
          </div>

          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">姓名：</div>
            <div class="maddness" style="width:305px;"><input name="data[name]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">重复密码：</div>
            <div class="maddness" style="width:315px;"><input name="repassword" type="password"/><span class="must_star" >*</span></div>
          </div>
          
          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">所在学校：</div>
            <div class="maddness" style="width:305px;"><input name="data[school]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">所在年级：</div>
            <div class="maddness" style=" width:305px;"><input name="data[grade]" type="text"/><span class="must_star" >*</span></div>
          </div>

          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">学校地址：</div>
            <div class="maddness" style="width:305px;"><input name="data[address]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">邮件地址：</div>
            <div class="maddness" style=" width:305px;"><input name="data[email]" type="text"/><span class="must_star" >*</span></div>
          </div>
          
          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">学号：</div>
            <div class="maddness" style="width:305px;"><input name="data[student_id]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">生日：</div>
            <div class="maddness" style="width:305px;"><input id="start_time" name="data[birthday]" type="text" readonly=“true"/></div>
          </div>
          
          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">民族：</div>
            <div class="maddness" style="width:305px;"><input name="data[peoples]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">身份证号：</div>
            <div class="maddness" style="width:305px;"><input id="start_time" name="data[lID]" type="text" readonly=“true"/></div>
          </div>
          
          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">选手文化：</div>
            <div class="maddness" style="width:305px;"><input name="data[education]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">是否应届毕业：</div>
            <div class="maddness" style="width:305px;"><input id="start_time" name="data[isThisYear]" type="text" readonly=“true"/></div>
          </div>
          
          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">性别：</div>
            <div class="maddness" style="padding-top:6px; width:305px;">
              <label><input checked style="width:30px;height:12px;" name="data[gender]" value="m" type="radio"/><span style="font-size:14px">男</span></label>
              &nbsp;<label><input style="width:30px;height:12px;" name="data[gender]" value="f" type="radio"/><span style="font-size:14px">女</span></label>
            </div>
            <div class="maddpword">电话：</div>
            <div class="maddness" style=" width:207px;width:305px;"><input name="data[mobile]" type="text"/></div>
          </div>
          
          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">所属院系：</div>
            <div class="maddness" style=" width:305px;">
              <select style="padding:6px;width:200px;" name="data[organization_id]" >
                <option value="">==请选择==</option>
                <?php foreach ( $organizations as $organization ) { ?>
                  <option value="<?= $organization['id']; ?>"><?= $organization['name']; ?></option>
                <?php } ?>
              </select><span class="must_star" >*</span>
            </div>
            <div class="maddpword">个人主页：</div>
            <div class="maddness" style=" width:305px;"><input name="data[website]" type="text"/></div>
          </div>
          
          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">已获职业资格名称：</div>
            <div class="maddness" style="width:305px;"><input name="data[qualificationName]" type="text"/><span class="must_star" >*</span></div>
            <div class="maddpword">职业资格等级：</div>
            <div class="maddness" style="width:305px;"><input id="start_time" name="data[qualificationRank]" type="text" readonly=“true"/></div>
          </div>
          
          <div class="noticekatebox" style="width:900px;">
            <div class="maddpword">头像：</div>
            <div class="addpease" style="width:500px;height:58px;">
              <input name="data[face]" id="face" type="hidden" value="<?=isset($user['face']) ? $user['face'] : ''; ?>"/>
              <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=face&defaultvalue=<?php echo empty($user['face']) ? '' : $user['face']?>&allowed_extensions=gif|jpg|png&overwrite=false&encrypt_name=false&uppath=/upload/users/face/" width="400px" height="54px;"></iframe>
            </div>
          </div>



          <div class="noticekatebox" style="padding-bottom:150px;width:900px;">
            <div class="maddpword">个人简介：</div>
            <div class="addpease">
              <textarea  name="data[description]"></textarea>
            </div>
          </div>

          <div class="noticekatebox" style="padding-bottom:10px;width:900px;">
            <div class="maddpword">选择身份：</div>
            <div class="maddness" style="width:305px;">
              <select style="padding:6px;" name="data[type]" >
                  <option value="">==请选择==</option>
                <?php foreach ( $USER_TYPE as $key => $value ) { ?>
                  <option value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
              </select><span class="must_star" >*</span>
            </div>
          </div>

        </div>
        <div class="basebutbox" style=" width:650px;">
          <div class="addbutdel"><input type="button" onclick="javascript:history.go(-1)" class="addbut" value="取消" /></div>
          <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
        </div>
      </div>
    </form>
    <!--中间内容 end-->

      <!--底部 -->
      <div class="footer" style="width:100%"><?=$HTML_BLOCK['footer'];?></div>
      <!--底部  end-->
      
    </div>
  </body>
</html>