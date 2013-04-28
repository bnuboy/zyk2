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
        title:{
          required : true,
          maxlength:20
        },
        post_id:{
          //required : true,
          number:10
        }
      },
      messages:{
        title:{
          required : "<div class='tegisnote'>不能为空</div>",
          maxlength: "<div class='tegisnote'>不能超过20个字</div>"
        },
        post_id:{
         // required : true,
         
          number:"<div class='tegisnote'>只能填写主题的ID</div>"
        }
         
        
      }
    })
  })
</script>
<form action="/admin_postplates/addUp" enctype="multipart/form-data" method="post"  id="sub_form">
  <div class="noticewarp">

    <div class="noticetit">
      <h1>新增板块</h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:10px;">
        <div class="maddpword">标题：</div>
        <div class="maddness" style="width:500px;">
          <input name="title" type="text"/>
          <span class="must_star" >&nbsp;*</span>
        </div>
      </div>   
      
      <div class="noticekatebox" style="padding-top:10px;">
        <div class="maddpword">介绍：</div>
        <div class="maddness" style="width:500px;">
          <input name="info" type="text"/>
          <span class="must_star" >&nbsp;*</span>
        </div>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">序号：</div>
        <div class="maddness">
           <input name="order_no" type="text"/>
        </div>
      </div>

	  <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">最新主题：</div>
        <div class="maddness">
           <input name="post_id" type="text"/>
        </div>
      </div>
      

	   <div class="noticekatebox" style="padding-left: 51px;">
        <div class="addpwordn">置顶：</div>
        <div class="addpnotwn">
          &nbsp;<label><input name="recommend" type="radio" value="1" checked="checked" />&nbsp;&nbsp;是</label>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input name="recommend" type="radio" value="0"/>&nbsp;&nbsp;否</label>
        </div>
      </div>

	  <div class="noticekatebox" style="padding-bottom:10px;">
        <div class="maddpword">主题数量：</div>
        <div class="maddness">
           <input name="subject_count" type="text" />
        </div>
      </div>

      <div class="noticekatebox" style="padding-bottom:10px; ">
        <div class="maddpword">图标：</div>
        <div class="addfile">
          <input id="file_path_input" type="text" />
          <input style="opacity:0;width:315px;position:relative;top:-30px" onchange="$('#file_path_input').val( this.value );" size="34" name="icon" type="file" />
        </div>
        <div class="addfileput"><a href="javascript:;">浏览</a></div>
        <span class="must_star" >&nbsp;*</span>
      </div>

    </div>

  </div>

  <div class="basebutbox">
    <div class="addbutdel"><input type="button" onclick="location.href='/admin_posts'" class="addbut" value="取消" /></div>
    <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
  </div>
</form>