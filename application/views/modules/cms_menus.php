<div class="ravbox">
  <div class="nav-left">    
    <ul>
    <li class="<?=$action == 'index' ? 'over' : '';?>"><a href="/cms/index" >首页</a></li>
    <li class="<?=($action == 'resourcelist' || $action == 'resourcedetail') ? 'over' : '';?>"><a href="/cms/resourcelist" >资源中心</a></li>
    
    <?php 
    foreach($menus as $k => $v) {
        $class = "";
        if($menuid == $v['id']) $class = "over";
        if($v['type'] == 'article'){
            echo "<li class='".$class."'><a href='/cms/articlelist?menuid=".$v['id']."' >".$v['name']."</a></li>";
        }else if($v['type'] == 'page'){
            echo "<li class='".$class."'><a href='/cms/page?menuid=".$v['id']."' >".$v['name']."</a></li>";
        }else if($v['type'] == 'link'){
            echo "<li class='".$class."'><a href='".$v['url']."'  target='_blank'>".$v['name']."</a></li>";
        }
    }
    ?>
    </ul>
  </div>
  <div class="nav-right">
    <h3 id='selvalue'><?=$this->cmsorg['name']?></h3>
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
	  //$('#selvalue').text();

      location.href="/cms/index?cmsorg_id="+id;
	  //$('#selvalue').text(test);
  }
</script>