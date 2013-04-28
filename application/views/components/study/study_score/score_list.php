<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:502, innerHeight:440});
        $(".callbacks").colorbox({
            onOpen:function(){ alert('onOpen: colorbox is about to open'); },
            onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
            onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
            onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
            onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });
        $("#click").click(function(){ 
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });   
    $(document).ready(function(){
	
        $("#resousdata>tr:odd,#ediaresousdata>tr:odd").addClass('layodd');
        $("#resousdata>tr:even,#ediaresousdata>tr:even").addClass('layeven');
    });
</script>

<script type="text/javascript">
    
    function select_all1()
    {
      
        if( $("#select_all:checked").length == 0 ){
            $("#class input[type=checkbox]").attr("checked",false);
           
        }else{
            $("#class input[type=checkbox]").attr("checked","checked");
        }
    }
    
    function select_type1()
    {
        if( $("#select_type:checked").length == 0 ){
            $("#type input[type=checkbox]").attr("checked",false);
        }else{
            $("#type input[type=checkbox]").attr("checked","checked");
        }
    }
    
    function select_test1()
    {
        if( $("#select_test:checked").length == 0 ){
            $("#score input[type=checkbox]").attr("checked",false);
             $("#tiliang").attr("checked","checked");
        }else{
            $("#score input[type=checkbox]").attr("checked","checked");
        }
    }
  
    //选择班级
  
    function get_class(spans)
    {
        $('#class lable').remove();
        $.each(spans,function(key,obj){
            $('#class').append("<lable><input type='checkbox' name='class[]' value='"+obj.id+"' checked/>"+obj.name+'</lable>');   
        });  
        
        get_ids();
     
    }
    var current_ids='';
    function get_ids()
    {
        var current_ids='';
        $('#class lable input[type=checkbox]').each(function(key,obj){
            current_ids +=$(this).val()+',';
        })
   
        current_ids=current_ids.substring(0,current_ids.length-1);
        if(current_ids){
            $('#select_button').hide();
            $('#a2').show();
            $('#a2').attr('href','/study_score/get_class?ids='+current_ids);
        }else{
             $('#select_button').show();
            $('#a2').hide();
           
        }
    }
   //获取作业
   function get_zuoye(spans)
    {
        $('#work lable').remove();
        $.each(spans,function(key,obj){
            var att = new Object();
            $('#work').append("<lable style='display:none;'><input type='checkbox' name='zuoye[]' value='"+obj.id+"' checked/>"+obj.name+'</lable>');   

    }); 
        $('#zy_num').find('span').text($('#work lable').length);
        get_select_zuoye();
    }
    
    function get_select_zuoye()
    {
         var current_ids='';
         var attr = new Array();
        $('#work input[type=checkbox]').each(function(key,obj){         
            current_ids +=$(this).val()+',';
            attr.push(obj.value);
        })
     
        current_ids=current_ids.substring(0,current_ids.length-1);
           var dx = new Object();
           dx['id'] = attr;
        $.post('/study_score/get_select_zy',dx,function(ret){
            if(ret.status=='ok')
                {   
                    $.each(ret.data,function(key,obj){
                        $('#type').append("<dt style='display:none;'><input type='text' name='qz["+obj.id+"]' size='2'> %"+obj.title+"</dt>");
                    })
                }
        },'json');
         if(current_ids){          
            $('#xiugai').attr('href','/study_score/get_zuoye?ids='+current_ids);          
             $('#xiugai').show();
             $('#qingkong').show();
             $('#xuanze').hide();
        }else{
            $('#xiugai').hide();
            $('#qingkong').hide();
            $('#xuanze').show();
        }
    }
   
   //清空
   function remove_attr()
   {
       $('#work').empty();
       $('#zy_num').find('span').text(0);
       $('#xiugai').removeClass('class');
       $('#xiugai').attr('href','#');
       $('#xiugai').hide();
       $('#qingkong').hide();
       $('#xuanze').show();
   }
   
   //获取作品
   function get_zuopin(spans)
    {
        $('#zuopin lable').remove();
        $.each(spans,function(key,obj){
            $('#zuopin').append("<lable style='display:none;'><input type='checkbox' name='zuopin[]' value='"+obj.id+"' checked/>"+obj.name+'</lable>');   
        });      
        get_select_zuopin();
    }
    
    function get_select_zuopin()
    {
         var current_ids='';
        $('#zuopin input[type=checkbox]').each(function(key,obj){
            current_ids +=$(this).val()+',';
        })
        current_ids=current_ids.substring(0,current_ids.length-1);
         if(current_ids){          
            $('#zp_bj').attr('href','/study_score/get_zuoye?ids='+current_ids);          
             $('#zp_qk').show();
             $('#zp_bj').show();
             $('#zp_select').hide();
        }else{
            $('#zp_qk').hide();
            $('#zp_bj').hide();
            $('#zp_select').show();
        }
    }
    
   function zuopin_qk()
   {
       $('#zuopin').empty();    
       $('#zp_bj').removeClass('class');
       $('#zp_bj').attr('href','#');
       $('#zp_bj').hide();
       $('#zp_qk').hide();
       $('#zp_select').show();
   }
     
   
   function bj_user(obj)
   { 
       var user="";
        $('#select_button').attr('href','');
      if($('#bj input[type=checkbox]:checked').length > 0)
          {
            $('#select_button').show();
            $.each($('#bj input[type=checkbox]:checked'),function(key,obj){
               user +=obj.value+',';               
            }) ;  
          }else{
              $('#select_button').hide();
          }
          user = user.substr(0,user.length-1);
          $('#select_button').attr('href','/study_score/get_class?user_id='+user);   
   }
   
   function kai()
   {
       if($('#jiaquan:checked').attr("checked"))
       {
           $('#type dt').css('display','block');
           
       }else{
            $('#type dt').css('display','none');
       }
   }
   function tj()
   {
       if($('#jiaquan:checked').attr("checked"))
           {
               var count=0;
               $.each($('#type dt'),function(key,obj){ 
                   count = count+ parseInt($(obj).find('input').val());
               });
               if(count!=100)
                   {
                       alert("权重值之和应为100%");
                       return false;
                   }
           }
       if(!$('#work').text() && $('#zuopin lable').length==0)
       {
           alert('没有选择作业和作品，请选择');
           return false;
       }
        if($('#class lable').length==0)
          {
              alert('请选择学生');
              return false;
          }
   }
