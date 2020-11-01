<?php

if (! function_exists('isLoggedIn')){
  function isLoggedIn(){
    $session_user = session()->get('users');
    if($session_user AND $session_user['isLoggedIn']){
      return true;
    }
    return false;
  }
}
