<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<script>
    $(function(){
        $( "#start_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
        $( "#end_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00',yearRange:'c-50:c+10', changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'] });
    })
</script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script>
   $().ready(function() {
      $.validator.setDefaults({
          submitHandler: function(form){
              form.submit();
          }
      });
      $("#updateconfig").validate({
          errorPlacement: function(error, element) { //配置错误信息输出
              error.appendTo( element.parent() );
          },
          success: function(label) {
              label.text("正确").addClass("success"); //返回值
          },
          rules: {
                    "data[title]": {required:true,maxlength:50},
                    "data[starttime]": {required:true},
                    "data[endtime]": {required:true}
                  },
          messages: {
                    "data[title]": {required:"标题不能为空",maxlength:"不能超过40个字"},
                    "data[starttime]": {required:"请填写开始时间"},
                    "data[endtime]":{required:"请填写结束时间"}
                  }
      });
  });
</script>

<div class="noticesbox kecheng">
    <div class="noticewarp">
        <div class="noticenwarp">
            <form method="post" id="updateconfig" name="updateconfig" action="">
                
                <input type="hidden" id="id" name="data[id]" value="<?= empty( $info[ 'id' ] ) ? '' : $info[ 'id' ] ?>" />
                <div class="noticetit tearch-nav">
                    <h2>课程计划 > 目录<?php echo!empty( $info[ 'id' ] ) ? "编辑" : "新增"; ?></h2>
                    <div><a href="#this" class="blue" onclick="javascript:history.go(-1)">&lt;&lt;返回</a></div>
                </div>
                
                <div class="noticekatebox">
                    <div class="addpword">标题：</div>
                    <div class="addptit">
                        <input name="data[title]" type="text" value="<?= empty( $info[ 'title' ] ) ? '' : $info[ 'title' ] ?>" onKeyUp="javasctript:checkLen(this)"/>
                    </div>
                    <div class="addpnotw">剩余<span id="td">50</span>/50</div>
                </div>

                <div class="noticekatebox">
                    <div class="addpwordn">时间：</div>
                    <div class="addfile">
                        <input name="data[starttime]" id="start_time" type="text" value="<?= empty( $info[ 'starttime' ] ) ? '' : $info[ 'starttime' ] ?>"/>
                    </div>
                    <div class="addpnotwn"> 到 </div>
                    <div class="addfile">
                        <input name="data[endtime]" id="end_time" type="text" value="<?= empty( $info[ 'endtime' ] ) ? '' : $info[ 'endtime' ] ?>"/>
                    </div>
                </div>


                <div class="noticekatebox">
                    <div class="addpwordn">查看权限：</div>
                    <div style="float:left; line-height:30px;">
                        <input type="radio" name="data[power]" id="radio" value="1" <?= empty( $info[ 'power' ] )?"checked='checked'":"" ?><?php if ( !empty( $info[ 'power' ] ) && $info[ 'power' ] == 1 )
    echo 'checked'; ?>/>
                        所有用户可见
                        <input type="radio" name="data[power]" id="radio" value="2" <?php if ( !empty( $info[ 'power' ] ) && $info[ 'power' ] == 2 )
                                   echo 'checked'; ?>/>
                        课程教师可见 </div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel">
                        <input type="button" name="reset" onclick="location.href='/study_plan'" class="addbut" value="取消" />
                    </div>
                    <div class="addbutin">
                        <input type="submit" name="send" class="addbut" value="保存" />
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
    //限制文本域字数()
    function checkLen(obj){
        var maxChars = 50;//最多字符数
        if (obj.value.length > maxChars)
            obj.value = obj.value.substring(0,maxChars);
        var curr = maxChars - obj.value.length;
        document.getElementById("td").innerHTML = curr.toString();
    }
 
</script>