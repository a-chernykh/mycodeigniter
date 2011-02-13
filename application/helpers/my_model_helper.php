<?php
function to_mysql_date($ts)
{
  return date('Y-m-d h:i:s', $ts);
}