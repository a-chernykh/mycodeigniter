<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function form()
	{
	  $this->load->view('users/form', $this->view_data);
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */