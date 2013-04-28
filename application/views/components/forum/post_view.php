<link rel="stylesheet" type="text/css" href="/resource/css/forum_base.css" />
<link rel="stylesheet" type="text/css" href="/resource/css/forum.css" />
<link rel="stylesheet" type="text/css" href="/resource/css/forum_cont.css" />
<link rel="stylesheet" type="text/css" href="/resource/css/forum_list.css" />
<script type="text/javascript" src="/resource/js/kd/kindeditor-min.js"></script>
<div class="navgation">
  <div class="fl"><a href="/forum"><img src="/resource/images/forum/home.png" width="16" height="15" /></a> > <a href="/forum">高职资源平台论坛</a> >  <a href="/forum/postlist/<?=$data->plate_id?>"><?=$plate_info->title?></a>>  <?=$data->title?></div>
</div>
<div class="wp cl" id="ct">
  <!--头部翻页 begin-->
  <div class="pgs mbm cl" id="pgt">
    <div class="pgt">
      <div class="pg"><?= empty( $pagination[ 'link' ] ) ? "" : $pagination[ 'link' ] ?></div>
    </div>
    <span class="y pgb">
      <a href="/forum/postlist/<?=$data->plate_id?>">返回列表</a>
    </span>
    <a title="发新帖" href="/forum/add/<?=$data->plate_id?>"><img alt="发新帖" src="/resource/images/forum/pn_post.png"></a>
    <a title="回复" href="#replay" onclick="$('.ke-edit-iframe').focus()"><img alt="回复" src="/resource/images/forum/pn_reply.png"></a>
  </div>
  <!--头部翻页 end-->
  <div class="pl bm bmw" id="postlist">
    <!--楼主 begin-->
    <div class="bbslist" <?php if($start>0)echo "style='display: none'";?>>
      <table cellspacing="0" cellpadding="0" summary="pid5356600" class="fo" id="pid5356600" >
        <tbody>
          <tr>
            <td rowspan="2" class="pls"><div class="pi">
                <div class="authi"><a class="xw1" target="_blank" href="#"><?=$data->user->name?></a></div>
              </div>
              <p><img src="<?=!empty($data->user->face) ? $data->user->face : '/resource/images/defaultuserface.jpg';?>" width="108" height="80" /></p>
              <dl class="pil cl">
                <dt><?=$data->user->login_name?></dt>
                <dd></dd>
                <dt>帖子</dt>
                <dd><?=$data->user->posts_count?> &nbsp;</dd>
              </dl>
            </td>
            <td class="plc">
              <h1 class="ts"> <a  href=""><?=$data->title?></a> </h1>
              <div class="pi"> <strong> <a class="brm">楼主</a> </strong>
                <div class="pti">
                  <div class="authi"> <em id="authorposton5356600">发表于 <?=$data->created?></em> </div>
                </div>
              </div>
              <div class="pct">
                <div class="pcb">
                  <div class="t_fsz">
                    <table cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td id="postmessage_5356600" class="t_f">
                            <br>
                            <?=$data->content ?><br>
                            <br></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="plc plm"></td>
          </tr>
          <tr>
            <td class="pls"></td>
            <td class="plc"><div class="po">
                <div class="pob cl"> </div>
              </div></td>
          </tr>
          <tr class="ad">
            <td class="pls"></td>
            <td class="plc"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--楼主 end-->
    <!--1楼 begin-->
    <div class="bbslist">
      <table cellspacing="0" cellpadding="0" summary="pid5356600" class="fo" id="pid5356600">
        <tbody>
          <?php
            $i=$start+1;
          foreach ($repeat_info as $info) {?>
          <tr>
            <td rowspan="2" class="pls"><div class="pi">
                <div class="authi"><a class="xw1" target="_blank" href="#"><?=$info->user->name?></a></div>
              </div>
              <p><img src="<?=!empty($info->user->face) ? $info->user->face : '/resource/images/defaultuserface.jpg';?>" width="108" height="80" /></p>
              <dl class="pil cl">
                <dt><?=$info->user->login_name?></dt>
                <dd></dd>
                <dt>帖子</dt>
                <dd><?=$info->user->posts_count?> &nbsp;</dd>
              </dl>
              <p></p></td>
            <td class="plc"><h1 class="ts"> <a  href=""><?=$info->title?></a> </h1>
              <div class="pi"> <strong> <a class="brm"><?=$i++?>#</a> </strong>
                <div class="pti">
                  <div class="authi"> <em id="authorposton5356600">发表于 <?=$info->created?></em> </div>
                </div>
              </div>
              <div class="pct">
                <div class="pcb">
                  <div class="t_fsz">
                    <table cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td id="postmessage_5356600" class="t_f">
                            <br>
                              <?=$info->content?>
                            <br></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div></td>
          </tr>
          <tr>
            <td class="plc plm"></td>
          </tr>
          <tr>
            <td class="pls"></td>
            <td class="plc"><div class="po">
                <div class="pob cl"> </div>
              </div></td>
          </tr>
            <?php } ?>
          <tr class="ad">
            <td class="pls"></td>
            <td class="plc"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--1楼 end-->
    <table cellspacing="0" cellpadding="0">
      <tbody>
        <tr class="modmenu">
          <td class="pls hm ptm pbm">
            <?=empty($prev[0]->id)?" ‹ 上一主题":"<a href='/forum/view/{$prev[0]->id}'>‹ 上一主题</a>"?>
            <span class="pipe">|</span>
            <?=empty($next[0]->id)?" 下一主题":" <a href='/forum/view/{$next[0]->id}'>下一主题"?>
            <em>›</em></a></td>
          <td class="modmenu plc ptm pbm xi2"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!--底部翻页 begin-->
  <div class="pgs mtm mbm cl">
    <div class="pgt">
      <div class="pg"><?= empty( $pagination[ 'link' ] ) ? "" : $pagination[ 'link' ] ?></div>
    </div>
    <span class="y pgb">
      <a href="/forum/postlist/<?=$data->plate_id?>">返回列表</a>
    </span>
    <a href="/forum/add/<?=$data->plate_id?>"title="发新帖" ><img alt="发新帖" src="/resource/images/forum/pn_post.png"></a>
    <a  onclick="$('.ke-edit-iframe').focus()" href="#replay" title="回复" ><img alt="回复" src="/resource/images/forum/pn_reply.png"></a> </div>
  <!--底部翻页 end-->

  <div class="coment" id="replay">
    <form action="/forum/reply/<?=$data->id?>/<?=$data->plate_id?>" method="post">
      <table cellspacing="0" cellpadding="0">
        <tbody>
          <tr class="modmenu">
            <td class="pls plst">回复</td>
          </tr><tr>
            <td class="plc">
              <script type="text/javascript">

                var editor;
                KindEditor.ready(function(K) {
                  editor = K.create('textarea[name="content"]', {
                    resizeType : 1,
                    allowPreviewEmoticons : false,
                    allowImageUpload : false,
                    items : [
                      'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                      'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                      'insertunorderedlist', '|', 'emoticons', 'image', 'link']
                  });
                });
              </script>
              <textarea style="width:920px;height: 183px;" name="content" id="content"></textarea>
              </br>
              <input type="submit" value="发表回复"  class="pn" />
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>


</div>