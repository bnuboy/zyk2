    <!--树形结构 带复选框-->
    <link rel="stylesheet" href="/resource/js/ztree/css/demo.css" type="text/css">
    <link rel="stylesheet" href="/resource/js/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="/resource/js/ztree/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/resource/js/ztree/js/jquery.ztree.core-3.1.js"></script>
    <script type="text/javascript" src="/resource/js/ztree/js/jquery.ztree.excheck-3.1.js"></script>
    <!--处理等待效果-->
    <script type="text/javascript" src="/resource/js/blockUI.js"></script>
    <script type="text/javascript" src="/resource/js/common.js"></script>
    <script type="text/javascript">
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
     <?php
     $str="";
		 foreach($nodes as $key => $value){
		     $checked = in_array($value['id'],$roleNodeIds) ? ', checked:true' : '';
			    $str.= '{ id:'.$value['id'].', pId:'.$value['f_id'].', name:"'.$value['name'].'", open:true '.$checked.'}';
          if(($key+1) < count($nodes)) $str .= ",";
     }
		 ?>
		var zNodes =[<?=$str?>];
		
    var code;

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
        loading("请稍等，正在分配权限......");
        var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
        var menus = treeObj.getCheckedNodes(true);
        var user_type =$("#user_type").val();
        $.post("/study_function_customized/index/"+user_type, {menus:menus}, function(data){
        $.unblockUI();
        alert("分配权限成功");
    });
    }

    //展开收起节点
    function setExpandAll(bool){
        var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
        treeObj.expandAll(bool);
    }
        function select_allc(id)
    {
        if( $("#select_all:checked").length == 0 ){
           $("#resousdata"+id+" input[type=checkbox]").attr("checked",false);
           }else{
            $("#resousdata"+id+" input[type=checkbox]").attr("checked","checked");
            }
    }

    function change_tab(obj)
    {
        var ids=$(".scHti").attr('id');
        $("#"+ids).attr("class","");
        var id=$(obj).parent().attr('id');
        $("#"+id).attr("class","scHti");
        $("#user_type").val(id);
    }
    -->
</script>
    <!--管理信息-->
    <div class="noticesbox">
    <div class="noticewarp">

    <div class="noticetit">
    <h1>功能定制</h1>
    </div>

    <div class="noticenwarp">
    <form action="/study_function_customized/edit" method="post">
        <div class="scTit">
        <?php foreach($roles_types as $type){?>
            <div id="<?=$type['id']?>" <?=$user_type==$type['id']?"class='scHti'":""?>>
                <a href="/study_function_customized/index/<?=$type['id']?>" onclick="change_tab(this)" ><?=$type['name']?></a>
            </div>
            <?php }?>
                <input type="hidden" name="user_type" id="user_type" value="<?=$user_type?>">
            </div>
        <div class="shenh2" style="hrighr:auto">

        <style>
        ul.ztree{width:400px;hight:200px};
        div.zTreeDemoBackground{width:400px;};
        </style>
        
            <table style="width:100%;padding-left:20px;">
                <tr>
                    <td style="width:70%;">
                    <div class="zTreeDemoBackground left">
                    <ul id="treeDemo" class="ztree"></ul>
                    </div>
                    </td>
                   <td style="width:30%;padding-right: 30px;">
                    <div>
                    <br><br><br><br>
                        <input style="cursor:pointer" type="button" class="bj_bt" onclick="setExpandAll(true);" value="展开全部节点"><br><br>
                        <input style="cursor:pointer" type="button" onclick="setExpandAll(false);" value="收起全部节点"><br><br>
                        <input style="cursor:pointer"  type="button" onclick="setMenuToGroup();" value="保存"><br><br>
                    </div>
                  </td>
                </tr>
            </table>
            
        </div>
        </form>
        </div>

        </div>
        </div>
