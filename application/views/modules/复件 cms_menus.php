<div class="nav">
  <div class="nav-left">    
    <a href="/cms/index" class="<?=$action == 'index' ? 'hver' : '';?>">首页</a>
	   <a href="/cms/resourcelist" class="<?=($action == 'resourcelist' || $action == 'resourcedetail') ? 'hver' : '';?>">资源中心</a>
     <a href="/cms/courselist" class="<?=($action == 'courselist' || $action == 'courselist') ? 'hver' : '';?>">学习中心</a>
    <?php 
    foreach($menus as $k => $v) {
        $class = "";
        if($menuid == $v['id']) $class = "hver";
        if($v['type'] == 'article'){
            echo "<a href='/cms/articlelist?menuid=".$v['id']."' class='".$class."'>".$v['name']."</a>";
        }else if($v['type'] == 'page'){
            echo "<a href='/cms/page?menuid=".$v['id']."' class='".$class."'>".$v['name']."</a>";
        }else if($v['type'] == 'link'){
            echo "<a href='".$v['url']."' class='".$class."' target='_blank'>".$v['name']."</a>";
        }
    }
    ?>
  </div>
  <div class="nav-right">
    <h3>其他行业专业</h3>
    <select onchange="jumpcms(this.options[this.selectedIndex].value);" name="">
      <option value="">==请选择==</option>
      <?php foreach($organizations as $k => $v){ ?>
          <option value="<?=$v['id'];?>" <?=($this->cmsorg['id'] == $v['id']) ? 'selected' : '';?>><?=$v['name'];?></option>
      <?php } ?>
    </select>
  </div>
</div>

<script>
  function jumpcms(id){
      if(id == ''){
          return false;
      }
      location.href="/cms/index?cmsorg_id="+id;
  }
</script>