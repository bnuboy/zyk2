<?php
include_once '_studyController.php';

class Study_Question_Bank extends StudyController
{
    public $abc_array = Array(
        'A', 'B', 'C', 'D', 'F',
        'G', 'H', 'I', 'J', 'K', 
        'L', 'M', 'N', 'O', 'P', 
        'Q', 'R', 'S', 'T', 'U', 
        'V', 'W', 'X', 'Y', 'Z'
   );

    function __construct()
    {
        parent::__construct();
        $this->load->model( 'Study_Question_Bank_Model' );
        $this->load->model( 'Study_Pattern_Model' );
    }

    /**
     * 默认列表
     */
    function index($start=0)
    {
        //参数初始化
        $ids ='';
        $typename='';
        $petterntypeid =''
;        $limit=10;
        $where=array();
        if($_GET)
        {
            $where['gz_study_patterntype.id'] = $_GET['id'];
        }else{
             $where['gz_study_patterntype.id'] = 1;
        }          
        $info = $this->Study_Question_Bank_Model->get_info($where);
       //ids 题库id ,typename 题型名称
       foreach($info as $key=>$val)
       {
           $ids .=$val['id'].",";
           $typename=$val['name'];
           $petterntypeid =$val['patterntype_id'];
       }
        $ids = substr($ids, 0,  strlen($ids)-1);
        if($ids){
            if($typename=='单选题')
                {
                   $list = $this->Study_Question_Bank_Model->get_shiti('tixing_id in ('.$ids.")",$limit,$start,'gz_study_shiti_danxuan');
                }
                elseif($typename=='多选题')
                {
                    $list = $this->Study_Question_Bank_Model->get_shiti('tixing_id in ('.$ids.")",$limit,$start,'gz_study_shiti_duoxuan');
                }
                elseif ($typename=='问答题')
                {
                    $list = $this->Study_Question_Bank_Model->get_shiti('tixing_id in ('.$ids.")",$limit,$start,'gz_study_shiti_wenda');
                }
                elseif ($typename=='填空题')
                {
                    $list = $this->Study_Question_Bank_Model->get_shiti('tixing_id in ('.$ids.")",$limit,$start,'gz_study_shiti_tiankong');
                    foreach($list as $key=>$val){
                        $list[$key]['title'] = unserialize($val['title']);
                    }
                }
                elseif ($typename=='完形填空')
                {
                    $list = $this->Study_Question_Bank_Model->get_shiti('tixing_id in ('.$ids.")",$limit,$start,'gz_study_shiti_wanxingtiankong');
                     foreach($list as $key=>$val){
                        $list[$key]['title'] = unserialize($val['title']);
                    }
                }
                elseif ($typename=='匹配题')
                {
                    $list = $this->Study_Question_Bank_Model->get_shiti('tixing_id in ('.$ids.")",$limit,$start,'gz_study_shiti_pipei');
                }
                elseif ($typename=='阅读理解')
                {
                    $list = $this->Study_Question_Bank_Model->get_shiti('tixing_id in ('.$ids.")",$limit,$start,'gz_study_shiti_yuedulijie');
                }
        }else{
            $list=array();
        } 
        
        $pattern_type = $this->Study_Pattern_Model->get_pattern_type();
        $result = array(
            'list'          => $list,
            'pattern_type'  => $pattern_type,
            'get'           => $_GET,
            'patterntype_id'=> $petterntypeid
        );
        $this->setComponent( 'study_questionbank',$result );
        $this->showTemplate( 'study_base' );
    }

