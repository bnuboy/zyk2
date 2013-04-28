<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" href="/resource/study/style/center.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/center_data.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/teacher.css" rel="stylesheet" />
        <link type="text/css" href="/resource/study/style/css.css" rel="stylesheet" />
        <link type="text/css" href="/resource/css/expand.css" rel="stylesheet" />
        <script type="text/javascript" src="/resource/js/jquery-1.7.1.min.js"></script>
        <title><?=$HTML_BLOCK['title'];?></title>


        </style>
    </head>
    <body>
        <!--头部-->
        <div class="p_topbg">   
        <div class="p_topp">
            <div style='float:left;margin-left:0px;margin-top:25px;'><img src="<?=$course['img']?>" width="62px" height="62px" align="absmiddle"/>
<span style="font-size: 30px;font-weight: bold;color: white;padding-left: 5px;"><?=$course['name']?></span></div>
            <div class="adminnotice"><?= $user[ 'name' ] ?>(<?= $USER_TYPE[ $user[ 'type' ] ] ?>)&nbsp;&nbsp;
                <?php
                $date = date( 'G' );
                if ( $date < 11 )
                    echo '早上好';
                else if ( $date < 13 )
                    echo '中午好';
                else if ( $date < 17 )
                    echo '下午好';
                else
                    echo '晚上好';
                ?>
                <a href="/ucenter_course/mycourseselect" title="进入个人中心">个人中心</a>
                &nbsp;&nbsp;<a href="/index/logout" title="退出">退出</a></div>
        </div>
       </div>
        <!--头部 end-->
        <!--全站导航-->
          <div class="ravboxbg">
            <div class="ravbox">
                <?= $modules[ 'study_menus' ]; ?>
            </div>
           </div>
            <!--全站导航 end-->

        <!--中间内容-->
        <div class="counter counterborder ">
            <div class="centerboxbg">
                <div class="centerboxbtm">

                    <!--左侧信息-->
                    <div class="centerleft">
                        <!--左侧导航-->
                        <div class="menubox">
                            <ul>
                                <li <?php if($this->uri->segment( 2 ) == 'add' || $this->uri->segment( 2 ) == 'index') echo "class='overadd'" ; ?>><a title="新建文件夹"  href="/study_coursecontent/add">新建文件夹</a></li>
                                <?php
                                //print_R($list);
                                foreach ( $list as $value )
                                {
                                    $cat = '';
                                    if ( isset( $id ) )
                                    {
                                        $current = $id == $value[ 'id' ] ? "class='over'" : "";
                                    }
                                    else
                                    {
                                        $current = "";
                                    }
                                    if ( $value[ 'cid' ] == 0 )
                                    {

                                        $cat.="<li " . $current . "><a href='/study_coursecontent/index/" . $value[ 'id' ] . "'>" . $value[ 'title' ] . "</a></li>";
                                    }
                                    else
                                    {
                                        $cat .= "<div class='menulist'>";

                                        $cat.="<a href='/study_coursecontent/index/" . $value[ 'id' ] . "' " . $current . "> " . $value[ 'tag' ] . $value[ 'title' ] . "</a>";
                                        if ( $value[ 'level' ] != 0 )
                                        {
                                            $cat .= '</div>';
                                        }
                                    }


                                    echo $cat;
                                }
                                ?>

                                
                            </ul>
                        </div>
                        <!--左侧导航 end-->
                    </div>
                    <!--左侧信息 end-->

                    <!--管理信息-->
                    <div class="noticesbox">
                        <?= $component ?>
                    </div>
                    <!--管理信息 end-->
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <!--中间内容 end-->

        <!--底部 -->
         <div class="footbg"><div class="footer"><?=$HTML_BLOCK['footer'];?></div></div>
        <!--底部  end-->

    </body>
</html>
