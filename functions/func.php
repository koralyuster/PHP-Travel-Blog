<?php

function filter_post($_input_name, $_conn)
{
  // function that do filter and escaping for SQL Query in POST MODE
  $input = trim(filter_input(INPUT_POST, $_input_name, FILTER_SANITIZE_STRING));
  $input = mysqli_real_escape_string($_conn, $input);
  return $input;
}

//function for we cant write tags in the url:
function filter_get($_input_name, $_conn)
{
  // function that do filter and escaping for SQL Query in POST MODE
  $input = trim(filter_input(INPUT_GET, $_input_name, FILTER_SANITIZE_STRING));
  $input = mysqli_real_escape_string($_conn, $input);
  return $input;
}

// function that return to input
// of form the data that sended
// no matter if its post or get request
function old($val)
{
  return isset($_REQUEST[$val]) ? $_REQUEST[$val] : "";
}

//Errors function:
function showError($error_name, $error_ar)
{
  return isset($error_ar[$error_name]) ? $error_ar[$error_name] : "";
}

//function that verify the user in area that just signed user can be:
function user_verify()
{
  $verify = false;

  if (isset($_SESSION['user_id'])) {
    //check if the ip that save in the session is match to the current ip of the user:
    if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR']) {
      //check if the browser that keep in the session is match to the current browser of the user:
      if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT']) {
        //if they both correct will return true:
        $verify = true;
      }
    }
  }
  return $verify;
}
