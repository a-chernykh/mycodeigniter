<?php

function is_logged_in()
{
  $CI =& get_instance();
  $user_id = $CI->session->userdata('user_id');
  return ($user_id !== FALSE);
}

function current_user()
{
  $CI =& get_instance();
  $user_id = $CI->session->userdata('user_id');
  if ($user_id !== FALSE);
  {
    if (empty($CI->user)) {
      $CI->user = $CI->User_model->find_by_id($user_id);
    }
    return !empty($CI->user) ? $CI->user : FALSE;
  }
}
