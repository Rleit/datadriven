<div class="col-sm">

 <?php
// Start the session 
require_once('include/connectvars.php');

// create an empty variable to contain any error messages 
$error_msg = "";

// If the user isn't logged in, try to log them in 
if (!isset($_SESSION['id'])) {
    if (isset($_POST['login'])) {
        // Connect to the database 
        $dbc      = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        // Grab the user-entered log-in data from the form, clean it up and put into  new variables to feed into your query below 
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
        
        if (!empty($username) && !empty($password)) {
            // Look up the username and password in the database 
            $query = "SELECT id, username, password FROM phptest WHERE username = '$username' AND password = sha1('$password')";
            $data  = mysqli_query($dbc, $query);
            
            if (mysqli_num_rows($data) == 1) {
                // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page 
                $row                  = mysqli_fetch_array($data);
                $_SESSION['id']       = $row['id'];
                $_SESSION['username'] = $row['username'];
                setcookie('id', $row['id'], time() + (60 * 60 * 24 * 30)); // expires in 30 days 
                setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30)); // expires in 30 days 
                $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
                header('password: ' . $home_url);
            } else {
                // The username/password are incorrect so set an error message 
                $error_msg = 'Sorry, you must enter a valid username and password to log in.';
            }
        } else {
            // The username/password weren't entered so set an error message; 
            $error_msg = 'Sorry, you must enter your username and password to log in, OK.' . $username . $password;
        }
    }
}

?>


  <!--this is all the page output code -->

  <?php 

// If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in 
if (empty($_SESSION['id'])) { 
echo '<p class="error">' . $error_msg . '</p>'; 

?>

  <!-- Form start -->
  <form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <h1 class="h3 mb-3 font-weight-normal">Login</h1>

    <!-- Username field -->
    <div>
      <label for="username" class="sr-only">Username</label>

      <input type="text" name="username" id="uname" class="form-control" placeholder="Username" required="" value="<?php if (!empty($username)) echo $username; ?>">
    </div>

    <!-- Password Field  -->
    <div>
      <label for="password" class="sr-only">Password</label>

      <input type="password" name="password" id="pw" class="form-control" placeholder="Password" required="" autocomplete="off">
    </div>

    <!-- Remember me check box -->
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>

    </div>

    <!-- Login button  -->
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>

    </br>

    <!-- MODAL For registry form -->
    <button type="button" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#Modal">
      Register
    </button>


  </form>


  <?php 
} 
else { 
  // Confirm the successful log-in 
      echo('<p class="login">You are logged in as ' . $_SESSION['username'] .  '. <a href="logout.php">Log out</a>.</p>');

      include ('include/editprofile.inc.php');
        ?>





    <?php
} 



mysqli_close($dbc); 

?>





</div>
