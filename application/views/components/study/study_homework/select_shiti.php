<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
<link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
<script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
<script>
    var ul_id =<?= json_encode( $ul_id);?>;
    var param =<?= json_encode( $param);?>;
    var tx_id =<?= json_encode($tx_id);?>;
    var zsd_id =<?=json_encode( $zsd_id);?>;
    var key_id =<?=json_encode( $k_id);?>;
   function select_all()
    {
        if( $("#select_all:checked").length == 0 ){
            $("#resousdata input[type=checkbox]").attr("checked",false);
        }else{
            $("#resousdata input[type=checkbox]").attr("checked","checked");
        }
    }
    function quxiao()
    {
         parent.$('.iframe').colorbox.close();
    }
    function addparent()
    {
        var count = $("#resousdata input[type=checkbox]:checked").length; 
        if(count==0)
            {
                alert('请选择后，在提交');
                return false;
            }
        parent.addtocat(ul_id,count,$("#resousdata input[type=checkbox]:checked"),param,tx_id,zsd_id,key_id);
        parent.$('.iframe').colorbox.close();
    }
    </script>
<title>高等职业教育教学资源中心--个人中心</title>

</head>
<body>
<div class="pop">
	<div class="popTit">
		<span class="floatL">选择题目</span>
		<span class="floatR"><a href="#">关闭</a></span>
	</div>
	<div class="popCont popCont2 popConts">
		<div class="popTis">
			<div class="dataediabox">
				<div class="ediacheck"><input type="checkbox" id="select_all" onChange="select_all();"/></div>
				<div class="ediacheckw">全选</div>
			</div>
			<div class="serchbox">
				<div class="serchninput"><input type="text" name="serch" value="" /></div>
				<div class="serchbut"><input type="button" id="serchadd" value="搜索" /></div>
			</div>
		</div>
<div class="databox" style="width:370px;padding:5px;">
                	<table width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="43">&nbsp;</th>
                                <th width="155">题干</th>
                                <th width="86">难度</th>
                                <th width="84">使用次数</th>
                            </tr>
                        </thead>
                        <tbody id="resousdata">
                            <?php foreach ($list as $key => $val) {?>
                            <tr>
                                <td><input type="checkbox" name="item_id[]" value="<?=$val['id']?>" <?php if(!empty($ids)&& strstr($ids,$val['id']) ){ echo 'checked';} ?>/></td>
                                <td><?= $val['title']?></td>
                                <td><?=$HARDER[$val['harder']]?></td>
                                <td>0</td>
                            </tr>
                           <?php }?>
                        </tbody>                
                    </table>
                </div>

	</div>
	<div class="popDown">
		<span><a href="javascript:;" onClick="quxiao();">取消</a></span>
		<div class="dataadd"><a href="javascript:;" title="确定" onClick="return addparent();">确定</a></div>
	</div>
</div>
</body>
</html>
