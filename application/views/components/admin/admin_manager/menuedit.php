<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script>
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
                    "name": {required:true},
                    "menu_url": {required:true},
                    "controller": {required:true},
                    "order": {required:true},
                    "level": {required:true}
                  },
          messages: {
                    "name": {required:"请填菜单名称"},
                    "menu_url": {required:"请填写链接地址"},
                    "controller": {required:"请填写控制器名称"},
                    "order": {required:"请填写排序号"},
                    "level": {required:"请选择级别"}
                  }
      });
  });
</script>

<form action="/admin_manager/menuedit/<?=$data['id'];?>" enctype="multipart/form-data" method="post" id="sub_form">
  <div class="noticewarp">

    <div class="noticetit">
      <h1>编辑菜单</h1>
    </div>

    <div class="noticenwarp">

      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">菜单名：</div>
        <div class="maddness" style="width:500px;">
          <input name="name" value="<?php echo $data['name'];?>" type="text"/>
          <span class="must_star" >*</span>
        </div>
      </div>
      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">所属上级：</div>
        <select name="f_id" style="padding:6px;">
          <option value="0">顶级菜单</option>
          <?php foreach( $menus as $k => $v ){ ?>
            <option value="<?=$v['id'];?>" <?= $v['id'] == $data['f_id'] ? "selected" : "" ?>><?=$v['tag'].$v['name'];?></option>
          <?php } ?>
        </select>
      </div>
      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">链接地址：</div>
        <div class="addfile" style="width:500px;">
          <input name="menu_url" value="<?php echo $data['menu_url'];?>" type="text"/>
          <span class="must_star" >*</span>
        </div>
      </div>
      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">控制器名：</div>
        <div class="maddness" style="width:500px;">
          <input name="controller" value="<?php echo $data['controller'];?>" type="text"/>
          <span class="must_star" >*</span>
        </div>
      </div>
      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">方法名：</div>
        <div class="maddness" style="width:500px;">
          <input name="action" value="<?php echo $data['action'];?>" type="text"/>
        </div>
      </div>
      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">级别：</div>
        <div class="maddness" style="width:500px;">
          <select name="level">
            <option value="">==请选择==</option>
            <option value="1" <?= $data['level'] == 1 ? "selected" : "" ?>>1</option>
            <option value="2" <?= $data['level'] == 2 ? "selected" : "" ?>>2</option>
            <option value="3" <?= $data['level'] == 3 ? "selected" : "" ?>>3</option>
          </select>
          <span class="must_star" >*</span>
        </div>
      </div>
      <div class="noticekatebox" style="padding-top:5px;">
        <div class="maddpword">序号：</div>
        <div class="maddness" style="width:500px;">
          <input name="order" value="<?php echo $data['order'];?>" type="text"/>
          <span class="must_star" >*</span>
        </div>
      </div>
    <div class="basebutbox">
      <div class="addbutdel"><input type="button" onclick="location.href='/admin_manager/menulist'" class="addbut" value="取消" /></div>
      <div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
    </div>
    </div>

  </div>

  
</form>