<script type="text/javascript">

  /*
  * 标签切换
  */
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

  /*
  * 支持|反对点击
  */
  function upordown(id, type){
      var strurl     = '/libresource/upordown';
      $.post(strurl, {id:id,type:type}, function(data){
          if(data == 'ok'){
              if(type == 'up'){
                  alert('顶贴成功');
                  num = $("#up").text();
                  $("#up").text(parseInt(num)+1);
              }else{
                  alert('踩贴成功');
                  num = $("#down").text();
                  $("#down").text(parseInt(num)+1);
              }
          }else{
              alert('失败！');
          }
      });
  }

    /*
    *显示评论列表
    */
    function commentlist(strurl){
        var pagesize = 5;
        $.post(
            strurl,
            {
                pagesize:pagesize,resource_id:<?php echo $resource['id'];?>
            },
            function(data){
                $('#commentlist').html(data);
            }
        );
    }
    commentlist('/libresource/commentlist');

    /*
    * 添加评论
    */
    function commentadd(){
        var score     = $("#score").val();
        var source_id = $("#source_id").val();
        var user_id   = $("#user_id").val();
        var comment   = $("#comment").val();
        if(comment == ''){
            alert('请天填写论内容！');
            return false;
        }
        $.post(
            '/libresource/commentadd',
            {
                score:score,
                source_id:source_id,
                user_id:user_id,
                comment:comment
            },
            function(data){
                alert('发表评论成功！');
                commentlist('/libresource/commentlist');
            }
        );
    }


  function setScores( score ){
    var imgs = $('#scoresArea img');
    imgs.attr('src','/resource/images/starbg.jpg');
    for(i=0;i<score;i++){
      $( imgs[i] ).attr('src','/resource/images/starcf1.jpg');
    }
    $('#score').val( score );
  }

</script>
<script type="text/javascript" src="/resource/js/flexpaper_flash.js"></script>

<div class="resourrdbox">
  <div class="resourrnbox">
    <div class="resourdtit">
      <ul>
        <li  id="t1" class="over" onclick="change_tab(3,1,'t','tab')"><a href="#" title="资源信息" >资源信息</a></li>
        <li id="t2" onclick="change_tab(3,2,'t','tab')"><a href="#" title="资源预览">资源预览</a></li>
        <li id="t3" onclick="change_tab(3,3,'t','tab')"><a href="#" title="资源评价">资源评价</a></li>
      </ul>
    </div>

    <div class="resourevalbox" id="tab1" style="height:500px;">

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
        <div class="resourreseename"><a target="_blank" href="<?= $resource['file_path'];?>">下载资源</a></div>
      </div>


      <div class="resourreseebg">
        <div class="resourreseenbg">
          <div class="tesourrreseepic"><img src="images/resoulbg.jpg" width="6" height="49" /></div>
          <div class="tesourreseeup" style="cursor:pointer" onclick="upordown(<?= $resource['id']; ?>, 'up')"><span id="up"><?= $resource['up']; ?></span></div>
          <div class="tesourreseedown" style="cursor:pointer" onclick="upordown(<?= $resource['id']; ?>, 'down')"><span id="down"><?= $resource['down']; ?></span></div>
          <div class="tesourrreseepic"><img src="images/resourbg.jpg" width="6" height="49" /></div>
        </div>
      </div>

    </div>

    <div class="resourevalbox" id="tab2" style="display: none;height:500px;">
      <div>
        <?php
        if(!empty($resource['swf_path'])){
            Util::showplayer($resource['swf_path']);
        }else if(!empty($resource['file_path'])){
            Util::showplayer($resource['file_path']);
        }else{
            echo "无可执行的文件";
        }
        ?>
      </div>
    </div>

    <div class="resourevalbox" id="tab3" style="display: none;height:900px;">
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
</div>

</div>

<div class="clear"></div>
</div>
<!--管理信息 end-->