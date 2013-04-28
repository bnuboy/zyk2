<!DOCTYPE html>
<HTML>
    <HEAD>
        <TITLE> 高等职业教育教学资源中心</TITLE>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/resource/js/ztreev3.3/css/demo.css" type="text/css">
        <link rel="stylesheet" href="/resource/js/ztreev3.3/css/zTreeStyle/zTreeStyle.css" type="text/css">
        <script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.core-3.3.js"></script>
        <script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.excheck-3.3.js"></script>
        <script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.exedit-3.3.js"></script>
        <link type="text/css" href="/resource/study/group/style/webcss.css" rel="stylesheet" />
        <SCRIPT type="text/javascript">
            <!--
            var setting = {
                view: {
                    dblClickExpand: false
                },
                check: {
                    enable: false
                },
                edit: {
                    enable: true,
                    showRemoveBtn: false,
                    showRenameBtn: true
                },
                data: {
                    simpleData: {
                        enable: true
                    },
                    keep: {
                        leaf: false,
                        parent: true
                    }
                },
                callback: {
                    beforeDrag: beforeDrag,
                    beforeDrop: beforeDrop,
                    onRightClick: OnRightClick,
                    beforeDrop: zTreeBeforeDrop
                }
            };

            var zNodes =[<?php
        foreach ( $student_info as $key => $value )
        {
        echo '{ id:' . $value[ 'id' ] . ', pId:0, name:"' . $value[ 'name' ] . '", open:true },';
        }
        ?>
            ];
            function zTreeBeforeDrop(treeId, treeNodes, targetNode, moveType) {
                return !(targetNode == null || (moveType != "inner" && !targetNode.parentTId )|| !targetNode.level=='0');
            };
            function beforeDrag(treeId, treeNodes) {
                for (var i=0,l=treeNodes.length; i<l; i++) {
                    if (treeNodes[i].drag === false) {
                        return false;
                    }
                }
                return true;
            }
            function beforeDrop(treeId, treeNodes, targetNode, moveType) {
                return targetNode ? targetNode.drop !== false : true;
            }

            var zNodes2 =[];
            function OnRightClick(event, treeId, treeNode) {
                if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
                    zTree.cancelSelectedNode();
                    showRMenu("root", event.clientX, event.clientY);
                } else if (treeNode && !treeNode.noR) {
                    zTree.selectNode(treeNode);
                    showRMenu("node", event.clientX, event.clientY);
                }
            }
            function showRMenu(type, x, y) {
                $("#rMenu ul").show();
                if (type=="root") {
                    $("#m_del").hide();
                    $("#m_check").hide();
                    $("#m_unCheck").hide();
                } else {
                    $("#m_del").show();
                    $("#m_check").show();
                    $("#m_unCheck").show();
                }
                rMenu.css({"top":y+"px", "left":x+"px", "visibility":"visible"});

                $("body").bind("mousedown", onBodyMouseDown);
            }
            function hideRMenu() {
                if (rMenu) rMenu.css({"visibility": "hidden"});
                $("body").unbind("mousedown", onBodyMouseDown);
            }
            function onBodyMouseDown(event){
                if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length>0)) {
                    rMenu.css({"visibility" : "hidden"});
                }
            }
            var addCount = 1;
            function addTreeNode() {
                hideRMenu();
                var treeObj = $.fn.zTree.getZTreeObj("treeDemo2");
                var newNode = { name:"分组" + (addCount++)};
                if (zTree.getSelectedNodes()[0]) {
                    alert("只能建简单的分组");
                } else {
                    zTree.addNodes(null, newNode);
                }
            }
            function removeTreeNode() {
                hideRMenu();
                var nodes = zTree.getSelectedNodes();
                if (nodes && nodes.length>0) {
                    if (nodes[0].children && nodes[0].children.length > 0) {
                        var msg = "要删除的小组吗！";
                        if (confirm(msg)==true){
                            zTree.removeNode(nodes[0]);
                        }
                    } else {
                        zTree.removeNode(nodes[0]);
                    }
                }
            }
            function checkTreeNode(checked) {
                var nodes = zTree.getSelectedNodes();
                if (nodes && nodes.length>0) {
                    zTree.checkNode(nodes[0], checked, true);
                }
                hideRMenu();
            }
            function resetTree() {
                hideRMenu();
                $.fn.zTree.init($("#treeDemo"), setting, zNodes);
                $.fn.zTree.init($("#treeDemo2"), setting, zNodes2);
            }

            var zTree, rMenu;
            $(document).ready(function(){
                $.fn.zTree.init($("#treeDemo"), setting, zNodes);
                $.fn.zTree.init($("#treeDemo2"), setting,zNodes2);
                zTree = $.fn.zTree.getZTreeObj("treeDemo2");
                rMenu = $("#rMenu");
            });

            //-->
        </SCRIPT>
        <script type="text/javascript">
            function returnsub(){
                var treeObj = $.fn.zTree.getZTreeObj("treeDemo2");
                var nodes = treeObj.getNodes();
                var group_name='';
                var data='';
                $.each(nodes,function(key,obj){
                   var student='';
                   group_name=obj.name;
                   if(obj.children!=undefined){
                   $.each(obj.children,function(k,o){
                       student+=o.id+',';
                   });
                   }
                   data+=group_name+"."+student+":";
                });
                parent.putdata(data);
                parent.$('.iframe').colorbox.close();
            }
            function clockwin(){
            parent.$('.iframe').colorbox.close();
             }
        </script>
        <style type="text/css">
            div#rMenu {position:absolute; visibility:hidden; top:0; background-color: #555;text-align: left;padding: 2px;}
            div#rMenu ul li{
                margin: 1px 0;
                padding: 0 5px;
                cursor: pointer;
                list-style: none outside none;
                background-color: #DFDFDF;
            }
        </style>
    </HEAD>

    <BODY>
        <h1>作品分组</h1>
        <div class="content_wrap">
            <div class="zTreeDemoBackground left">
                <ul id="treeDemo" class="ztree"></ul>
            </div>
            <div class="right">
                <ul id="treeDemo2" class="ztree"></ul>
            </div>
            <div id="rMenu">
                <ul>
                    <li id="m_add" onclick="addTreeNode();">增加节点</li>
                    <li id="m_del" onclick="removeTreeNode();">删除节点</li>
                    <li id="m_reset" onclick="resetTree();">清空分组</li>
                </ul>
            </div>

        </div>
        <div style="margin-top:20px">
            <p align="right">
                <input type="button" class="remove" onclick="clockwin()" value="取消" />
                <input type="button" class="save" onclick="returnsub()"value="确定" />
            </p>
        </div>

    </BODY>
</HTML>