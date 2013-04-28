<link type="text/css" href="/resource/css/center_data1.css" rel="stylesheet" />
<link type="text/css" href="/resource/css/webcss.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/resource/js/jquery-ui-1.8.18.custom.min.js"></script>
<script language="javascript" src="/resource/js/ui.base.min.js"></script>
<script language="javascript" src="/resource/js/ui.tabs.min.js"></script>
<script type="text/javascript" src="/resource/js/admin/common.js"></script>
<script language="javascript">
    function selected( )
    {
        if( $("#resousdata input[type=checkbox]:checked").length == 0 ){
            alert( "请至少选择一条记录" );
            return;
        }

        var enterprise_id = $("#resousdata input[type=checkbox]:checked").val();
       
        var enterprise_name = $("#resousdata input[type=checkbox]:checked").parent().parent().find("td:eq(1)").text();
        parent.addto_enterprise( enterprise_id,enterprise_name);
        parent.$('.iframe').colorbox.close();
        //window.close();
    }
    function oncheckbox( obj,cat_id,cat_name ){
        if( $(obj).attr("checked") == 'checked' ){
            if( $('#selected_cat label[cat_id='+cat_id+']').length )
                return ;
            // $('#cat_cb_'+cat_id).attr('checked','checked' );
            $('#selected_cat').append( '<label cat_id="'+cat_id+'" cat_name="'+cat_name+'" ><span onclick="deleteselect('+cat_id+')" >×</span>'+cat_name+'</label>' );
        }else{
            deleteselect( cat_id );
        }
    }

    function deleteselect( cat_id )
    {
        $('#selected_cat label[cat_id='+cat_id+']').remove();
    
        $('#cat_cb_'+cat_id).removeAttr('checked');
        
    }
  
    function submit(){
        var return_cats = new Array();
        $.each($('#selected_cat label'),function( key,obj ){
            var cat = new Object();
            cat['id'] = $(obj).attr('cat_id');
            cat['name'] = $(obj).attr('cat_name');
            return_cats.push( cat );
        })
       
        parent.get_zuopin(return_cats);
        
        parent.$('.iframe').colorbox.close();
    }
    function hite()
    {
         parent.$('.iframe').colorbox.close();
    }
</script>
<div class="noticesbox" style="width:484px;">
    <div class="noticewarp" style="width:484px;">
        <div class="noticetit dgxs-list" id="aj-tabs" style="width:484px;">
            <ul>
                <li >作品列表</li>
            </ul>
        </div>


        <div class="noticekatebox" style="width:484px;">
            <div class="notiness">共有作品<span><?= $count ?> 个</span></div>
        </div>

        <div class="eject-bottom" style="width:484px;">
            <form action="" method ="post" id="search_form" name="search_form">
                <div class="databox1" style="width:470px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20">&nbsp;</th>
                                <th width="100">作品名称</th>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            <?php foreach ( $list as $key => $val )
                            { ?>
                                <tr>
                                    <td><input type="checkbox" name ="item_id[]" value="<?= $val[ 'id' ] ?>" 
                                               onchange="oncheckbox(this,<?= $val[ 'id' ] ?>,'<?= $val[ 'name' ] ?>')" id='cat_cb_<?= $val[ 'id' ] ?>'
                                               <?php
                                               if ( !empty( $ids ) )
                                               {
                                                   if (in_array( $val[ 'id' ], $ids ))
                                                       echo "checked ='checked'";
                                               }
                                               ?>
                                               /></td>
                                    <td><?= $val[ 'name' ] ?></td>

                                </tr>       
<?php } ?>
                        </tbody>
                    </table>
                </div></form>
            <input type="submit" name="button" id="button" value="确认选择" class="save" onclick='return submit();'/>
            <input name="" type="button" value="取消" class="remove" onclick="return hite();" />

            <!--$pagination-->
            <div id='selected_cat'>
                <?php if(!empty ($class_attr)){
                    foreach ($class_attr as $key=>$val){
                       echo  ' <label cat_name="'.$val["name"].'" cat_id="'.$val["id"].'"><span onClick="deleteselect('.$val["id"].')">×</span>'.$val["name"].'</label>';
                    }  
                }?>
            </div>
        </div>

    </div>
</div>



