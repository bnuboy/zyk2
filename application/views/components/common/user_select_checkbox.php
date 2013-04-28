<!DOCTYPE html>
<HTML>
<HEAD>
	<TITLE> ZTREE DEMO - checkbox select menu</TITLE>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="/resource/js/ztreev3.3/css/zTreeStyle/zTreeStyle.css" type="text/css">
	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.core-3.3.js"></script>
	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.excheck-3.3.js"></script>
	<SCRIPT type="text/javascript">
		<!--
		var setting = {
			check: {
				enable: true
			},
			view: {
				dblClickExpand: false
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeClick: beforeClick,
				onCheck: onCheck
			}
		};

     <?php
     $str="";
		 $defaultval = explode(',', $defaultval);
		 foreach($users as $key => $value){
		     $checked = in_array($value['id'], $defaultval) ? ', checked:true' : '';
			    $str.= '{ id:'.$value['id'].', pId:0, name:"'.$value['name'].'", open:true '.$checked.'}';
          if(($key+1) < count($users)) $str .= ",";
		 }
		 ?>
		var zNodes =[<?=$str?>];
  
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
		
		function beforeClick(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		
		function onCheck(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			nodes = zTree.getCheckedNodes(true),
			v  = "";
			v2 = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				v  += nodes[i].name + ",";
			 v2 += nodes[i].id + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			if (v2.length > 0 ) v2 = v2.substring(0, v2.length-1);
			var cityObj = $("#citySel");
			cityObj.attr("value", v);
			var v2Obj = $("#<?php echo $inputid;?>");
			v2Obj.attr("value", v2);
		}
		

		function showMenu() {
			var cityObj = $("#citySel");
			var cityOffset = $("#citySel").offset();
			$("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");

			$("body").bind("mousedown", onBodyDown);
		}
		function hideMenu() {
			$("#menuContent").fadeOut("fast");
			$("body").unbind("mousedown", onBodyDown);
		}
		function onBodyDown(event) {
			if (!(event.target.id == "menuBtn" || event.target.id == "citySel" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
				hideMenu();
			}
		}

		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			setting.check.chkboxType = { "Y" : "ps", "N" : "ps" };
			onCheck();
		});
		//-->
	</SCRIPT>
	<style type="text/css">
div.content_wrap {width: 600px;height:380px;}
div.content_wrap div.left{float: left;width: 250px;}
div.content_wrap div.right{float: right;width: 340px;}
div.zTreeDemoBackground {width:250px;height:362px;text-align:left;}

ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}
ul.log {border: 1px solid #617775;background: #f0f6e4;width:300px;height:170px;overflow: hidden;}
ul.log.small {height:45px;}
ul.log li {color: #666666;list-style: none;padding-left: 10px;}
ul.log li.dark {background-color: #E3E3E3;}

/* ruler */
div.ruler {height:20px; width:220px; background-color:#f0f6e4;border: 1px solid #333; margin-bottom: 5px; cursor: pointer}
div.ruler div.cursor {height:20px; width:30px; background-color:#3C6E31; color:white; text-align: right; padding-right: 5px; cursor: pointer}

.citySel {
    background: url("../images/anlongbg.jpg") no-repeat scroll 0 0 transparent;
    border: 0 none;
    height: 34px;
    line-height: 34px;
    padding: 0 5px;
    width: 537px;
}

input {
    background: url("/resource/images/anlongbg.jpg") no-repeat scroll 0 0 transparent;
    border: 0 none;
    height: 34px;
    line-height: 34px;
    padding: 0 5px;
    width: 537px;
}


</style>
 </HEAD>

<BODY>

<input id="<?php echo $inputid;?>" name="<?php echo $inputname;?>" type="hidden" value=""/>
<input id="citySel" type="text" readonly value="" style="width:540px;" onclick="showMenu();"  style="background:url()"/>
<div id="menuContent" class="menuContent" style="display:none; position: absolute;">
	<ul id="treeDemo" class="ztree" style="margin-top:0; width:180px; height: 300px;"></ul>
</div>
</BODY>
</HTML>