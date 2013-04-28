<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script> 
<link type="text/css" href="/resource/colorbox/colorbox.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="/resource/js/jquery.validate.js" type="text/javascript"></script>
<script language="javascript" src="/resource/js/ui.base.min.js"></script>
<script language="javascript" src="/resource/js/ui.tabs.min.js"></script>
<script type="text/javascript" src="/resource/js/admin/common.js"></script> 
<link rel="stylesheet" href="/resource/css/jquery-ui.css" />
<link rel="stylesheet" href="/resource/js/ztreev3.3/css/demo.css" type="text/css" />
	<link rel="stylesheet" href="/resource/js/ztreev3.3/css/zTreeStyle/zTreeStyle.css" type="text/css">
	
	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.core-3.3.js"></script>
	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.excheck-3.3.js"></script>
<SCRIPT type="text/javascript">
		<!--
		var setting = {
			check: {
				enable: true,
				chkboxType: {"Y":"ps", "N":"ps"}
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

		var zNodes =[<?php  foreach ( $list as $key => $value )
        {
        $checked = !empty( $roleNodeIds ) && in_array( $value[ 'id' ], $roleNodeIds ) ? ', checked:true' : '';
        echo '{ id:' . $value[ 'id' ] . ', pId:' . $value[ 'cid' ] . ', name:"' . $value[ 'title' ] . '", open:true ' . $checked . '},';
        }
?>		
		 ];

		function beforeClick(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.checkNode(treeNode, !treeNode.checked, null, true);
			return false;
		}
		
		function onCheck(e, treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
			nodes = zTree.getCheckedNodes(true),
			v = "";
			for (var i=0, l=nodes.length; i<l; i++) {
				v += nodes[i].name + ",";
			}
			if (v.length > 0 ) v = v.substring(0, v.length-1);
			var cityObj = $("#citySel");
			cityObj.attr("value", v);
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
		});
		//-->
	</SCRIPT>
<script>
      $(function(){ 
    $( "#start_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', 
      changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
    $( "#end_time" ).datepicker({ dateFormat: 'yy-mm-dd 00:00:00',yearRange:'c-50:c+10', 
      changeYear: true,monthNames:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']});
  });
  
   function hite()
    {  
//        var ss =   $('#select_id input[type="checkbox"]:checked');
//        var id_attr='';
//        $.each(ss,function(key,val){
//            id_attr +=$(val).val()+',';
//        })
//        id_attr = id_attr.substr(0,id_attr.length-1);
//        $('#zj').val(id_attr);
    }
    function hite1()
    {
        var id_attr='';
                var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
                var menus = treeObj.getCheckedNodes(true);//console.log(menus);
                $.each(menus,function(key,obj){
                   id_attr+=obj.id+',';
               });
                id_attr = id_attr.substr(0,id_attr.length-1);
                $("#zhangjie").val(id_attr);
       if(!/^[0-9]*$/.test(($('#score').val())))
           {
                alert('总分请填写数字,并且不能有空格');
                return false;
           }
       if($('#zhangjie').val() =='')
        {    
            alert('请选择关联章节');
            return false; 
       }
       
        if($('#title').val()=='')
        {
            alert('请填写标题');
            return false;
        }
        if($('#score').val()==''  )
        {
            alert('请填写总分');
            return false;
        }
         if($('#end_time').val() < $('#start_time').val())
          {
            alert('时间格式不正确，请确保结束时间大于开始时间');
            return false;
          }
    }
    </script>

<!--管理信息-->
<div class="noticesbox kecheng">
    <div class="noticewarp">

        <div class="noticetit tearch-nav tearch-navts">
            <h1>附件作业</h1>           
        </div>

        <div class="noticenwarp">
            <form action="/study_homework/fujian_add" enctype="multipart/form-data" method="post" >
               
                <div class="noticekatebox">
                    <div class="addpword">类型：</div>
                    <div class="scselect" style="line-height: 32px;">
                       <input type="hidden" name="type_id" value="3" />
                            附件作业  
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">标题：</div>
                    <div class="addptit"><input name="title" type="text" id="title"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">总分：</div>
                    <div class="addptits"><input name="score" type="text" id="score"/></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpword">关联章节：</div>
                    <div class="scselect" id="select_id">
                        <input type="hidden" value="" name="zhangjie" id="zhangjie" />
                        <input id="citySel" type="text" readonly value="" style="width:120px; height:26px;" onclick="showMenu();" />
		&nbsp;<a id="menuBtn" href="#" onclick="showMenu(); return false;">select</a>                      
                        <div id="menuContent" class="menuContent" style="display:none; position: absolute;">
                            <ul id="treeDemo" class="ztree" style="margin-top:0; width:180px; height: 300px;"></ul>
                        </div>
                    </div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">时间：</div>
                    <div class="addptime"><input name="start_time" type="text" maxlength="15px" id="start_time"/></div>
                    <div class="addptimeshow"><a href="#"><strong>选择</strong></a></div>
                    <div class="addpnotwn">到　</div>
                    <div class="addptime"><input name="end_time" type="text" maxlength="15px" id="end_time"/></div>
                    <div class="addptimeshow"><a href="#"><strong>选择</strong></a></div>
                </div>
                <div class="noticekatebox">
                    <div class="addpwordn">附件：</div>  
                    <div style="line-height: 30px;">
          <input name="param" id="param" type="hidden" value=""/>
          <iframe style="border:0px;padding-bottom: 2px;" src="/Uploadfiles/uploadfileform?fileid=param&allowed_extensions=jpg|gif|remvb|flv|rm|mp4|doc|xls&overwrite=true&encrypt_name=true&uppath=/upload/study_homework/" width="400px" height="54px;">
          </iframe>
     </div>
                </div>

                <div class="noticekatebox" style="height:184px;">
                    <div class="addpwordn">内容：</div>
                    <div class="addpease"><textarea name="content"></textarea></div>
                </div>

                <div class="noticekatebox" id="sendbut" style="margin-top:10px;">
                    <div class="addbutdel"><input type="reset"  class="addbut" value="取消" /></div>
                    <div class="addbutin"><input type="submit"  class="addbut" value="发布" onClick="return hite1();"/></div>
                </div>

            </form>               
        </div>

    </div>
</div>
<!--管理信息 end-->