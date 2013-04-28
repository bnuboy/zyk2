<!--树形结构 带复选框-->
<link rel="stylesheet" href="/resource/js/ztree/css/demo.css" type="text/css">
<link rel="stylesheet" href="/resource/js/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="/resource/js/ztree/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/resource/js/ztree/js/jquery.ztree.core-3.1.js"></script>
<script type="text/javascript" src="/resource/js/ztree/js/jquery.ztree.excheck-3.1.js"></script>
<!--处理等待效果-->
<script type="text/javascript" src="/resource/js/blockUI.js"></script>
<script type="text/javascript" src="/resource/js/common.js"></script>
<SCRIPT type="text/javascript">
		<!--
		var setting = {
			check: {
				enable: true
			},
			data: {
				simpleData: {
      enable: true
				}
			}
		};
<?php $str = ""; 
		 foreach($nodes as $key => $value){ 
		     $checked = in_array($value['id'],$roleNodeIds) ? ', checked:true' : '';
			    $str .= '{ id:'.$value['id'].', pId:'.$value['f_id'].', name:"'.$value['name'].'", open:true '.$checked.'}';
        if(($key+1) < count($nodes)) $str .= ",";
        }
?>	
		var zNodes =[<?=$str?>
		 
		 //{ id:221, pId:22, name:"随意勾选 2-2-1", checked:true},
		];
		
		
		 
		var code;
		
		function setCheck() {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			py = $("#py").attr("checked")? "p":"",
			sy = $("#sy").attr("checked")? "s":"",
			pn = $("#pn").attr("checked")? "p":"",
			sn = $("#sn").attr("checked")? "s":"",
			type = { "Y":py + sy, "N":pn + sn};
			zTree.setting.check.chkboxType = type;
			showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
		}
		function showCode(str) {
			if (!code) code = $("#code");
			code.empty();
			code.append("<li>"+str+"</li>");
		}
		
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			setting.check.chkboxType = { "Y" : "ps", "N" : "ps" };
			
		});
		
		//分配选中节点到组
		function setMenuToGroup(){
		    loading("请稍等，正在分配菜单到组......");
      var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
      var menus = treeObj.getCheckedNodes(true);
      var groupid = <?php echo $groupid;?>;
      $.post("/admin_manager/setmenu/"+groupid, {menus:menus}, function(data){
          $.unblockUI();
          alert("分配菜单成功");
          closewin();
      });
  }
  
  //展开收起节点
  function setExpandAll(bool){
      var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
      treeObj.expandAll(bool);
  }

  //关闭窗口
  function closewin(){
      parent.$.fn.colorbox.close();
      //window.parent.getlist('/power/roleList');
  }
		//-->
	</SCRIPT>
	
<style>
	ul.ztree{width:400px;}
	div.zTreeDemoBackground{width:400px;};
</style>

	<table style="width:100%;">
  <tr>
    <td style="width:70%;">
      <div class="zTreeDemoBackground left">
        <ul id="treeDemo" class="ztree"></ul>
      </div>
    </td>
    <td style="width:30%;">
      <div>
        <br><br><br><br>
        <input style="cursor:pointer" type="button" class="bj_bt" onclick="setExpandAll(true);" value="展开全部节点"><br><br>
        <input style="cursor:pointer" type="button" onclick="setExpandAll(false);" value="收起全部节点"><br><br>
        <input style="cursor:pointer" type="button" onclick="setMenuToGroup();" value="分配选中菜单到组"><br><br>
        <input style="cursor:pointer" class="bj_bt cz" type="button"  value="关闭" onclick="closewin();"/>
      </div>
    </td>
  </tr>
</table>