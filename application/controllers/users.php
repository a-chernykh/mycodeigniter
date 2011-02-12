<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function new_user()
	{
	  $this->load->view('users/new', $this->view_data);
	}
	
	public function create()
	{
	  
	}
	
	public function verify($token)
	{
	  
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */