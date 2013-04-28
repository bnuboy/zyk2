<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
        <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
        <title>高等职业教育教学资源中心--个人中心</title>
        <script type="text/javascript">
          function submit( ){
                var id_attr='';
                var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
                var menus = treeObj.getCheckedNodes(true);//console.log(menus);
                $.each(menus,function(key,obj){
                   id_attr+=obj.id+',';
               });
                id_attr = id_attr.substr(0,id_attr.length-1);
                parent.addto(id_attr);
                parent.$(".iframe").colorbox.close();
              }
         </script>
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

    var zNodes =[ <?php
        foreach ( $list as $key => $value )
        {
        $checked = !empty( $relevance ) && in_array( $value[ 'id' ], $relevance ) ? ', checked:true' : '';
        echo '{ id:' . $value[ 'id' ] . ', pId:' . $value[ 'cid' ] . ', name:"' . $value[ 'title' ] . '", open:true ' . $checked . '},';
        }
    ?>
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
    </SCRIPT>
    </head>
    <body>
    <div class="pop">
            <div class="popTit">
                <span class="floatL">关联课程内容</span>
                <span class="floatR"></span>
            </div>
            <div class="shenh2" style="hrighr:auto;padding-left:20px;padding-bottom: 20px ">
                <style>
                ul.ztree{width:200px;hight:180px;padding-left: 20px}
                div.zTreeDemoBackground{width:400px;};
                </style>
                <div class="zTreeDemoBackground left">
                    <ul id="treeDemo" class="ztree"></ul>
                </div>
            </div>

            <div class="popDown">
                <span><a href="#this" onclick="windowclose()">取消</a></span>
                <div class="dataadd"><a href="javascript:;" onclick="return submit();" title="保存">保存</a></div>
            </div>
    </div>
</body>
</html>

<script language="javascript">
    function windowclose(){
        parent.$('.iframe').colorbox.close();
    }
</script>