    /**
     * 选择基本类型
     */
    function check()
    {
        //获取基本类型列表
        $list = $this->Study_Pattern_Model->get_pattern_type();
        //构造返回数据
        $result = array(
            'list'=>$list
        );
        $this->setComponent('select_patterntype',$result);
        $this->showTemplate('study_base');
    }
    /**
     * 按照基本类型来进入添加页面
     */
    function select_type($id)
    { 
        $name = $_GET['name'];
        $typename='';
        switch ($name)
        {
            case '单选题' :
                $typename='danxuan';
                break;
            case '多选题' :               
                $typename='duoxuan';             
                break;
            case '问答题' :              
                $typename='wenda';
                break;
            case '填空题' :
                $typename='tiankong';
                break;
            case '完形填空':
                $typename='wanxingtiankong';
                break;
            case '阅读理解':
                $typename='yuedulijie';
                break;
            case '匹配题':
                $typename='pipei';
                break;
            default:
                $typename='danxuan';
                break;
        }     
        $pattern = $this->Study_Pattern_Model->getAll('patternType_id = '.$id,'*','id desc');
        $result = array(
            'patternType_id'   => $id,
            'pattern'          => $pattern,
            'data'             => $this->abc_array
        );     
        $this->setComponent($typename.'_data',$result);
        $this->showTemplate('study_base');
    }
   
    /**
     * 添加单选题
     */
    function danxuan_add()
    {
        if($_POST)
        {
            if($_POST['subject_id'])
                $_POST['subject_id'] = serialize ( $_POST['subject_id']);        
        }
        
        $this->Study_Question_Bank_Model->danxuan_insert($_POST);
        Util::redirect('/study_question_bank/index');
    }
    /**
     * 添加多选题
     */
    function duoxuan_add()
    {
        if($_POST)
        {
            //参数初始化
            $_POST['answer']='';
            //获取，处理数据
            if($_POST['subject_id'])
                $_POST['subject_id'] = serialize ( $_POST['subject_id']);  
            
            foreach ($_POST['daan'] as $key=>$val)
            {
                $_POST['answer'] .= $val.',';
            }
            $_POST['answer'] = substr($_POST['answer'], 0,  strlen($_POST['answer'])-1);
        }    
        $this->Study_Question_Bank_Model->duoxuan_insert($_POST);
        Util::redirect('/study_question_bank/index');
    }
     /**
     * 添加问答题
     */
    function wenda_add()
    {        
        $this->Study_Question_Bank_Model->wenda_insert($_POST);
        Util::redirect('/study_question_bank/index');
    }
    /**
     * 添加完形填空
     */
    
    function wanxingtiankong()
    {
        if($_POST)
        {
            //print_r($_POST);die();
            $_POST['title'] = serialize($_POST['title']);
            $_POST['daan']  = serialize($_POST['daan']);
            $_POST['timu']  = serialize($_POST['timu']);
        }
        $this->Study_Question_Bank_Model->wanxingtiankong_insert($_POST);
        Util::redirect('/study_question_bank/index');
    }
    /**
     * 添加填空
     */
    function tiankong()
    {
         if($_POST)
         {
             $_POST['title'] = serialize($_POST['title']);
             $_POST['daan'] = serialize($_POST['daan']);
         }       
         $this->Study_Question_Bank_Model->tiankong_insert($_POST);
         Util::redirect('/study_question_bank/index');
    }
    /**
     * 添加匹配
     */
    
    function pipei()
    {
        if($_POST)
        {
            $_POST['xuanxiang'] = serialize($_POST['xuanxiang']); 
            $_POST['timu']      = serialize($_POST['timu']);
            $_POST['daan']      = serialize($_POST['daan']);
        }  
        $this->Study_Question_Bank_Model->pipei_insert($_POST);
        Util::redirect('/study_question_bank/index');
    }
    /**
     * 添加阅读理解
     */
    function yuedulijie()
    { 
        //print_r($_POST);die();
         if($_POST)
          {
             $_POST['daan']   = serialize($_POST['daan']); 
             $_POST['tigan']  = serialize($_POST['tigan']);
             $_POST['answer'] = serialize($_POST['answer']);
          }
         
        $this->Study_Question_Bank_Model->yuedulijie_insert($_POST);
        Util::redirect('/study_question_bank/index');
    }
    
