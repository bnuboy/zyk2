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
<form action="/admin_postplates/editUp/<?=$list->id?>" enctype="multipart/form-data" method="post"  id="sub_form">
  <div class="noticewarp">

    <div class="noticetit">
      <h1>编辑板块</h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:30px;">
        <div class="maddpword">标题：</div>
        <div class="maddness" style="width:500px;">
          <input name="title" type="text" value='<?=$list->title?>'/>
          <span class="must_star" >&nbsp;*</span>
        </div>
      </div>    

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">序号：</div>
        <div class="maddness">
           <input name="order_no" type="text" value='<?=$list->order_no?>'/>
        </div>
      </div>
    
	   <div class="noticekatebox" style="padding-left: 51px;">
        <div class="addpwordn">是否推荐：</div>
        <div class="addpnotwn">
          &nbsp;<label><input name="recommend" type="radio" value="y" <?=$list->recommend == 'y' ? 'checked':'' ?>/>&nbsp;&nbsp;是</label>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input name="recommend" type="radio" value="n" <?=$list->recommend == 'n' ? 'checked':'' ?>/>&nbsp;&nbsp;否</label>
        </div>
      </div>
     
       <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">图标：</div>
        <div class="addfile">
          <input name="icon" id="icon" type="hidden" value="<?=isset($list->icon) ? $list->icon : ''; ?>"/>
          <iframe style="border:0px;" src="/Uploadfiles/uploadfileform?fileid=icon&defaultvalue=<?php echo empty($list->icon) ? '' : $list->icon;?>&allowed_extensions=gif|jpg|png&overwrite=false&encrypt_name=false" width="400px" height="54px;"></iframe>
        </div>
      </div>
      
      <div class="noticekatebox" style="padding-bottom:150px; padding-top:30px;">
        <div class="maddpword">介绍：</div>
        <div class="addpease">
          <textarea name="info"><?=$list->info?></textarea>    
        </div>
      </div>
     <div class="basebutbox">
        <div class="addbutdel"><input type="button" onclick="location.href='/admin_postplates'" class="addbut" value="取消" /></div>
        <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
      </div>
    </div>

  </div>

 
</form>