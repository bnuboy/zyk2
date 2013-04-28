<?php $this->load->helper('Util'); ?>
<!--管理信息-->
<div class="resourbox" >
  <div class="writeaddtit">
    <h1>参考资料列表</h1>
  </div>
<?php foreach ($list as $v) {?>
  <div class="resourlist">
    <div class="resourlistpic">
      <a href="/libresource/infolist/<?=$v['id'];?>">
        <img src="<?=$v['img'];?>"/>
      </a>
    </div>
    <div class="resourlistw">
      <h1><a href="/libresource/infolist/<?=$v['id'];?>" title="<?=$v['name'];?>"><?=Util::cut_str($v['name'], 12);?></a></h1>
      <p><a href="/libresource/infolist/<?=$v['id'];?>" title="<?=$v['description'];?>"><?=Util::cut_str($v['description'], 80);?></a></p>
    </div>
  </div>
  <?php } ?>
  <div class="clear"></div>
</div>
<!--管理信息 end-->


