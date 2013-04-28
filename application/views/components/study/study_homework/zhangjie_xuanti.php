<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script language="javascript" src="/resource/js/ui.base.min.js"></script>
<script language="javascript" src="/resource/js/ui.tabs.min.js"></script>
<script src="/resource/colorbox/jquery.colorbox.js"></script>
<script>
    
    $(document).ready(function(){
        $(".iframe").colorbox({iframe:true, innerWidth:400, innerHeight:380,slideshowSpeed:2550});
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
    function addtocat(ul_id,count,attr,param,tx_id,zsd_id,key_id)
    {
        var ids ='';
        $('#'+ul_id).find('span:eq(0)').text(count);
        $.each(attr,function(key,obj){
            ids +=obj.value+',';          
        });
        ids = ids.substr(0,ids.length-1);
        $('#'+ul_id).find('input').val(ids);
         $('#'+ul_id).find('#status').find('#a1').css('display','none');
        $('#'+ul_id).find('#status').find('#a2').css('display','block');
        $('#'+ul_id).find('#status').find('#a3').css('display','block');
        $('#'+ul_id).find('#status').find('#a2').attr('href','/study_homework/get_shiti/'+param+'/'+tx_id+'/'+zsd_id+'?key_id='+key_id+'&ids='+ids);
    }
    
    function qingling(obj)
    {
        $('#'+obj).find('input').val('');
        $('#'+obj).find('span:eq(0)').text(0);
        $('#'+obj).find('#status').find('#a1').css('display','block');
        $('#'+obj).find('#status').find('#a2').css('display','none');
        $('#'+obj).find('#status').find('#a3').css('display','none');
    }
    function checknum(obj)
    {     
        if(!/^[0-9]*$/.test(obj.value))
           {
                alert('格式不正确，应填写数字');
                $('#'+obj.id).val('');
                return false;
           }  
    }
    function check_score()
    {
       var fen = <?= json_encode( $post_val['score'] ); ?>;
        var attr = $('#zhangjie h2 input');
        var score=0;
        $.each(attr,function(key,obj){
            score +=obj.value*1;
        });
        if(score==0)
         {
             alert('所填分值之和不能为0，请重新划分');
             return false;
         }
        if(score != fen )
            {
                alert('所填分值之和大于总分，请重新划分');
                return false;
            }
        
    }
</script>
<!--管理信息-->
<div class="noticesbox kecheng" id="frame2"  >
    <div class="noticewarp">
<form action="/study_homework/add_shiti" method="post">
    <?php foreach($post_val as $key=>$val){      
        ?>
    <input type="hidden" name="<?=$key?>" value="<?=$val?>"/>
    <?php }?>
        <div class="noticetit tearch-nav tearch-navts">
            <h1><?= $post_val[ 'title' ] ?><span>（总分：<?= $post_val[ 'score' ] ?>分）</span></h1>
        </div>

        <div class="work-cont">
            <div class="wc-choice wc-choice2">
                <div class="dcti" id="zhangjie">
                    <?php foreach ( $list as $key => $val ){ ?>
                         <?php foreach($val as $k=>$v){?>
                    <h2> <?=$k?>（共有 <?=$v['sum']?> 道题目，共计<input id ="tixing<?=$v['tixing_id']?>" type="text" name="scores[<?=$v['tixing_id']?>]" value="" class="sctext" onChange="checknum(this);"/>分）　<a href="#">新增</a></h2>
                    <?php foreach($v['zsd'] as $ks=>$vl){?>
                        <ul id="<?=$key?><?=$ks+1?>">
                            <input type="hidden" name="<?=$key?>[<?=$v['tixing_id']?>][]" value=""/>
                            <li><?=$vl['name']?></li>
                            <li>（已选<span> 0</span> 道题目，共有 <?=$vl['count']?> 道题目）</li>
                            <li><span id="status">
                                    <a href="/study_homework/get_shiti/<?=$key?>/<?=$v['tixing_id']?>/<?=$vl['zsd_id']?>?key_id=<?=$ks+1?>" class="iframe" id="a1">选择</a>
                                  <a href="" class="iframe" style="display:none; float:left" id="a2">编辑</a>  
                                  <a href="javascript:;"  style="display:none; float:left" id="a3" onClick="qingling('<?=$key?><?=$ks+1?>')">清零</a> 
                                </span>
                            </li>
                        </ul>
                    <?php }?>
                        <?php }?>
                        <?php  }?>
                </div>

                <div class="wc-line"></div>

                <div class="noticekateboxts">

                    <div class="datadel"><a href="javascript:window.history.go(-1);" >取消</a></div>
                    <div class="addbutin">
                        <input type="submit" class="addbut" value="保存" onClick="return check_score()"/></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        </form>
    </div>
</div>
<!--管理信息 end-->
