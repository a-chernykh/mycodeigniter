<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
  static protected $defaulted_variables = array('title', 'meta_description', 'meta_keywords');
  
  protected $view_data = array();
  
	public function __construct()
	{
		parent::__construct();
		foreach(self::$defaulted_variables as $variable)
		{
  		if (!$this->get($variable))
  		{
  		  $this->set($variable, $this->config->item('app_' . $variable));
  		}
		}
	}
	
	/**
	 * Set the view variable in current scope
	 * @param string $key The variable name
	 * @param mixed $value The variable value
	 */
	protected function set($key, $value)
	{
	  $this->view_data[$key] = $value;
	}
	
	/**
	 * Get the view variable in current scope
	 * @param string $key The variable name
	 * @return The variable value
	 */
	protected function get($key)
	{
	  return !empty($this->view_data[$key]) ? $key : FALSE;
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */