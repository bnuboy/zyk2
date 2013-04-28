<?php

class vars
{
  var $CI;

  function vars()
  {
    $this->CI = & get_instance();
    $variable = array();


    $variable[ 'USER_TYPE' ] = array('teacher' => '教师', 'student' => '学生', 'worker' => '工作人员', 'manager' => '前台管理员', 'assistant' => '助教', 'enterprise' => '企业', 'outsideteacher' => '校外教师', 'patriarch' => '家长', 'headmaster' => '校长');

    $variable[ 'ARTICLE_STATUS' ] = array('publish' => '发布', 'draft' => '草稿', 'waitpublish' => '待发布', 'cancel' => '发布失败');
    $variable[ 'RESOURCE_STATUS' ] = array('wait' => '未审核', 'succeed' => '已发布', 'fail' => '审核失败');
    $variable[ 'MESSAGE_STATUS' ] = array('normal' => '未读', 'read' => '已读');
    $variable[ 'PUBLICNOTICE_LEVEL' ] = array('high' => '高', 'medium' => '中', 'low' => '低');
    $variable[ 'ENABLED' ] = array('y' => '可用', 'n' => '禁用');
    $variable[ 'POST_STATUS' ] = array('normal' => '发布', 'delete' => '删除', 'lock' => '锁定', 'recover' => '回收站');
    $variable[ 'RESOURCE_MENU_TYPE' ] = array('atricle' => '文章', 'atricle_cat' => '文章分类', 'inner_url' => '内部链接', 'resource' => '资源', 'resource_cat' => '资源分类', 'url' => '地址');
    $variable[ 'PARTICIPATION_TYPE' ] = array('casual' => '事假', 'sick' => '病假', 'late' => '迟到', 'early' => "早退", "nowork" => '旷工', "tolerance" => '公出');
    $variable[ 'PROJECT_STATUS' ] = array('notdone' => '未开始', 'underway' => '进行中', 'finish' => '完成');
    $variable[ 'CALENDER_STATUS' ] = array('work' => '进行中', 'wait' => '未处理', 'fail' => '未完成', 'succeed' => '完成');
    $variable[ 'GENDER' ] = array('m' => '男', 'f' => '女');
    $variable[ 'STUDENT_STATUS' ] = array('school' => '在校', 'train' => '实训中', 'sign' => '签约', 'graduate' => '毕业');
    $variable[ 'USER_ROLE' ] = array('teacher' => '教师', 'student' => '学生', 'assistant' => '助教', 'enterprise' => '企业', 'outsideteacher' => '校外教师', 'patriarch' => '家长', 'headmaster' => '校长');
    $variable[ 'QUESTION_STATUS' ] = array('wait' => '未处理', 'reply' => '已处理', 'del' => "已删除");
    $variable[ 'TRAIN_SUM_STATUS' ] = array('wait' => '未审核', 'success' => '已审核','fail'=>'审核失败');
    $variable['INFORM'] = array('1'=>'学校通知','2'=>'院系通知');
    $variable['SELECT_COURSE_STATUS']=array('wait'=>'申请中','audit'=>'审核通过');
    $variable['LOAD_COURSE_FILE']=array('1'=>'课程公告','2'=>'班级','3'=>"在线答疑",'4'=>"学习资料",'5'=>"课程内容");
    $variable['HARDER'] =array('1'=>0.1,'2'=>0.2,'3'=>0.3,'4'=>0.4,'5'=>0.5);
    $variable['WORK_TYPE']=array('1'=>'手动布置','2'=>'自动布置','3'=>'上传附件');
    $variable['PIYUE']=array('y'=>'已批阅','n'=>'未批阅');
    $variable['GOODWORK']=array('y'=>'取消','n'=>'设为优秀作业');
    $variable['PATTERN'] = array('单选题'=>'danxuan','多选题'=>'duoxuan','填空题'=>'tiankong','完形填空'=>'wanxingtiankong','匹配题'=>'pipei','阅读理解'=>'yuedulijie','问答题'=>'wenda');
    $variable['HTML_BLOCK'] = array(
        'footer' => '<img src="/resource/images/hnf.png" /><span>Copyright&nbsp;©&nbsp;'.date('Y', time()).'</span>&nbsp;北京财贸大学&nbsp;&nbsp;地址:XXX路XXX号 </span>',
    	'title'  => '北京财贸大赛管理系统'
    );
    $this->CI->load->vars( $variable );
  }

}
?>
