<script type="text/javascript">
 
      function checklog(){
          var login_name = $("#login_name").val();
          var password   = $("#password").val();
          var code       = $("#code").val();
          if(login_name == ''){
              alert('请填写用户名！');
              $("#login_name").select();
              return false;
          }else if(password == ''){
              alert('请填写密码！');
              $("#password").select();
              return false;
          }else if(code == ''){
              alert('请填写验证码！');
              $("#code").select();
              return false;
          }else{
              $.post('/cms/login', {login_name:login_name, password:password, code:code}, function(data){
                  if(data == 'ok'){
                      location.href = "/ucenter_course/mycourseselect";
                      //alert('登陆成功！');
                      //getloginfo();
                  }else if(data == '1'){
                      alert('验证码错误！');
                      $("#code").val('');
                      $("#code").select();
                  }else if(data == '2'){
                      alert('密码错误！');
                      $("#password").val('');
                      $("#password").select();
                  }else if(data == '3'){
                      alert('请输入用户名或密码！');
                  }else if(data == '4'){
                      alert('用户名错误！');
                      $("#login_name").select();
                  }                  
              });
              return false;
          }
      }
      
      function getloginfo(){
          $.post('/cms/getloginfo', {}, function(data){
              $("#logininbox").css('display','none'); 
			  $("#login").css('display','block'); 
              $('#login').html(data);
          });
      }
      
      <?php 
      if (isset($_SESSION['user']) && !empty($_SESSION['user'])) echo "getloginfo();";
      ?> 
  function change_tab(num,tab_id,t,tab)
  {
    for(var i=1;i<=num;i++)
    {
      if(i==tab_id){
        $("#"+t+i).attr('class','hver');
        $("#"+tab+i).css('display','block');
      }
      else
      {
        $("#"+t+i).attr('class','');
        $("#"+tab+i).css('display','none');
      }
    }
  }
</script>
<script type="text/javascript" src="/resource/js/xmEB_focus.js"></script>
<script type="text/javascript">
  $(function(){
  var xmSlider=new xmfocus.slider();xmSlider.init({gallery:'slides',control:"pagination",dir:false,index:0,speed:20,interval:3000,type:'click'});
  });
</script>
<style>
.pagination {
    bottom: 17px;
    height: 30px;
    position: absolute;
    right: 16px;
    z-index: 9999;
}
.pagination li {
    float: left;
    font-size: 16px;
    line-height: 30px;
    text-align: center;
    width: 30px;
}
.pagination li a {
    background-image: url("about:blank");
    color: #666666;
    display: block;
    font-family: "Arial";
    font-size: 30px;
    font-style: italic;
    width: 30px;
}
.pagination li a:hover {
    text-decoration: none;
}
.pagination li.current a {
    color: #FF9C00;
}
.slides_container img{
  border:0px;
}
.slides_container{
  width:615px;
  border: 1px solid #dadada;
  margin-bottom:10px;
}
.slides_container li {
    float: left;
}
#slides {
    position: relative;
}
#slides ul {
    position: absolute;
}
</style>
<!--头部end-->
<div class="content">
  <div class="Cleft">
    <div class="banner" id="slides">
      <ul class="slides_container">
        <?php foreach($focusmaps as $k => $v){ ?>
        <li><a href="<?=!empty($v['url']) ? $v['url'] : '#this' ;?>" target="_blank"><img src="<?=$v['img'];?>" width="615" height="297" /></a></li>        
        <?php } ?>
      </ul>
      <ul class="pagination" id="pagination">
        <?php foreach($focusmaps as $k => $v){ ?>
        <li><a href="javascript:;"><?=$k+1?></a></li>
       <?php } ?>
      </ul>
    </div>
	
    <!--新闻资讯 begin-->
      <div class="news">
        <div class="news-top">
           <div class="title">新闻资讯</div>
          <!--<a href="/cms_newslist/index/">更多>></a>-->
        </div>
        <?php if(isset($topnew)){ ?>
        <div class="nb-cont">
          <h2>
            <a target="_blank" href="/cms/articledetail/<?=isset($topnew['id']) ? $topnew['id'] : ''; ?>?menuid=<?=isset($topnew['menu_id']) ? $topnew['menu_id'] : ''; ?>">
             <?=isset($topnew['subject']) ? $topnew['subject'] : ''; ?>
           </a>
         </h2>
          <img src="<?=isset($topnew['img']) ? $topnew['img'] : ''; ?>" width="113" height="107" />
          <p><?=isset($topnew['intro']) ? Util::cut_str($topnew['intro'], 120) : ''; ?></p>
          <span><a target="_blank" href="/cms/articledetail/<?=isset($topnew['id']) ? $topnew['id'] : ''; ?>?menuid=<?=isset($topnew['menu_id']) ? $topnew['menu_id'] : ''; ?>">查看详情>></a></span> 
        </div>
        <?php } ?>
        <!--<div class="nb-list">
          <ul>
            <?php foreach($news as $k => $v) {?>
              <li><a target="_blank" href="/cms/articledetail/<?=$v['id'];?>?menuid=<?=$v['menu_id'];?>"> • <?=Util::cut_str($v['subject'], 24)?></a></li>
            <?php }?>
          </ul>
        </div>-->
      </div>
    <!--新闻资讯 end-->
	
    <!--课程展示 begin-->
    <div class="kczs mt10">
      <div class="news-top">
         <div class="title">课程展示</div>
        <a href="/cms/courselist">全部课程>></a>
      </div>
      <div class="news-list">
        <a href="#this" id="t1" class="hver" onmouseover="change_tab(4,1,'t','tab')" >课程简介 </a>
        <a  href="#this" id="t2" onmouseover="change_tab(4,2,'t','tab')"> 学习单元 </a>
        <a href="#this" id="t3" onmouseover="change_tab(4,3,'t','tab')"> 课程资源 </a>
        <a  href="#this"  id="t4" onmouseover="change_tab(4,4,'t','tab')"> 学生成果</a></div>
      <div class="news-cont">

        <div class="fl" id="tab1" >
          <h2><a href="#this"><?=isset($course_new['name'])?$course_new['name']:""?></a></h2>
          <p> <?=isset($course_new['description'])? Util::cut_str($course_new['description'], 148) :""?></p>
          <p align="left"><a href="<?=isset($course_new['id'])? "/study/index/".$course_new['id']:"#this"?>">进入课程&gt;&gt;</a></p>
        </div>

        <div class="fl" id="tab2" style="display: none;">
          <h2><a href="#this"><?=isset($plan_content['title'])?$plan_content['title']:""?></a></h2>
          <p> <?=isset($plan_content['content'])? Util::cut_str($plan_content['content'], 148) :""?></p>
          <p align="right"><a href="<?=isset($course_new['id'])? "/study/index/".$course_new['id']:"#this"?>">进入课程&gt;&gt;</a></p>
        </div>

        <div class="fl" id="tab3" style="display: none;">
          <?php foreach($course_resource as $c){?>
          <p> ·<a href="<?=$status=='y'?$c['file_path']:'#this'?>"><?=$c['name']?></a></p>
          <?php }?>
        </div>

        <div class="fl" id="tab4" style="display: none;">
          <?php foreach($product as $p){?>
          <p> ·<a href="<?=$status=='y'?'/study_plan/product_view/'.$p['id']:'#this'?>"><?=$p['name']?></a></p>
          <?php }?>
        </div>

        <div class="fr"><img height="175" width="260" src="<?=isset($course_new['img'])?$course_new['img']:""?>"></div>
      </div>
    </div>
    <!--课程展示 end-->
  </div>
  <div class="Cright">
