
<div class="writebox">
  <div class="writeadd">
    <div class="writeaddtit" style=" margin:0 20px;">
      <h1><img src="/resource/images/emailedit.gif" />通讯录</h1>
    </div>

    <div class="noticekatebox" style="width: 625px !important">
      <form method="get" action="/ucenter_user_contact/contact_list" id="search_form">
        <div class="notiness">共有好友<span><?=$count;?></span>个</div>
        <div style="margin-right:-3px;" class="notiness">
          <select style="padding:5px" name="contact_group_id" onchange="this.form.submit()">
            <option value="">&nbsp;所有分组&nbsp;</option>
            <option value="0" <?= isset($get[ 'contact_group_id' ] ) && $get[ 'contact_group_id' ] == 0 ? 'selected' : '' ?>>未分类</option>
            <?php foreach($groups as $k => $v){ ?>
              <option <?= isset($get[ 'contact_group_id' ] ) && $get[ 'contact_group_id' ] == $v['id'] ? 'selected' : '' ?> value="<?=$v['id'];?>"><?=$v['name']?></option>
            <?php } ?>
          </select>
        </div>
      </form>
    </div>

    <div class="noticekatebox" style="width: 625px !important">
      <div class="dataediabox">
        <div class="ediacheck"><input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" /></div>
        <div class="ediacheckw">全选</div>
        <div class="datadel"><a href="#this" onclick="return checkDelMorMsg('sub_form', 'item_id[]', '您确定要进行批量删除操作吗？', '请选择要删除的数据')" title="删除">删除</a></div>
        <div class="datasend"><a href="/ucenter_user_contact/contact_edit" title="新建">新建</a></div>
      </div>
      <?=$pagination?>
    </div>    

          <div class="databox" style="width: 625px !important">
            <form id="sub_form" name="sub_form" method="post" action="/ucenter_user_contact/contact_del">
            <table width="100%" cellpadding="0" cellspacing="0">
              <thead>
                <tr>
                  <th width="5%">&nbsp;</th>
                  <th width="20%">姓名</th>
                  <th width="20%">用户名</th>
                  <th width="10%">类型</th>
                  <th width="20%">分组</th>
                  <th width="25%">操作</th>
                </tr>
              </thead>
              <tbody id="resousdata">
          <?php foreach ( $list as $k => $v ) { ?>
              <tr>
                <td><input class="check" name="item_id[]" value="<?= $v['id']; ?>" type="checkbox"/></td>
                <td><?= isset($v['user']['name']) ? $v['user']['name'] : ''; ?></td>
                <td><?= isset($v['user']['login_name']) ? $v['user']['login_name'] : ''; ?></td>
                <td><?= isset($USER_TYPE[$v['user']['type']]) ? $USER_TYPE[$v['user']['type']] : ''; ?></td>
                <td><?= isset($v['group']['name']) ? $v['group']['name'] : '未分类'; ?></td>
                <td>
                <a href="/ucenter_user_contact/contact_edit?id=<?= $v['id']; ?>" title="编辑">编辑<img align="middle" src="/resource/images/ediapen.gif" width="20" height="20" /></a>&nbsp;|&nbsp;
                <a href="/ucenter_user_contact/contact_del?id=<?=$v['id'];?>" title="删除" onclick="javascript:return confirm('您确定要删除此联系人吗?');">删除<img align="middle" src="/resource/images/del.gif" width="16" height="17" /></a>
                </td>
              </tr>
          <?php } ?>
          </tbody>
        </table>
        </form>
      </div>
      <div class="noticekatebox" style="width: 625px !important"><?= $pagination ?></div>
    </div>
          
          <div class="writeaddr">
            <div class="writeaddtit">
              <h1><img src="/resource/images/group.gif" />分组
                <a href="/ucenter_user_contact/group_add" style="padding-left:8px;" class="iframe">新建分组</a>
              </h1>
            </div>
            <div class="writewordbox">
	              <div style="display:block">
	               	<ul id="treeDemo" class="ztree"></ul>
              </div>
            </div>
          </div>