</script>
<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp">

        <div class="noticetit">
            <h1>生成成绩簿</h1>
        </div>

        <div class="noticenwarp noticenwarps">
            <form action="/study_score/select_score" method="post" onSubmit="return tj();">
                <div class="cjb">
                    <h2>1. 选择统计对象</h2>
                    <dl>
                        <dt>作业</dt>
                        <dd id="zy_num">
                              已选择<span>0</span>条作业　
                              <a href="/study_score/get_zuoye" class="iframe" id="xuanze">选择</a>
                              <a href="javascript:remove_attr();" id="qingkong" style="display: none;">清空</a> 
                              <a href="#" id="xiugai" style="display: none;" class="iframe">修改</a>
                        </dd>
                        <dd id="work"></dd>
                    </dl>
                    <dl>
                        <dt>作品</dt>
                        <dd><a href="/study_score/get_zuopin" class="iframe" id="zp_select">选择</a>
                        <a href="#" class="iframe" id="zp_bj" style="display: none;">编辑</a>
                         <a href="javascript:zuopin_qk();" id="zp_qk" style="display: none;">清空</a>
                        </dd>
                        <dd id="zuopin"></dd>
                    </dl>
                    <dl>
                        <dt>学生&nbsp;&nbsp;<input style="display: none" type="checkbox" id="select_all" onchange=" select_all1();" />&nbsp;&nbsp;<span style="display: none" >全选</span></dt>
                        <dd id="class">                         
                            <a href="/study_score/get_class" class="iframe" id="select_button" style=" width: 30px;">选择</a>
                        <a href="/study_score/get_class" class="iframe" id="a2" style="display: none; width: 30px;">编辑</a></dd>
                    </dl>
                </div>
                <div class="cjb">
                    <h2>2. 选择统计方式</h2>
                    <dl>
                        <dt >个人分数统计&nbsp;&nbsp;</dt>
                        <div id="type">
                            <dd><input name="type[]" type="checkbox" value="zongfen" />&nbsp;&nbsp;总分　</dd>
                            <dd><input name="type[]" type="checkbox" value="pingjunfen" />&nbsp;&nbsp;平均分</dd>
                            <dd><input name="type[]" type="checkbox" value="jiaquanzongji" id="jiaquan" onClick="kai();"/>&nbsp;&nbsp;加权总计</dd>
                        </div>
                    </dl>
                    <dl>
                        <dt>作业及测验统计&nbsp;&nbsp;<input name="" type="checkbox" value="" id="select_test" onClick="select_test1();"/>&nbsp;&nbsp;<span>全选</span></dt>
                        <input type="hidden" name="score[]" value="tiliang" />
                        <div id="score">
                            <dd>
                                <input name="score[]" type="checkbox" value="tiliang" checked="checked" disabled="disabled" id="tiliang"/>&nbsp;&nbsp;题量　&nbsp;&nbsp;
                                <input name="score[]" type="checkbox" value="max" />&nbsp;&nbsp;最高分&nbsp;&nbsp;
                                <input name="score[]" type="checkbox" value="min" />&nbsp;&nbsp;最低分&nbsp;&nbsp;
                                <input name="score[]" type="checkbox" value="total" />&nbsp;&nbsp;总分　&nbsp;&nbsp;
                                <input name="score[]" type="checkbox" value="pingjunfen" />&nbsp;&nbsp;平均分
                            </dd>
                            <dd>
                                <input name="score1[]" type="checkbox" value="youxiu" />&nbsp;&nbsp;优秀　&nbsp;&nbsp;
                                <input name="score1[]" type="checkbox" value="lianghao" />&nbsp;&nbsp;良好　&nbsp;&nbsp;
                                <input name="score1[]" type="checkbox" value="zhongdeng" />&nbsp;&nbsp;中等　&nbsp;&nbsp;
                                <input name="score1[]" type="checkbox" value="jige" />&nbsp;&nbsp;及格　&nbsp;&nbsp;
                                <input name="score1[]" type="checkbox" value="bujige" />&nbsp;&nbsp;不及格
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="cjb">
                    <h2>3. 选择生成方式</h2>
                    <dl>
                        <dd><input name="born" type="radio" value="wangye" checked/>&nbsp;&nbsp;网页　　<input name="born" type="radio" value="excel" />&nbsp;&nbsp;Excel文件</dd>
                    </dl>

                </div>
                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset"  class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit"  class="addbut" value="提交"  /></div>
                    
                </div>

            </form>               
        </div>

    </div>
</div>