<div id="login" style='display:none'></div>
    <!--用户登录 begin-->
    <div class="loginwbg" id="logininbox">
      <form name="login_form" method="post" action="#this" onsubmit="return checklog();">
        <!--<div class="login-cont">
          <dl>
            <dt>用户名</dt>
            <dd><input id="login_name" name="login_name" type="text" /></dd>
          </dl>
          <dl>
            <dt>密码</dt>
            <dd><input id="password" name="password" type="password" class="text" /></dd>
          </dl>
          <dl>
            <dt>验证码</dt>
            <dd>
                <input id="code" name="code" type="text" class="sub-text" maxlength="5" />
                <img id="imgcode" src="/common/getVerificationCode" />
                <a onclick="$('#imgcode').attr('src', '/common/getVerificationCode/'+Math.random())" href="#this">
                  换一张
                </a>
            </dd>
          </dl>
          
          <div style="padding-left:45px">
            <input name="" type="submit" value="" class="login-btn" />
            <a href="/index/forgetpass" title="忘记密码？" target="_blank">找回密码</a>
          </div>
        </div>-->
        <div class="logininbox">
        <div class="inputbox"><input id="login_name" name="login_name" type="text" class="loginin" /></div>
              <div class="inputbox"><input id="password" name="password" type="password" class="loginin" /></div>
              <div class="inputbox">
                <div class="loginyz"><input id="code" name="code" type="text" class="yzin" maxlength="5" /></div>
                <img id="imgcode" src="/common/getVerificationCode" />
                <a onclick="$('#imgcode').attr('src', '/common/getVerificationCode/'+Math.random())" href="#this">
                  换一张
                </a>
              </div>
              <div class="loingbutbox">
                <div style="float:left" class="loginbut"><input type="submit" name="send" class="wcoror" value="登录"/></div>
                <div style="float:left" class="loginbut"><input type="button" name="send" class="wcoror" value="注册" onclick="location.href='/index/register'" /></div>
                <div style="float:right; width:70px;" class="loginpsw"><a href="/index/forgetpass" title="忘记密码？"  style='color:#11538c;font-family:"微软雅黑"'>忘记密码？</a></div>
             </div>
         </div>
      </form>      
    </div>
    <!--用户登录 end-->
    <!--专业介绍 begin-->
    <div style="clear:both"></div>
    <div class="zy rboder mt10">
      <div class="title">学院介绍</div>
      <div class="zy-cont">
        <img src="<?=$this->cmsorg['img']?>" width='100px' height = '100px' />
        <?=$this->cmsorg['description'];?> </div>
    </div>
    <!--专业介绍 end-->
    <!--资源更新 begin-->
    <div class="update rboder mt10">
      <div class="title">资源更新</div>
      <div class="resomore"><a href="/cms/courselist">更多>></a></div>
      <div style="clear:both"></div>
      <div class="ulimg">
       <ul>
        <?php foreach($resourcs as $k => $v) {?>
          <li><a href="/cms/resourcedetail/<?=$v['id'];?>"><img src="<?=$v['img'];?>" width="80" height="71" border="0"/></a>
            <h3><a href="/cms/resourcedetail/<?=$v['id'];?>"><?=Util::cut_str($v['name'], 12)?></a></h3>
            <p><?=Util::cut_str($v['description'], 40)?></p>
          </li>
        <?php } ?>
      </ul>
      </div>
    </div>
    <!--资源更新 end-->
  </div>
</div>