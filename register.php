
                  <?php
  //require_once("include/startSession.php");
  include 'include/header.inc.php';
  require_once("include/connectvars.php");

?>


<div class="container">
  <!-- Column for the login form -->
  <div class="col-sm">
    <!-- Form start -->
    <?php
require_once('include/connectvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (isset($_POST['submit'])) {
    // Grab the profile data from the POST super global, while making sure no nasty inputs get through to the database 
    $username      = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $fname         = mysqli_real_escape_string($dbc, trim($_POST['fname']));
    $password      = mysqli_real_escape_string($dbc, trim($_POST['password']));
    $cpassword     = mysqli_real_escape_string($dbc, trim($_POST['cpassword']));
    $email         = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $registry_date = date('Y-m-d H:i:s');
    
    if (!empty($username) && !empty($password) && !empty($cpassword) && ($password == $cpassword)) {
        // Make sure someone isn't already registered using this username 
        $query = "SELECT * FROM phptest WHERE username = '$username'";
        $data  = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 0) {
            // The username is unique, so insert the data into the database 
            $query = "INSERT INTO phptest (username, password, registry_date, fname,  email ) VALUES ('$username', sha1('$password'), '$registry_date', '$fname',  '$email' )";
            mysqli_query($dbc, $query);
            
            
            // Confirm success with the user, not forgetting to use slashes to escape the apostrophies in the English 
            echo '<div class="alert alert-success"><strong>Success!</strong> Your new account has been successfully created. </div>';
            
            // mysqli_close($dbc);    
        } else {
            // An account already exists for this username, so display an error message and persuade the user to choose a different name 
            echo '<div class="alert alert-info"><strong>Info!</strong> An account already exists for this username. Please use a different username.</div>';
            $username = "";
        }
        
    } else { //another helpful message 
        echo '<div class="alert alert-warning"><strong>Warning!</strong> You must enter all of the sign-up data, including the desired password twice.</div>';
    }
    
}
mysqli_close($dbc);

?> 
</div>
<div class="col-sm">
  <!--FORM START-->
  <form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <!-- USERNAME -->
    <legend>Registration Info</legend>
    <div>
      <label for="username" class="sr-only">Username</label>

      <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="" autofocus="" autocomplete="off"
        value="<?php if (!empty($username)) echo $username; ?>">
    </div>
    <!-- FIRST NAME -->
    <div>
      <label for="fname" class="sr-only">First Name</label>

      <input type="text" name="fname" id="fname" class="form-control" placeholder="First name" required="" autocomplete="off">
    </div>
    <!-- PASSWORD -->
    <div>
      <label for="password" class="sr-only">Password</label>

      <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="" autocomplete="off">
    </div>

    <!-- Confirm PASSWORD -->
    <div>
      <label for="cpassword" class="sr-only">Confirm Password</label>

      <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" required="" autocomplete="off">
    </div>
    <!-- EMAIL -->
    <div>
      <label for="lname" class="sr-only">Email</label>

      <input type="email" name="email" id="email" class="form-control" placeholder="Email" required="" autocomplete="off" value="<?php if (!empty($email)) echo $email; ?>">
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back</button>
      <button class="btn btn-primary" type="submit" name="submit">Sign Up</button>
    </div>

  </form>
  <!--  //////END CONTENT//////-->

</div>
</div>
                 

<?php
include 'include/footer.inc.php';

?>
