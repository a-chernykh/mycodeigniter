<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function signin()
	{
	  $this->load->view('users/signin', $this->view_data);
	}
	
	public function authenticate()
	{
	  if ($user = $this->User_model->authenticate($this->input->post('username_or_email'), $this->input->post('password')))
    {
      $this->session->set_userdata('user_id', $user->id);
      $this->session->set_flashdata('notice', 'Your successfully logged in.');
    } else {
      $this->session->set_flashdata('error', 'Wrong Username/Email and password combination.');
    }
    redirect('users/profile');
	}
	
	public function profile()
	{
	  $this->set('user', current_user());
    $this->load->view('users/profile', $this->view_data);
	}
	
	public function signout()
	{
    $this->session->unset_userdata('user_id');
	  redirect();
	}
	
	public function new_user()
	{
	  $this->load->view('users/new', $this->view_data);
	}
	
	public function create()
	{
	  if ($_POST)
		{
		  $stop = FALSE;
		  if ($this->config->item('users_captcha_enabled'))
			{
        $response = recaptcha_check_answer($this->config->item('recaptcha_private_key'),
                                      $this->input->server('REMOTE_ADDR'),
                                      $this->input->post('recaptcha_challenge_field'),
                                      $this->input->post('recaptcha_response_field'));
        if (!$response->is_valid) {
          $this->set('error', 'The reCAPTCHA wasn\'t entered correctly.');
          $stop = TRUE;
        }
			}
			if (!$stop)
			{
			  $this->load->library('form_validation');
        
        $this->form_validation->set_rules('reg_username', 'Username', 'trim|required');
        $this->form_validation->set_rules('reg_email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('reg_password', 'Password', 'trim|required');
        $this->form_validation->set_rules('reg_password_confirmation', 'Confirm Password', 'trim|required|matches[reg_password]');
        $this->form_validation->set_rules('reg_accept_terms', 'Accept terms and conditions', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
          $this->set('error', $this->form_validation->error_string());
        }
        else
        {
          $email = $this->input->post('reg_email');
          $username = $this->input->post('reg_username');
          
          if ($this->User_model->exists($email) || $this->User_model->exists($username)) {
            $this->set('error', 'User with the same username or email is exists.');
          } else {
            $data = array(
              'username' => $username,
              'email' => $email,
              'password' => $this->input->post('reg_password')
            );
            if ($this->config->item('users_verification_enabled') == FALSE) {
              $data['is_active'] = 1;
            }
            
            if ($user = $this->User_model->create($data))
            {
              // Authorize user automatically
              //$this->session->set_userdata('user_id', $user_id);
              
              $message = 'You successfull registered.';
              
              if ($this->config->item('users_verification_enabled'))
              {
                $message .= ' Verification code has been sent to your email.';
                
                // send email with activation code
                $this->load->library('email');
                $body = $this->load->view('users/verification_email', array('user' => $user), TRUE);
                
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                
                $this->email->from('do-not-reply@localhost', $this->config->item('app_title'));
                $this->email->to($user->email);
                $this->email->subject('Please verify your Account');
                $this->email->message($body);
                $this->email->send();
              }
              
              $this->session->set_flashdata('notice', $message);
              redirect();
              
            }
            
          }
        }
			}
      
		}
		
		$this->load->view('users/new', $this->view_data);
		
	}
	
	public function verify($email = null, $token = null)
	{
	  if ($_POST)
	  {
	    $email = $this->input->post('verification_email');
	    $token = $this->input->post('verification_token');
	  }
	  if (!empty($email) && !empty($token))
		{
	    $user = $this->User_model->find_first_by_email($email);
	    if (!empty($user))
	    {
	      if (!$user->is_active)
	      {
	        if ($token == $user->verification_token)
	        {
	          $user->activate();
	          $this->session->set_flashdata('notice', 'Your account has been successfully activated. You can now login below.');
	          $this->session->set_flashdata('activated', '1');
	          redirect('/users/signin');
	        } else {
	          $this->set('error', 'Wrong verification code.');
	        }
	      } else {
	        $this->session->set_flashdata('error', 'Your account already activated.');
	        redirect('/users/signin');
	      }
	    }
	  }
		
	  $this->load->view('users/verify', $this->view_data);
		
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */