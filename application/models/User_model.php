<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model {
  protected $table_name = 'users';
  
  public function __construct()
  {
    parent::__construct();
  }
}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */