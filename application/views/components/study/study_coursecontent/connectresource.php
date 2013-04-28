<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link rel="stylesheet" href="/resource/js/ztreev3.3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.core-3.3.js"></script>
<SCRIPT type="text/javascript">
    <!--
    var setting = {
        view: {
            dblClickExpand: false,
            showLine: true,
            showIcon: false
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
foreach ( $cats as $key => $value )
{
    echo '{ id:' . $value[ 'id' ] . ', pId:' . $value[ 'f_id' ] . ', name:"' . $value[ 'name' ] . '", open:true,isajaxing:true,target:"_self" , isHover: true},';
}
?>
    ];

    function onClick(e,treeId, treeNode) {
        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
        $.post("/study_coursecontent/getresource/"+treeNode.id,function(ret){
            if(ret.status=='ok'){
                $("#resousdata").empty();
                $.each(ret.data,function(key,obj){
                    $("#resousdata").append("<tr><td><input type='checkbox' name='item_id[]' value='"+obj.id+"' ></td><td>"+obj.name+"</td><td>"+obj.meta_keywords+"</td><td>"+obj.file_type+"</td><td>"+obj.file_size+"</td></tr>");
                });
            }
        },"json");
        zTree.expandNode(treeNode);
    }

    $(document).ready(function(){
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
           $.post("/study_coursecontent/getresource/<?php if(!empty($content_id))echo "?content_id=".$content_id;?>",function(ret){
            if(ret.status=='ok'){
                $("#resousdata").empty();
                var is_checked='';
                $.each(ret.data,function(key,obj){
                    if(obj.check=='1'){
                        is_checked="checked=''";
                    }else{
                        is_checked="";
                    }
                    $("#resousdata").append("<tr><td><input type='checkbox'"+is_checked+" name='item_id[]' value='"+obj.id+"' ></td><td>"+obj.name+"</td><td>"+obj.meta_keywords+"</td><td>"+obj.file_type+"</td><td>"+obj.file_size+"</td></tr>");
                });
            }
        },"json");
    });
    //-->
</SCRIPT>
<script type="text/javascript">
   function backsubmit(){
     var post_str =$("input:checkbox[type=checkbox]:checked'");
     var back='';
     $.each(post_str,function(key,obj){
         back+=$(obj).val()+",";
     });
     back=back.substring(0,back.length-1);
     parent.putdata(back);
     parent.$('.iframe').colorbox.close();
   }
</script>
<div class="counter boxShadow">



    <div class="centerboxbg" style="margin-bottom:0;">

        <!--管理信息-->
        <div class="resourbox">
            <div class="writeaddtit">
                <div class="resourdatalink">
                    <b><a href="/libresource/infolist/<?= $library[ 'id' ]; ?>">资源库[<?= $library[ 'name' ]; ?>]列表</a></b>
                    <?php
                    foreach ( $catnav as $k => $v )
                    {
                        echo " > <a href='/libresource/infolist/" . $library[ 'id' ] . "/" . $v[ 'id' ] . "'>" . $v[ 'name' ] . "</a>";
                    }
                    ?>
                </div>
                <div class="resourdataback"><a href="/libresource">返回资源中心</a></div>
            </div>

            <div class="resourdatabox">
                <div class="resourdlbox">
                    <div class="resourdtit">
                        <h1><img src="/resource/images/resour.gif" />分类目录</h1>
                    </div>
                    <div style="display:block">
                        <ul id="treeDemo" class="ztree"></ul>
                    </div>
                </div>
                <div class="resourrdbox">


                    <div class="resousdatarav">
                    </div>
                    <div class="databox1">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="8%">关联</th>                                
                                    <th width="25%">标题</th>
                                    <th width="15%">关键字</th>
                                    <th width="10%">格式</th>
                                    <th width="10%">大小(KB)</th>
                                </tr>
                            </thead>
                            <tbody id="resousdata">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div style="margin-top:10px;" id="sendbut" class="noticekatebox">
                <div class="addbutdel"><input type="button" value="取消" onclick="javascript:parent.$('.iframe').colorbox.close();" class="addbut"></div>
                <div class="addbutin"><input type="button" value="保存" onclick="backsubmit()" class="addbut"></div>
            </div>
            <div class="clear"></div>
        </div>

    </div>

    <div class="centerboxbtm1"></div>
    <div class="clear"></div>
</div>
<!--中间内容 end-->