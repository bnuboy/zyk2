<?php
require_once 'pageclass_helper.php';

class mypage extends page{
 
    function mypage($array){
        parent::page($array);
        $this->first_page = 1;
        $this->next_page  = '';
        $this->pre_page   = '';
        $this->first_page = '首页';
        $this->last_page  = '末页';
        //$this->last_page  = $this->totalpage;
        $this->set('format_left','');
        $this->set('format_right','');
    }
    
    function showWeb_1(){
        $nav =  '';
        $nav .= '<script>' . "\n";
        $nav .= '  function jumppage(){' . "\n";
        $nav .= '  if(($("#pageinput").val() > '.$this->totalpage.') || ($("#pageinput").val() <= 0)) {' . "\n";
        $nav .= '      alert("请输入正确的页数");$("#pageinput").select()' . "\n";
        $nav .= '      return false;' . "\n";
        $nav .= '  }' . "\n";
        $nav .= '    jumpurl = "'.$this->url.'" + $("#pageinput").val();' . "\n";
        $nav .= '    location.href = jumpurl; ' . "\n";
        $nav .= '  }';
        $nav .= '</script>' . "\n";
        $nav .= '<div class="datapkate">' . "\n";
        $nav .= '  <div class="datajump">' . "\n";
        $nav .= '    <div class="datajumpin"><input class="page_input" id="pageinput" type="text" maxlength="4" value="'.$this->nowindex.'" onkeyup="value=value.replace(/[^\d]/g,\'\')" onbeforepaste="clipboardData.setData(\'text\',clipboardData.getData(\'text\').replace(/[^\d]/g,\'\'))"/></div>' . "\n";
        $nav .= '    <div class="datajumpbut"><input type="button" onclick="jumppage();" class="jumpcolor" value="转到"/></div>' . "\n";
        $nav .= '  </div>' . "\n";
        $nav .= '  <div class="pagenext">'.$this->next_page().'</div>' . "\n";
        if($this->totalpage >0)
        {
            $nav .= '  <div class="pagenum">'.$this->nowindex.'/'.$this->totalpage.'</div>' . "\n";
        }else{
            $nav .= '  <div class="pagenum">'.'0/'.$this->totalpage.'</div>' . "\n";
        }
        $nav .= '  <div class="pageup">'.$this->pre_page().'</div>' . "\n";
        $nav .= '  <div class="pagenum">'.$this->last_page().'</div>' . "\n";
        $nav .= '  <div class="pagenum">'.$this->first_page().'</div>' . "\n";
        $nav .= '</div>' . "\n";
        return $nav;
    }
    
    
    
    function showStyle_2(){
        $pagestr='<div class="pagenavi" id="lopage">';
        //$pagestr .= $this->first_page("curr");
        $pagestr .= $this->nowbar('','curr');
        //$pagestr .= $this->last_page("curr");
        $pagestr.='   (总计<span class="num">'.$this->totalpage.'</span>页, 共<span class="num">'.$this->totalresult.'</span>条记录) </div>';
        $pagestr.='</div>';
        return $pagestr;
    }
    
    function showStyle_web1(){
        $nav =  ''; 
        $nav .=      $this->show(6);
        return $nav;
    }
    
    function showAdmin_1(){
        $nav =  '';
        $nav .= '<script>' . "\n";
        $nav .= '  function jumppage(){' . "\n";
        $nav .= '  if(($("#pageinput").val() > '.$this->totalpage.') || ($("#pageinput").val() <= 0)) {' . "\n";
        $nav .= '      alert("请输入正确的页数");$("#pageinput").select()' . "\n";
        $nav .= '      return false;' . "\n";
        $nav .= '  }' . "\n";
        $nav .= '    jumpurl = "'.$this->url.'" + $("#pageinput").val();' . "\n";
        $nav .= '    location.href = jumpurl; ' . "\n";
        $nav .= '  }';
        $nav .= '</script>' . "\n";
        $nav .= '<div class="datapkate">' . "\n";
        $nav .= '  <div class="datajump">' . "\n";
        $nav .= '    <div class="datajumpin"><input class="page_input" id="pageinput" type="text" maxlength="4" value="'.$this->nowindex.'" onkeyup="value=value.replace(/[^\d]/g,\'\')" onbeforepaste="clipboardData.setData(\'text\',clipboardData.getData(\'text\').replace(/[^\d]/g,\'\'))"/></div>' . "\n";
        $nav .= '    <div class="datajumpbut"><input type="button" onclick="jumppage();" class="jumpcolor" value="转到"/></div>' . "\n";
        $nav .= '  </div>' . "\n";
        $nav .= '  <div class="pagenext">'.$this->next_page().'</div>' . "\n";
        $nav .= '  <div class="pagenum">'.$this->nowindex.'/'.$this->totalpage.'</div>' . "\n";
        $nav .= '  <div class="pageup">'.$this->pre_page().'</div>' . "\n";
        $nav .= '  <div class="pagenum">'.$this->last_page().'</div>' . "\n";
        $nav .= '  <div class="pagenum">'.$this->first_page().'</div>' . "\n";
        $nav .= '</div>' . "\n";
        return $nav;
    }
    
}
?>