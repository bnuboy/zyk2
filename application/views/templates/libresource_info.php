<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="/resource/css/center.css" rel="stylesheet" />
    <link type="text/css" href="/resource/css/center_data.css" rel="stylesheet" />
    <link type="text/css" href="/resource/css/expand.css" rel="stylesheet" />
    <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/resource/js/common.js"></script>

    <!--树形 start-->
   	<link rel="stylesheet" href="/resource/js/ztreev3.3/css/zTreeStyle/zTreeStyle.css" type="text/css">
   	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery-1.4.4.min.js"></script>
   	<script type="text/javascript" src="/resource/js/ztreev3.3/js/jquery.ztree.core-3.3.js"></script>
    <!--树形 end-->
     <title><?=$HTML_BLOCK['title'];?></title>
     
	<SCRIPT type="text/javascript">
		<!--
                
		var setting = {
			view: {
				dblClickExpand: false,
				showLine: true,
				showIcon: true
                               
                                
			},
			data: {
				simpleData: {
					enable: true
                                       
				}
			},  
			callback: {
				onClick: onClick
                              //onCollapse: zTreeOnCollapse
			}
		};
<?php $str = "";
		 foreach($cats as $key => $value){ 
			    $str .= '{ id:'.$value['id'].', pId:'.$value['f_id'].', name:"'.$value['name'].'", open:true, url:"/libresource/infolist/'.$library['id'].'/'.$value['id'].'", target:"_self" , isHover: true,open:false}';
                            if(($key+1) < count($cats)) $str .= ",";
                 }
                 
		 ?>
		var zNodes =[<?=$str?>];

		function onClick(e,treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			zTree.expandNode(treeNode);
                        //zTree.hideNodes(zTree.getNodes());
                        
		}

		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
                        var treeObj = $.fn.zTree.getZTreeObj("treeDemo");

		});
                
               
		//-->
	</SCRIPT>
	<style type="text/css">
.ztree li button.switch {visibility:hidden; width:1px;}
.ztree li button.switch.roots_docu {visibility:visible; width:16px;}
.ztree li button.switch.center_docu {visibility:visible; width:16px;}
.ztree li button.switch.bottom_docu {visibility:visible; width:16px;}
	</style>
	
  </head>

<body>
  <!--头部-->
  <div class="p_topbg">
   <div class="p_topp">
       <div class="logoimg">
          <img src="/resource/images/logoweb.jpg">
        </div>
    <div class="adminnotice">
      <?=$user['name']?>(<?=$USER_TYPE[$user['type']]?>)&nbsp;&nbsp;<?php $date=date('G');
      if ($date<11) echo '早上好';
      else if ($date<13) echo '中午好';
      else if ($date<17) echo '下午好';
      else echo '晚上好';?>!&nbsp;&nbsp;
      <a href="/index/logout" title="退出">退出</a>
    </div>   
  </div> 
  </div>
  <!--头部 end-->
  <!--全站导航-->
   <div class="ravboxbg">
    <div class="ravbox">
      <?= $modules['libresource_menus']; ?>
    </div>
   </div>
    <!--全站导航 end-->

    <!--中间内容-->
    <div class="counter counterborder">
     <div class="centerboxbg" style="margin-bottom:0;">

        <!--管理信息-->
        <div class="resourbox">
          <div class="writeaddtit">
            <div class="resourdatalink">
               <b><a href="/libresource/infolist/<?=$library['id'];?>">参考资料[<?=$library['name'];?>]列表</a></b>
               <?php 
               foreach($catnav as $k => $v){ 
                   echo " > <a href='/libresource/infolist/".$library['id']."/".$v['id']."'>".$v['name']."</a>";
               } 
               ?>
            </div>
            <div class="resourdataback"><a href="/libresource">返回参考资料</a></div>
          </div>

          <div class="resourdatabox">
            <div class="resourdlbox" style="display:none">
              <div class="resourdtit">
                <h1><img src="/resource/images/resour.gif" />分类目录</h1>
              </div>
              <div style="display:none">
                <ul id="treeDemo" class="ztree"></ul>
              </div>
            </div>
            <?= $component ?>
          </div>
          <div class="clear"></div>
        </div>
       </div>
      </div>
        <!--中间内容 end-->

        <!--底部 -->
        <div class="footbg">
         <div class="footer"><?=$HTML_BLOCK['footer'];?></div>
        </div>
        <!--底部  end-->
        </body>
        </html>
