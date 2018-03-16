<?php  
         require_once('include/connectvars.php'); 

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
      if (isset($_POST['submit'])) { 
    // Grab the profile data from the POST super global, while making sure no nasty inputs get through to the database 
        $username = mysqli_real_escape_string($dbc, trim($_POST['username'])); 
        $fname = mysqli_real_escape_string($dbc, trim($_POST['fname']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['password'])); 
        $cpassword = mysqli_real_escape_string($dbc, trim($_POST['cpassword'])); 
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        $registry_date = date('Y-m-d H:i:s');

    if (!empty($username) && !empty($password) && !empty($cpassword) && ($password == $cpassword)) { 
      // Make sure someone isn't already registered using this username 
      $query = "SELECT * FROM phptest WHERE username = '$username'"; 
      $data = mysqli_query($dbc, $query); 
      if (mysqli_num_rows($data) == 0) { 
        // The username is unique, so insert the data into the database 
        $query = "INSERT INTO phptest (username, password, registry_date, fname,  email ) VALUES ('$username', sha1('$password'), '$registry_date', '$fname',  '$email' )"; 
        mysqli_query($dbc, $query); 

       
        // Confirm success with the user, not forgetting to use slashes to escape the apostrophies in the English 
        echo '<div class="alert alert-success"><strong>Success!</strong> Your new account has been successfully created. </div>'; 

       // mysqli_close($dbc);    
      } 
      else { 
        // An account already exists for this username, so display an error message and persuade the minion to choose a different name 
        echo '<div class="alert alert-info"><strong>Info!</strong> An account already exists for this username. Please use a different username.</div>'; 
        $username = ""; 
      } 

    } 
    else {//another helpful message 
        echo '<div class="alert alert-warning"><strong>Warning!</strong> You must enter all of the sign-up data, including the desired password twice.</div>'; 
      } 
 
  } 
 mysqli_close($dbc); 
 
 ?> 