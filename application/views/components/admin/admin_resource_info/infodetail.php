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
<style>
 ul {
    list-style: none outside none;
}

.resourbox {
    background: none repeat scroll 0 0 #F5F7F9;
    border: 1px solid #C3D0E1;
    clear: both;
    margin: 0 auto;
    padding-bottom: 30px;
    width: 941px;
}

.resourdtit ul li {
    float: left;
    height: 21px;
    line-height: 21px;
    margin-right: 5px;
    padding-top: 4px;
    text-align: center;
    width: 75px;
}
li {
    list-style: none outside none;
}
.resourdtit ul li a {
    display: block;
    height: 21px;
    line-height: 21px;
    width: 75px;
}
a {
    color: #1F1F1F;
    text-decoration: none;
}
.resourdtit ul li a:hover, .resourdtit ul li.over a, .resourdtit ul li.over a:hover {
    background: url("/resource/images/centerdararavbg.jpg") no-repeat scroll 0 0 transparent;
    color: #FFFFFF;
}

.resourevalbox {
    clear: both;
    margin: 0 auto;
    padding-top: 10px;
    width: 720px;
}

.resourkate {
    clear: both;
    padding-top: 10px;
}
.resourreseename {
    float: left;
    font-size: 13px;
    height: 25px;
    line-height: 25px;
    text-align: right;
    width: 100px;
}

.resourdtit {
    background: url("/resource/images/resourtbg.jpg") repeat-x scroll 0 0 transparent;
    clear: both;
    height: 30px;
}

.resourreseedata {
    float: left;
    font-size: 13px;
    line-height: 25px;
}
</style>
<script type="text/javascript" src="/resource/js/flexpaper_flash.js"></script>

<div class="noticewarp">
  <div class="noticetit">
    <div class="resourdtit" style="background:url('');">
      <ul>
        <li style="width:25px;"><img src="/resource/images/resour.gif" /></li>
        <li  id="t1" class="over" onclick="change_tab(2,1,'t','tab')"><a href="#" title="资源预览" >资源预览</a></li>
       
        <li id="t2" onclick="change_tab(2,2,'t','tab')"><a href="#" title="资源评价">资源评价</a></li>
        <li style="float:right"><a href="/admin_resource_info/infolist" title="返回资源列表">返回资源列表</a></li>
      </ul>
    </div>
   </div>
   <div class="resourevalbox" id="tab1" style="height:900px; ">

	<div>
        <?php
        /*
        if(!empty($resource['swf_path'])){
            Util::showplayer($resource['swf_path']);
        }else 
        */
        //if(!empty($resource['file_path'])){      
            Util::showplayer($resource['file_path'],true);
       // }else{
          //  echo "无可执行的文件";
        //}
        ?>
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

      <div style="clear:both"></div>
      <div class="resourkate">
        <div class="addbutin" style=" float:left; margin-left:20px"><a target="_blank" href="<?= $resource['file_path'];?>">下载资源</a></div>
      </div>


      <div class="resourreseebg" style="padding-left: 240px;">
        <div class="resourreseenbg">
          <div class="tesourrreseepic"><img src="images/resoulbg.jpg" width="6" height="49" /></div>
          <div class="tesourreseeup" style="cursor:pointer" onclick="upordown(<?= $resource['id']; ?>, 'up')"><span id="up"><?= $resource['up']; ?></span></div>
          <div class="tesourreseedown" style="cursor:pointer" onclick="upordown(<?= $resource['id']; ?>, 'down')"><span id="down"><?= $resource['down']; ?></span></div>
          <div class="tesourrreseepic"><img src="images/resourbg.jpg" width="6" height="49" /></div>
        </div>
      </div>

    </div>


    <div class="resourevalbox" id="tab2" style="display: none;height:900px; ">
        <div id="commentlist"></div>
        <div class="resourevalwritebox">
          <form id="sub_form">
            <input type="hidden" id="score" name="score" value="3" />
            <input type="hidden" id="source_id" name="source_id" value="<?php echo $resource['id'];?>" />
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $this->user['id'];?>" />
            <div class="resourevalwritetit">
              <div class="resoureavalwtw">打分</div>
              <div class="resoureavalwtpic" id="scoresArea">
                <img width="23" height="24" onclick="setScores(1)" src="/resource/images/starcf1.jpg">
                <img width="23" height="24" onclick="setScores(2)" src="/resource/images/starcf1.jpg">
                <img width="23" height="24" onclick="setScores(3)" src="/resource/images/starcf1.jpg">
                <img width="23" height="24" onclick="setScores(4)" src="/resource/images/starbg.jpg">
                <img width="23" height="24" onclick="setScores(5)" src="/resource/images/starbg.jpg">
              </div>
            </div>
            <div class="resoureavalin"><textarea name="comment" id="comment"></textarea></div>
            <div style="width:705px; height:38px;" id="sendbut" class="resourkate">
              <div class="addbutin"><input type="button" value="评论" class="addbut" onclick="commentadd();"></div>
            </div>
          </form>
        </div>
    </div>


  </div>




<div class="clear"></div>

