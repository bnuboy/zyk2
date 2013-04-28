<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script>
  function checkform(){
      if($("#receverids").val() == ''){
          alert("请在右侧联系人列表选择收件人");
          return false;
      }else if($("#title").val() == ''){
          alert("请填写主题");
          $("#title").focus()
          return false;
      }else if($("#content").val() == ''){
          alert("请填写内容");
          $("#content").focus()
          return false;
      }
  }
</script>
<div class="writebox">
  <div class="writeadd">
    <div class="writeaddtit">
      <h1><img src="/resource/images/emailedit.gif" />写信</h1>
    </div>
    <form action="/ucenter_msg/msgadd" method="post" id="sub_form" onsubmit="return checkform();">
      <div class="writewordbox">
        <!--
        <div class="writewkate">
          <div class="writewname">&nbsp;</div>
          <div class="writewrin">
            <div class="addfileput"><a href="javascript:document.getElementById('message_form').submit();" onclick="send_status" id="send"title="发送">发送</a></div>
            <div class="addfileput" style="margin-left:10px;"><a href="javascript:draft()" id="save" title="存草稿">存草稿</a></div>
            <div class="addfileput" style="margin-left:10px;"><a href="#this"  onclick="javascript:history.go(-1);" title="取消">取消</a></div>
          </div>
        </div>
        -->

        <div class="writewkate">
          <div class="writewname">收件人</div>
          <div class="writewrin">
            <input type="text" name="recevernames" id="recevernames"  readonly=“true"/>
            <input type="hidden" name="receverids" id="receverids"/>
          </div>
        </div>

        <div class="writewkate">
          <div class="writewname">主&nbsp;&nbsp;&nbsp;题</div>
          <div class="writewrin">
            <input type="text" name="data[title]" id="title"/>
          </div>
        </div>

        <div class="writewkate">
          <div class="writewname" style="padding-top:20px;">内&nbsp;&nbsp;&nbsp;容</div>
          <div class="writewrin" style="height:247px;">
            <div class="writefile">
              <div class="writefilew"></div>
              <div class="writetext">
                <textarea name="data[content]" id="content"></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="noticekatebox" id="sendbut" style="margin-top:10px; height:60px; width:564px;">
          <div class="writebut"><input type="button"  value="取消" onclick="javascript:history.go(-1);"/></div>
          <!-- <div class="writebut"><input type="button" name="copy" value="存草稿" id="save" onclick="draft()"/></div> --> 
          <div class="writebut"><input type="submit" name="send" value="发送" id="send"/></div>
        </div>
    </form>
  </div>
</div>

<div class="writeaddr">
  <div class="writeaddtit">
    <h1><img src="/resource/images/group.gif" />联系人</h1>
  </div>

  <div class="writewordbox">
    <div id="contact_continer">
      <ul id="treeDemo" class="ztree"></ul>
    </div>
  </div>
</div>

<div class="writebto"></div>
</div>

<!--树形结构 带复选框-->
<link rel="stylesheet" href="/resource/js/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="/resource/js/ztree/js/jquery.ztree.core-3.1.js"></script>
<script type="text/javascript" src="/resource/js/ztree/js/jquery.ztree.excheck-3.1.js"></script>

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
			},
			callback: {
		   onCheck: zTreeOnCheck,
		   onClick: onClick
	  }
		};

		var zNodes =[
		 <?php 
			echo '{ id:0, pId:-1, name:"未分类", open:true, icon:"/resource/images/nessus.gif", nocheck:true},';
		 foreach($groups as $key => $value){ 
			    echo '{ id:'.$value['id'].', pId:-1, name:"'.$value['name'].'", open:true, icon:"/resource/images/nessus.gif", nocheck:true},';
		 }
		 foreach($contacts as $key => $value){ 
			    echo '{ id:'.$value['contact_group_id'].$value['id'].', pId:'.$value['contact_group_id'].', userid:'.$value['add_user_id'].',name:"'.$value['user']['name'].'", open:true, icon:"/resource/images/peo.gif"},';
		 }
		 ?>
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
		
		function zTreeOnCheck(){
      var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
      var obj = treeObj.getCheckedNodes(true);
      var names = "";
      var userids = "";
      for(i=0; i < obj.length; i++){
          names += obj[i].name + ';';
          userids += obj[i].userid;
          if(i+1 < obj.length){
              userids += ',';
          }
      }
      $("#recevernames").val(names);
      $("#receverids").val(userids);
		}
		
				function onClick(e,treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.expandNode(treeNode);
		}
		
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			setting.check.chkboxType = { "Y" : "ps", "N" : "ps" };
		});
		
		</SCRIPT>
	