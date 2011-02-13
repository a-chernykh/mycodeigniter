<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model {
  protected $_table_name = 'users';
  
  public function create($data)
  {
    $salt = $this->salt($data['email']);
    $data['password_hash'] = $this->pass($data['password'], $salt);
    $data['password_salt'] = $salt;
    $data['verification_token'] = md5(random_string('chars', 8));
    $data['created_at'] = date("Y-m-d H:i:s", time());
    
    unset($data[$this->_primary_key]);
    unset($data['password']);
    
    $model = $this->load($data);
    $model->save();
    return $model;
  }
  
  public function exists($email_or_username)
  {
		$this->db->select('id');
		$this->db->from($this->_table_name);
		$this->db->where('(email="' . mysql_real_escape_string($email_or_username) . '" OR username="' . mysql_real_escape_string($email_or_username) . '")');
		$result =  $this->db->get();
		return ($result->num_rows() > 0);
  }
  
  public function authenticate($email_or_username, $password)
  {
    $user = $this->User_model->find_first_by_email($email_or_username);
    if (empty($user)) {
      $user = $this->User_model->find_first_by_username($email_or_username);
    }
    
    if (!empty($user)) {
      if ($user->get('password_hash') === $this->pass($password, $this->salt($user->email)))
      {
        return $user;
      }
    }
    
		return FALSE;
  }
  
	private function pass($string, $salt = SALT)
	{
		$string = sha1($string . $salt . SALT);
		return $string;
	}
	
	private function salt($email = '')
	{
		$salt = sha1($email . SALT);
		return substr($salt, 5, 10);
	}
  
}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */