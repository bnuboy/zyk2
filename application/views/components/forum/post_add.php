<link rel="stylesheet" type="text/css" href="/resource/css/forum_base.css" />
<link rel="stylesheet" type="text/css" href="/resource/css/forum.css" />
<script type="text/javascript" src="/resource/js/kd/kindeditor-min.js"></script>

<div class="navgation">
  <div class="fl"><a href="#"><img src="/resource/images/forum/home.png" width="16" height="15" /></a> > <a href="/forum">高职资源平台论坛 </a> ><a href="/forum/postlist/<?=$plate_info->id?>"><?=$plate_info->title?> </a>  > 发布帖子</div>
  <div class="fr" style="display:none">高职资源平台<b>论坛</b></div>
</div>
<div class="ftz">
  <form action="/forum/addup/<?= $plate_info->id ?>" method="post">
    <h3>发表帖子</h3>
    <dl><dt>标题</dt><dd><input name="title" type="text" class="text" /></dd></dl>
    <dl><dt>内容</dt>
      <dd>
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
        <textarea name="content" style="width:700px;height: 300px;" cols="" rows="" class="textarea"></textarea>
      </dd></dl>
    <p>
      <input type="submit" class="qd" value="发表帖子" />
      &nbsp;&nbsp;
      <input type="button" class="qd" onclick="location.href='/forum/postlist/<?=$plate_info->id?>'" value="取消" />
    </p>
  </form>
</div>