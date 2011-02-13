<?php
function random_string($chars, $length)
{
  // Assign strings to variables
  $lc = 'abcdefghijklmnopqrstuvwxyz';
  $uc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $nr = '1234567890';
  
  // Set cases for our characters
  switch ($chars)
  {
    case 'lower': $chars = $lc; break;
    case 'upper': $chars = $uc; break;
    case 'chars': $chars = $lc.$uc; break;
    case 'numbers': $chars = $nr; break;
    case 'all': $chars = $lc.$uc.$nr; break;
  }
  
  // Length of character list
  $chars_length = (strlen($chars) - 1);
  // Start our string
  $string = $chars{rand(0, $chars_length)};
  // Generate random string
  for ($i = 1; $i < $length; $i = strlen($string))
  {
    // Take random character from our list
    $random = $chars{rand(0, $chars_length)};
    // Make sure the same two characters don't appear next to each other
    if ($random != $string{$i - 1})
    {
      $string .= $random;
    }
  }
  
  return $string;
}

