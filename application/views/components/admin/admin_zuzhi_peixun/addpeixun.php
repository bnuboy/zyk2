<link type="text/css" href="/resource/css/index.css" rel="stylesheet" />
<style>
  .middlebox{padding:0 !important}
  .zuzhi_textarea{width:125px;height:50px;border:0;}
  td{background:#fff;}
  th{background:#fff;}
</style>
<script>
$(function(){
	$("#addrow").click(function(){
		var con = $("tbody tr").html();
		$("tbody").append("<tr>" + con + "</tr>");
	});
});
</script>
<div class="middlebox">
	<div class="noticetit">
    	<h1>培训组织</h1>
  	</div>
  	<div class="noticenwarp">
  	<form action="/admin_zuzhi_peixun/add" method="post">
  		<table bgcolor="#000;">
  			<thead>
  				<tr bgcolor="#fff">
  					<th>培训内容</th>
  					<th>培训单位</th>
  					<th>培训教师</th>
  					<th>参训人员</th>
  					<th>培训时间</th>
  					<th>培训地点</th>
  				</tr>
  			</thead>
  			<tbody bgcolor="#fff">
  				<tr>
  					<td><textarea name="content[]" class="zuzhi_textarea"></textarea></td>
  					<td><textarea name="danwei[]" class="zuzhi_textarea"></textarea></td>
  					<td><textarea name="jiaoshi[]" class="zuzhi_textarea"></textarea></td>
  					<td><textarea name="renyuan[]" class="zuzhi_textarea"></textarea></td>
  					<td><textarea name="shijian[]" class="zuzhi_textarea"></textarea></td>
  					<td><textarea name="didian[]" class="zuzhi_textarea"></textarea></td>
  				</tr>
  			</tbody>
  		</table>
  		<div class="noticekatebox" id="sendbut" style="margin-top:10px;">
        	<div class="addbutin"><input type="submit" class="addbut" value="保存" /></div>
        	<div class="addbutdel"><input id="addrow" type="button"  class="addbut" value="增加一行" /></div>
      	</div>
      	</form>
  	</div>
</div>