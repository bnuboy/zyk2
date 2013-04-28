<link type="text/css" href="/resource/css/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/css/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/css/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/css/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 

<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script language="javascript" src="/resource/js/ui.base.min.js"></script>
<script language="javascript" src="/resource/js/ui.tabs.min.js"></script>

<script language="javascript">
    $(function(){
        //直接制作Tab菜单
        $("#container > ul").tabs();
    });
</script>
<!--管理信息-->
<div class="noticesbox">
    <div class="noticewarp">
        <!--<div class="noticetit tearch-nav tearch-navts">
            <h2 class="cendatarav"  id="container">
                <ul>
                    <li class="over"><a href="#fragment-1" title="按章节统计">按章节统计</a></li>
                    <li><a href="#fragment-2" title="按用户统计">按用户统计</a></li>
                </ul>
            </h2>
        </div>-->
 <style type="text/css">
.tearch-nav h2 { float: none; font-size: 14px;font-weight: normal; line-height:normal; padding-left:0px;}
.tearch-nav .cendatarav { background:none;line-height:32px; clear: both; height:inherit;margin-bottom:inherit; font-family: "黑体"; padding:0px;}
.tearch-nav  .cendatarav ul li a{line-height:32px; color:#666;}
.tearch-nav .cendatarav ul li a:hover, .tearch-nav .cendatarav ul li.over a,.tearch-nav  .cendatarav ul li.over a:hover {background-image:none;background-color:#F2F4F7;
border-radius:5px 5px 0px 0px; box-shadow: 2px 3px 3px 0 #BAC3D8 inset; color: #0066AA; height: 32px;width: 75px;}
</style>
        
        <div class="noticetit tearch-nav tearch-navts dgxs-list" >
                <h2 class="cendatarav"  id="container">
                <ul>
                    <li class="over"><a href="#fragment-1" title="按章节统计">按章节统计</a></li>
                    <li><a href="#fragment-2" title="按用户统计">按用户统计</a></li>
                </ul> 
                </h2>
        </div>
        

        <div  id="fragment-1">
            <div class="databox databoxs" style="width:730px">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="*">章节名称</th>
                            <th width="75">未回答</th>
                            <th width="75">已回答</th>
                            <th width="75">常见问答</th>
                            <th width="75">总计</th>
                        </tr>
                    </thead>
                    <tbody id="resousdata">
                        <?php foreach($attr as $key=>$val){?>
                        <tr>
                            <td><?=$key?></td>
                            <td><?=  isset($val['n']) ? $val['n'] : '0'?></td>
                            <td><?=isset($val['y']) ? $val['y'] : '0'?></td>
                            <td><?=isset($val['faq']) ? $val['faq'] : '0'?></td>
                            <td><?=array_sum($val)?></td>
                        </tr>
                       <?php }?>
                    </tbody>                
                </table>
            </div>
        </div>
        <div  id="fragment-2">
            <!--管理信息-->
                        <div class="noticesbox">
    	<div class="noticewarp">
         	
            <div class="noticenwarp">
              <div class="databox databoxs" style="width:730px">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="*">用户名</th>
                                <th width="75">未回答</th>
                                <th width="75">已回答</th>
                                <th width="75">常见问答</th>
                                <th width="75">总计</th>
                            </tr>
                        </thead>
                        <tbody id="resousdatas">
                            <?php foreach ($attr_user as $key => $val) {?>
                            <tr>
                                <td><?=$key?></td>
                                <td><?=isset($val['n']) ? $val['n'] : 0?></td>
                                <td><?=isset($val['y']) ? $val['y'] : 0?></td>
                                <td><?=isset($val['faq']) ? $val['faq'] : 0?></td>
                                <td><?=array_sum($val)?></td>
                            </tr>
                            <?php } ?>
                        </tbody>                
                </table>
              </div>
            </div>
			
            
        </div>
    </div>

            <!--管理信息 end-->
            
            
        </div>

    </div>
</div>

<!--管理信息 end-->