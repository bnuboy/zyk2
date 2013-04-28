    <!--树形 start-->
   	<link rel="stylesheet" href="/resource/js/ztreev3.3/css/zTreeStyle/zTreeStyle.css" type="text/css">
   	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery-1.4.4.min.js"></script>
   	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.core-3.3.js"></script>
    <!--树形 end-->
	<SCRIPT type="text/javascript">
		<!--
		var setting = {
			view: {
				dblClickExpand: false,
				showLine: true,
				showIcon: true
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				onClick: onClick
			}
		};

		var zNodes =[
		 <?php 
		 foreach($cats as $key => $value){ 
			    echo '{ id:'.$value['id'].', pId:'.$value['f_id'].', name:"'.$value['name'].'", open:true, url:"/cms/resourcelist/?cat_id='.$value['id'].'", target:"_self" , isHover: true},';
		 }
		 ?>			
		];

		function onClick(e,treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.expandNode(treeNode);
		}

		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
		});
		//-->
	</SCRIPT>


<div class="navgation">首页 > 资源中心</div>

<div class="content">

  <div class="Cleft" style="width:200px;">
    <!--资源分类 begin-->
    <div class="zy rboder " style="width:200px;">
      <div class="title">资源分类</div>
		  <div style="display:block">
              <ul id="treeDemo" class="ztree"></ul>
          </div>
    </div>
    <!--资源分类 end-->
  </div>

  <div class="Cright" style="width:770px;">
    <!--资源列表 begin-->
    <div class="sub_news" style="width:767px;">
      <div class="news-top"><h3><?=$info['name'];?></h3></div>
      <div class="sn-list">
        <?php
        if(!empty($info['swf_path'])){
            Util::showplayer($info['swf_path']);
        }else if(!empty($info['file_path'])){
            Util::showplayer($info['file_path']);
        }else{
            echo "无可执行的文件";
        }
        ?>
      </div>
    </div>
    <!--资源列表 end-->
  </div>
  
</div>