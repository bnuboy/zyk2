<?php

function compareTime($created) {
  $time=getdate(strtotime($created));
  $nowtime=getdate();
  //year
  if($nowtime['year']-$time['year']>0) {
    return $nowtime['year']-$time['year']."年前";
  }
  //month
  if($nowtime['mon']-$time['mon']>0) {
    return $nowtime['mon']-$time['mon']."月前";
  }
  //day
  if($nowtime['wday']-$time['wday']>0) {
    return $nowtime['wday']-$time['wday']."天前";
  }
  //hour
  if($nowtime['hours']-$time['hours']>0) {
    return $nowtime['hours']-$time['hours']."小时前";
  }
  //minute
  if($nowtime['minutes']-$time['minutes']>0) {
    return $nowtime['minutes']-$time['minutes']."分钟前";
  }

}

?>
