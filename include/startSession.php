<?php 
  session_start(); 
  // If the session vars aren't set, try to set them with a cookie 
  if (!isset($_SESSION['id'])) { 
    if (isset($_COOKIE['id']) && isset($_COOKIE['username'])) { 
      $_SESSION['id'] = $_COOKIE['id']; 
      $_SESSION['username'] = $_COOKIE['username']; 
    } 
  } 
?>