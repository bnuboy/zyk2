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
    function addtocat(ul_id,count,attr,param,tx_id)
    {
        var ids ='';
        $('#'+ul_id).find('span:eq(0)').text(count);
        $.each(attr,function(key,obj){
            ids +=obj.value+',';          
        });
        ids = ids.substr(0,ids.length-1);
        $('#'+ul_id).find('input').val(ids);
    }
    function qingling(id1,id2)
    {
       $('#'+id1+id2).val('');
    }
    
    function checknum(val)
    {
        if(!/^[0-9]*$/.test(($('#'+val).find('li:eq(1) input').val())))
           {
                alert('格式不正确，应填写数字');
                return false;
           }
        
        if($('#'+val).find('li:eq(1) input').val() > $('#'+val).find('li:eq(1) span').text())
            {
                alert('题量不能超过现有的试题数量');
                $('#'+val).find('li:eq(1) input').val('');
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
<form action="/study_mytest/add" method="post">
    <?php foreach($post_val as $key=>$val){      
        ?>
    <input type="hidden" name="<?=$key?>" value="<?=$val?>"/>
    <?php }?>
        <div class="noticetit tearch-nav tearch-navts">
            <h1><?= $post_val[ 'title' ] ?><span>（总分：<?= $post_val[ 'score' ] ?>分）</span></h1>
        </div>
<!--$key试题是基本类型，$k是题型，$v['tixing_id']是题型的ID，$vl['zsd_id']是知识点的ID-->
        <div class="work-cont">
            <div class="wc-choice wc-choice2">
                <div class="dcti" id="zhangjie">
                    <?php foreach ( $list as $key => $val ){ ?>
                         <?php foreach($val as $k=>$v){?>
                    <h2> <?=$k?>（共有 <?=$v['sum']?> 道题目，共计<input type="text" name="scores[<?=$v['tixing_id']?>]" value="" class="sctext"/>分）　<a href="#">新增</a></h2>
                    <?php foreach($v['zsd'] as $ks=>$vl){    ?>
                        <ul id="<?=$key?><?=$ks+1?>">                          
                            <li><?=$vl['name']?></li>
                            <li>题量<input type="text" name="<?=$key.'['.$v['tixing_id'].']['.$vl['zsd_id'].']'?>" class="sctext" id="<?=$v['tixing_id'].$vl['zsd_id']?>" value="" onChange="checknum('<?=$key?><?=$ks+1?>')"/>（共有 <span><?=$vl['count']?> </span>道题目）</li>
                            <li><span id="status">
                                   <div class="datadel"><a href="#" title="清零" onclick="qingling(<?=$v['tixing_id']?>,<?=$vl['zsd_id']?>)">清零</a></div>
                                </span>
                            </li>
                        </ul>
                    <?php }?>
                        <?php }?>
                        <?php  }?>
                </div>

                <div class="wc-line"></div>

                <div class="noticekateboxts">

                    <div class="datadel"><a href="/study_homework/index">取消</a></div>
                    <div class="addbutin">
                        <input type="submit" class="addbut" value="保存" onClick="return check_score()" /></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        </form>
    </div>
</div>
<!--管理信息 end-->
