
<?php


 // SQL injection protection function - useful for logins

function mysql_entities_fix_string($string) {
    return htmlentities(mysql_fix_string($string));
}

 //html hack protection function - useful for text entry boxes

function mysql_fix_string($string) {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return mysql_real_escape_string($string);
}


// session_start(); 
//   // If the session vars aren't set, try to set them with a cookie
//   if (!isset($_SESSION['id'])) {
//     if (isset($_COOKIE['id']) && isset($_COOKIE['username'])) {
//       $_SESSION['id'] = $_COOKIE['id'];
//       $_SESSION['username'] = $_COOKIE['username'];
//     }
//   }

// function debug_to_console( $data ) {
//     $output = $data;
//     if ( is_array( $output ) )
//         $output = implode( ',', $output);

//     echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
// }



?>
