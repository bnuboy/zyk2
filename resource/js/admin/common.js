function search_input( obj ){
  $(obj).attr('value','');
  $(obj).attr('onclick','');
  $(obj).css('color','#000000')
  $( "#search_form" ).find("input[type=text]:last").attr('repeat_search','1');
}

function checkSearch( obj ){
  if( !$( obj ).find("input[type=text]:last").attr('repeat_search') ){
    search_input( $( obj ).find("input[type=text]:last") );
  }
}

function submitSearch(){
  $("#search_form").submit();
}