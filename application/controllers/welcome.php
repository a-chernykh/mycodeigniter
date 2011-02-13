<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
	  $user = $this->User_model->find_first_by_username('me');
	  $user->username = 'test';
	  $user->save();
		$this->load->view('index', $this->view_data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */