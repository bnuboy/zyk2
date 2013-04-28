
<script type="text/javascript">
  function change_tab(num,tab_id,t,tab)
  {
    for(var i=1;i<=num;i++)
    {
      if(i==tab_id){
        $("#"+t+i).attr('class','over');
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
 <style type="text/css" media="screen"> 
			html, body	{ height:100%; }
			body { margin:0; padding:0; overflow:auto; }   
			#flashContent { display:none; }
        </style> 
<script type="text/javascript" src="/resource/js/flexpaper_flash.js"></script>
<div class="noticewarp">
  <div class="noticetit">
    <div class="resourdtit" style="background:url('');">
      <ul>
        <li style="width:25px;"><img src="/resource/images/resour.gif" /></li>
        <li  id="t1" class="over" onclick="change_tab(2,1,'t','tab')"><a href="#" title="资源预览" >资源预览</a></li>
        <li id="t2" onclick="change_tab(2,2,'t','tab')"><a href="#" title="资源评价">资源评价</a></li> 
        <li><a href="/ucenter_resource/myresourcelist" title="返回我的资源">返回我的资源</a></li>
      </ul>
    </div>
   </div>
  
  <div class="noticenwarp">
    <div class="resourevalbox" id="tab1">
	 
	 <div>
      
          <div style="left:10px;top:10px;">
           <?php            
           Util::showplayer($resource['file_path'],true);
           ?>
        </div>
</div>

      <div class="resourkate">
        <div class="resourreseename">名称：</div>
        <div class="resourreseedata"><?= $resource['name'];?></div>
      </div>

      <div class="resourkate">
        <div class="resourreseename">文件类型：</div>
        <div class="resourreseedata"><?= $resource['file_type'];?>文件</div>
      </div>

      <div class="resourkate">
        <div class="resourreseename">作者：</div>
        <div class="resourreseedata"><?= $resource['author'];?></div>
      </div>

      <div class="resourkate">
        <div class="resourreseename">作者联系方式：</div>
        <div class="resourreseedata"><?= $resource['author_address'];?></div>
      </div>

      <div class="resourkate">
        <div class="resourreseename">版权：</div>
        <div class="resourreseedata"><?= $resource['copyright'];?></div>
      </div>

      <div class="resourkate">
        <div class="resourreseename">关键词：</div>
        <div class="resourreseedata"><?= $resource['meta_keywords'];?></div>
      </div>
      <div class="resourkate">
        <div class="resourreseename">简介：</div>
        <div class="resourreseedata"><?= $resource['description'];?></div>
      </div>
    </div>


    
    <div class="resourevalbox" id="tab2" style="display: none;">

    </div>


  </div>
</div>