    function edit($patterntype_id,$id)
    {
       $typename='';
         $info = $this->Study_Question_Bank_Model->get_info(array('gz_study_patterntype.id'=>$patterntype_id));
       //ids 题库id ,typename 题型名称
       foreach($info as $key=>$val)
       {         
           $typename=$val['name'];           
       }
       switch ($typename)
        {
            case '单选题' :
                $this->edit_danxuan($patterntype_id, $id);
                break;
            case '多选题' :               
                 $this->edit_duoxuan($patterntype_id, $id);          
                break;
            case '问答题' :              
                $this->edit_wenda($patterntype_id, $id);  
                break;
            case '填空题' :
                $this->edit_tiankong($patterntype_id, $id);  
                break;
            case '完形填空':
                $this->edit_wanxingtiankong($patterntype_id, $id);  
                break;
            case '阅读理解':
                $this->edit_yuedulijie($patterntype_id, $id);  
                break;
            case '匹配题':
                $this->edit_pipei($patterntype_id, $id);  
                break;
            default:
                $this->edit_danxuan($patterntype_id, $id);  
                break;
        }     
    }
    /**
     * 单选修改试题
     */
    function edit_danxuan($patterntype_id,$id)
    {
        if($_POST)
        {
            if($_POST['subject_id'])
                $_POST['subject_id'] = serialize ( $_POST['subject_id']); 
            $this->Study_Question_Bank_Model->update_danxuan($_POST,array('id'=>$id));
            Util::redirect('/study_question_bank/index');
        }
        $info = $this->Study_Question_Bank_Model->get_danxuan_info(array('id'=>$id));       
        $pattern = $this->Study_Pattern_Model->getAll('patternType_id = '.$patterntype_id,'*','id desc');      
        $result = Array(
            'info'          => $info,
            'pattern'       => $pattern,
            'patterntype_id'=> $patterntype_id,
            'abc_array'     => $this->abc_array
        );
        $this->setComponent('danxuan_edit',$result);
        $this->showTemplate('study_base');
    }
    /**
     * 多选修改试题
     */
    function edit_duoxuan($patterntype_id,$id)
    {
        if($_POST)
        {
             $_POST['daan']   = serialize($_POST['daan']); 
             $_POST['tigan']  = serialize($_POST['tigan']);
             $_POST['answer'] = serialize($_POST['answer']);
                        
            $this->Study_Question_Bank_Model->update_duoxuan($_POST,array('id'=>$id));
            Util::redirect('/study_question_bank/index?id='.$patterntype_id);
        }
        $info = $this->Study_Question_Bank_Model->get_duoxuan_info(array('id'=>$id));       
        $pattern = $this->Study_Pattern_Model->getAll('patternType_id = '.$patterntype_id,'*','id desc');      
        $result = Array(
            'info'          => $info,
            'pattern'       => $pattern,
            'patterntype_id'=> $patterntype_id,
            'abc_array'     => $this->abc_array
        );
        $this->setComponent('duoxuan_edit',$result);
        $this->showTemplate('study_base');
    }
     /**
     * 填空修改试题
     */
    function edit_tiankong($patterntype_id,$id)
    {
        if($_POST)
        {  
             $_POST['title'] = serialize($_POST['title']);
             $_POST['daan'] = serialize($_POST['daan']);     
                        
            $this->Study_Question_Bank_Model->update_tiankong($_POST,array('id'=>$id));
            Util::redirect('/study_question_bank/index?id='.$patterntype_id);
        }
        $info = $this->Study_Question_Bank_Model->get_tiankong_info(array('id'=>$id));       
        $pattern = $this->Study_Pattern_Model->getAll('patternType_id = '.$patterntype_id,'*','id desc');      
        $result = Array(
            'info'          => $info,
            'pattern'       => $pattern,
            'patterntype_id'=> $patterntype_id,
            'abc_array'     => $this->abc_array
        );
        $this->setComponent('tiankong_edit',$result);
        $this->showTemplate('study_base');
    }
     /**
     * 问答修改试题
     */
    function edit_wenda($patterntype_id,$id)
    {
        if($_POST)
        {             
            $this->Study_Question_Bank_Model->update_wenda($_POST,array('id'=>$id));
            Util::redirect('/study_question_bank/index?id='.$patterntype_id);
        }
        $info = $this->Study_Question_Bank_Model->get_wenda_info(array('id'=>$id));       
        $pattern = $this->Study_Pattern_Model->getAll('patternType_id = '.$patterntype_id,'*','id desc');      
        $result = Array(
            'info'          => $info,
            'pattern'       => $pattern,
            'patterntype_id'=> $patterntype_id         
        );
        $this->setComponent('wenda_edit',$result);
        $this->showTemplate('study_base');
    }
     /**
     * 完型填空修改试题
     */
    function edit_wanxingtiankong($patterntype_id,$id)
    {
        if($_POST)
        {    
            $_POST['title'] = serialize($_POST['title']);
            $_POST['daan']  = serialize($_POST['daan']);
            $_POST['timu']  = serialize($_POST['timu']);
            $this->Study_Question_Bank_Model->update_wanxingtiankong($_POST,array('id'=>$id));
            Util::redirect('/study_question_bank/index?id='.$patterntype_id);
        }
        $info = $this->Study_Question_Bank_Model->get_wanxingtiankong_info(array('id'=>$id));       
        $pattern = $this->Study_Pattern_Model->getAll('patternType_id = '.$patterntype_id,'*','id desc');      
        $result = Array(
            'info'          => $info,
            'pattern'       => $pattern,
            'patterntype_id'=> $patterntype_id,
            'abc_array'     => $this->abc_array
        );
        $this->setComponent('wanxingtiankong_edit',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     * 阅读理解修改试题
     */
    function edit_yuedulijie($patterntype_id,$id)
    {
        if($_POST)
        {    
            $_POST['daan']   = serialize($_POST['daan']); 
             $_POST['tigan']  = serialize($_POST['tigan']);
             $_POST['answer'] = serialize($_POST['answer']);
           
            $this->Study_Question_Bank_Model->update_yuedulijie($_POST,array('id'=>$id));
            Util::redirect('/study_question_bank/index?id='.$patterntype_id);
        }
        $info = $this->Study_Question_Bank_Model->get_yuedulijie_info(array('id'=>$id));       
        $pattern = $this->Study_Pattern_Model->getAll('patternType_id = '.$patterntype_id,'*','id desc'); 
       
        foreach(unserialize($info['timu']) as $key=>$val)
        {
            $info['timu_xuanxiang'][$key]['timu']=$val;
        }
         foreach(unserialize($info['xuanxiang']) as $key=>$val)
        {
            $info['timu_xuanxiang'][$key]['xuanxiang']=$val;
        }
     
        $result = Array(
            'info'          => $info,
            'pattern'       => $pattern,
            'patterntype_id'=> $patterntype_id,
            'abc_array'     => $this->abc_array
        );
        $this->setComponent('yuedulijie_edit',$result);
        $this->showTemplate('study_base');
    }
    
    /**
     * 修改匹配题
     */
    function edit_pipei($patterntype_id,$id)
    {
         if($_POST)
        {
            $_POST['xuanxiang'] = serialize($_POST['xuanxiang']); 
            $_POST['timu']      = serialize($_POST['timu']);
            $_POST['daan']      = serialize($_POST['daan']);
            $this->Study_Question_Bank_Model->update_pipei($_POST,array('id'=>$id));
            Util::redirect('/study_question_bank/index?id='.$patterntype_id);
        }   
         $info = $this->Study_Question_Bank_Model->get_pipei_info(array('id'=>$id));   
         foreach(unserialize($info['timu']) as $key=>$val)
         {
             $info['timu_daan'][$key][]=$val;
         }
         foreach(unserialize($info['xuanxiang']) as $key=>$val)
         {
             $info['timu_daan'][$key][]=$val;
         }
         
         $pattern = $this->Study_Pattern_Model->getAll('patternType_id = '.$patterntype_id,'*','id desc'); 
         $result = Array(
            'info'          => $info,
            'pattern'       => $pattern,
            'patterntype_id'=> $patterntype_id,
            'abc_array'     => $this->abc_array
        );
        $this->setComponent('pipei_edit',$result);
        $this->showTemplate('study_base');
    }
    
}
?>