</div>
<!--管理信息 end-->


<!--树形 start-->
<link rel="stylesheet" href="/resource/js/ztreev3.3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.core-3.3.js"></script>
	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.excheck-3.3.js"></script>
	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.exedit-3.3.js"></script>
<!--树形 end-->

	
<link type="text/css" href="/resource/js/front/colorbox/colorbox.css" rel="stylesheet" />
<script src="/resource/js/front/colorbox/jquery.colorbox.js"></script>
<script>
  $(document).ready(function(){
    $(".iframe").colorbox({iframe:true, innerWidth:505, innerHeight:170});
  });
</script>
	
<style type="text/css">
.ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}
	</style>
	<SCRIPT type="text/javascript">
		<!--
		var setting = {
			view: {
				// addHoverDom: addHoverDom,
				removeHoverDom: removeHoverDom,
				selectedMulti: false
			},
			edit: {
				enable: true,
				editNameSelectAll: true
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeDrag: beforeDrag,
				beforeEditName: beforeEditName,
				beforeRemove: beforeRemove,
				beforeRename: beforeRename,
				onRemove: onRemove,
				onRename: onRename
			}
		};

		var zNodes =[
		 <?php 
		 foreach($groups as $key => $value){ 
			    echo '{ id:'.$value['id'].', pId:0, name:"'.$value['name'].'", open:true, isHover: true, icon:"/resource/images/group.gif"},';
		 }
		 ?>			
		];
		var log, className = "dark";
		
		function beforeDrag(treeId, treeNodes) {
			return false;
		}
		
		function beforeEditName(treeId, treeNode) {
			className = (className === "dark" ? "":"dark");
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.selectNode(treeNode);
			//return confirm("进入节点 -- " + treeNode.name + " 的编辑状态吗？");
		 return true;
		}
		
		function beforeRemove(treeId, treeNode) {
      $.post('/ucenter_user_contact/group_del', {id:treeNode.id}, function(data){
          if('false' == data){
              alert('此分组下有联系人，不能删除');
              return false;
          }else{
              return true;
          }
      });
		}
		
		function onRemove(e, treeId, treeNode) {
		}
		
		function beforeRename(treeId, treeNode, newName) {
			className = (className === "dark" ? "":"dark");
			if (newName.length == 0) {
				alert("分组名称不能为空.");
				var zTree = $.fn.zTree.getZTreeObj("treeDemo");
				setTimeout(function(){zTree.editName(treeNode)}, 10);
				return false;
			}
			return true;
		}
		
		function onRename(e, treeId, treeNode) {
      $.post('/ucenter_user_contact/group_edit', {id:treeNode.id, name:treeNode.name}, function(data){
          
      });
		}

		function getTime() {
			var now= new Date(),
			h=now.getHours(),		m=now.getMinutes(),
			s=now.getSeconds(),
			ms=now.getMilliseconds();
			return (h+":"+m+":"+s+ " " +ms);
		}

		var newCount = 1;
		function addHoverDom(treeId, treeNode) {
			var sObj = $("#" + treeNode.tId + "_span");
			if (treeNode.editNameFlag || $("#addBtn_"+treeNode.id).length>0) return;
			var addStr = "<span class='button add' id='addBtn_" + treeNode.id
				+ "' title='add node' onfocus='this.blur();'></span>";
			sObj.after(addStr);
			var btn = $("#addBtn_"+treeNode.id);
			if (btn) btn.bind("click", function(){
				var zTree = $.fn.zTree.getZTreeObj("treeDemo");
				zTree.addNodes(treeNode, {id:(100 + newCount), pId:treeNode.id, name:"new node" + (newCount++)});
				return false;
			});
		};
		
		function removeHoverDom(treeId, treeNode) {
			$("#addBtn_"+treeNode.id).unbind().remove();
		};
		
		function selectAll() {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.setting.edit.editNameSelectAll =  $("#selectAll").attr("checked");
		}
		
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			$("#selectAll").bind("click", selectAll);
		});
		//-->
	</SCRIPT>
	
