<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<SCRIPT src="/resource/js/admin/sexylightbox.v2.3.jquery.js" type='text/javascript'></SCRIPT>
<LINK href="/resource/css/sexylightbox.css" type='text/css' rel='stylesheet'>
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
        title:{
          required : true,
          maxlength:20
        },
         info:{
          required:true,
          maxlength: 50
        }
      },
      messages:{
        title:{
          required : "<div class='tegisnote'>不能为空</div>",
          maxlength: "<div class='tegisnote'>不能超过20个字</div>"
        },
        info:{
          required:"<div class='tegisnote'>关键词不能为空</div>",
          maxlength: "<div class='tegisnote'>不能超过50个字</div>"
        }
      }
    })
  })
  
  $(document).ready(function(){
      SexyLightbox.initialize({color:'white', dir: '/resource/images'});
    });
</script>
<form action="/admin_posts/editUp/<?=$data->id?>" enctype="multipart/form-data" method="post"  id="sub_form">
  <div class="noticewarp">

    <div class="noticetit">
      <h1>编辑帖子状态</h1>
    </div>

    <div class="noticenwarp">

	  <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">状态：</div>
        <div class="maddness">
          <select name="status" style="padding:6px;">
            <?php foreach($POST_STATUS as $key=>$val){ ?>
            <option value="<?=$key?>" <?=$data->status ==$key ? 'selected' :'' ?>><?=$val?></option>
            <?php } ?>
           
          </select>
        </div>
      </div>           
      <div class="basebutbox">
        <div class="addbutdel"><input type="button" onclick="location.href='/admin_posts'" class="addbut" value="取消" /></div>
        <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
      </div>
    </div>

  </div>

  
</form>