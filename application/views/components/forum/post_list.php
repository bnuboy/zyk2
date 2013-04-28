<link rel="stylesheet" type="text/css" href="/resource/css/forum_base.css" />
<link rel="stylesheet" type="text/css" href="/resource/css/forum.css" />
<link rel="stylesheet" type="text/css" href="/resource/css/forum_cont.css" />
<link rel="stylesheet" type="text/css" href="/resource/css/forum_list.css" />
<div class="navgation">
  <div class="fl"><a href="/forum"><img src="/resource/images/forum/home.png" width="16" height="15" /></a> > <a href="/forum">高职资源平台论坛 </a> > <?= $count_info->title ?></div>

</div>
<div class="title">
  <div class="fr"> 主题：<a href="#"><?= $count_info->subject_count ?></a> 帖子：<a href="#"><?= $count_info->post_count ?></a> 今日：<a href="#"><?= $today_count ?></a> 用户：<a href="#"><?=$total_user?></a></div>
</div>

<div class="wp cl" id="ct">
  <!--头部翻页 begin-->
  <div class="pgs mbm cl" id="pgt">
    <div class="pgt">
      <div class="pg"><?= empty( $pagination[ 'link' ] ) ? "" : $pagination[ 'link' ] ?></div>
    </div>
    <a href="/forum/add/<?= $plate_id ?>" ><img alt="发新帖" src="/resource/images/forum/pn_post.png"></a>  </div>
</div>

<!--头部翻页 end-->
<div style="position: relative;width:961px; margin:5px auto" class="tl bm bmw" id="threadlist">
  <div class="th">
    <table cellspacing="0" cellpadding="0" class="th">
      <tbody>
        <tr>
          <th colspan="2" > 标题 </th>
          <td class="by">作者</td>
          <td class="num">回复/查看</td>
          <td class="by">最后回复</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="bm_c">


    <table cellspacing="0" cellpadding="0" summary="forum_16">
      <tbody >
        <?php
        foreach ( $list as $item )
        {
        ?>
          <tr>
            <td class="icn"><a target="_blank"> <img  src="/resource/images/forum/folder_new.gif"> </a></td>
            <th class="common"> <a class="xst"  href="/forum/view/<?= $item->id ?>"><?= $item->title ?></a> <img align="absmiddle" title="附件" alt="attachment" src="/resource/images/forum/common.gif">  </th>
            <td class="by"><cite> <a c="1" href="#"><?= $item->user->login_name ?></a></cite> <em><?= substr( $item->created, 0, 10 ) ?></em></td>
            <td class="num"><a class="xi2" href="#"><?= $item->reply ?></a><em><?= $item->view ?></em></td>
            <td class="by">
              <cite><a c="1" href="#" ><?= @$item->last_reply_user->login_name ?></a></cite>
              <em><a href="#"><span ><?= $item->cptime ?></span></a></em>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>