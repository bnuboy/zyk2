<?php
class auth
{
  
	function auth()
	{
		$this->ci =& get_instance();
    $this->ci->load->helper('url');
    $this->ci->load->library('Session');
  }
  
	function is_admin_login()
	{
		return $this->ci->session->userdata('admin_login');
	}
}
?>
