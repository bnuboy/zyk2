<div class="resourrdbox1">
  <div class="resourkate">
    <div class="notiness">共有参考资料<span><?=$count?></span>条</div>
    <form id="search_form" action="/Libresource/infolist/<?=$library_id;?>/<?=$cat_id;?>"  method="get">
      <div class="serchbox" style="">
          <div class="serchninput"><input type="text" value="<?= isset($get[ 'keyword' ]) ? $get[ 'keyword' ]  : '请输参考资料源名' ?>" onclick="this.value=''" name="keyword"></div>
        <div class="serchbut"><input type="submit" value="搜索" id="serchadd"></div>
      </div>
    </form>
  </div>

  <div class="resourkate" style="height:30px;">

    <?=$pagination?>

  </div>
  <div class="databox1" style="width:938px;">
    <table width="100%" cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th width="8%"  style="text-align:center">序号</th>
          <th width="35%" style="text-align:center">标题</th>
          <th width="15%" style="text-align:center">关键字</th>
          <th width="10%" style="text-align:center">格式</th>
          <th width="10%" style="text-align:center">大小(MB)</th>
          <th width="10%" style="text-align:center">下载次数</th>
          <th width="10%" style="text-align:center">操作</th>
        </tr>
      </thead>
      <tbody id="resousdata">
        <?php foreach ($list as $k => $v) { ?>
        <tr><!--echo (($PB_page-1)*$pagesize)+$k+1;-->
          <td style="text-align:center"><?=$limit+$k+1;?></td>
          <td><a href="/libresource/infodetail/<?=$library['id'];?>/<?=$cat_id;?>/<?=$v['id'];?>"><?=$v['name'];?></a></td>
          <td style="text-align:center"><?=$v['meta_keywords'];?></td>
          <td style="text-align:center"><?=$v['file_type'];?></td>
          <td><?=round($v['file_size']/(1024*1024),5);?></td>
          <td style="text-align:center"><?=$v['download'];?></td>
          <td style="text-align:center"><a href="/libresource/xz?data=<?=$v['file_path'];?>" target="_blank" onclick="down(<?=$v['id'];?>);">下载</a></td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>

  <?=$pagination?>

</div>


<div class="clear"></div>
</div>
<script>
 function down(id){
         $.post('/libresource/down', {id:id}, function(data){
              
         });
 }
 </script>