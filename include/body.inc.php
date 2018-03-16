<?php include 'include/functions.php'; ?>
<div class="container">
  <!-- Column for the login form -->
  <div class="col-sm">

  <?php  

require_once("include/startSession.php"); // Start the session 
require_once('include/connectvars.php'); 

// create an empty variable to contain any error messages 
$error_msg = ""; 

  // If the user isn't logged in, try to log them in 
  if (!isset($_SESSION['id'])) { 
    if (isset($_POST['submit'])) { 
      // Connect to the database 
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
      // Grab the user-entered log-in data from the form, clean it up and put into  new variables to feed into your query below 
      $username = mysqli_real_escape_string($dbc, trim($_POST['username'])); 
      $password = mysqli_real_escape_string($dbc, trim($_POST['password'])); 

      if (!empty($username) && !empty($password)) { 
        // Look up the username and password in the database 
        $query = "SELECT id, username, password FROM phptest WHERE username = '$username' AND password = sha1('$password')"; 
        $data = mysqli_query($dbc, $query); 
         
        if (mysqli_num_rows($data) == 1) { 
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page 
          $row = mysqli_fetch_array($data); 
          $_SESSION['id'] = $row['id']; 
          $_SESSION['username'] = $row['username']; 
          setcookie('id', $row['id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days 
          setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days 
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php'; 
          header('Location: ' . $home_url); 
        } 
         else { 
// The username/password are incorrect so set an error message 
          $error_msg = 'Sorry, you must enter a valid username and password to log in.'  ; 
        } 
      } 
      else { 
        // The username/password weren't entered so set an error message; 
        $error_msg = 'Sorry, you must enter your username and password to log in, OK.'. $username . $password ; 
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
    <form class="form-signin">

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
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Login</button>

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
  } 
?> 

  </div>

  <!-- Colum for things below login/registry -->
  <div class="col-sm">
    <p>Welcome to our website</p>

    <!--    <p><h2><?php echo trim($_POST["fname"]);?></h2>	&nbsp; <h2> <?php echo trim($_POST["lname"]);?></h2> </p> -->

    <!-- Top part of the table that shows information from the database -->
    <table class="table table-striped table-dark">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Username</th>
          <th scope="col">Registry Date</th>
          <th scope="col">First Name</th>
          <th scope="col">Email</th>
          <th scope="col">Password</th>
        </tr>
      </thead>

      <tbody>
        <?php
// Connect to the database

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$dbc) {
    die('Connect Error: ' . mysqli_connect_error()); //database connection error message
} else {
    echo "success"; //a quick check that we have successfully connected to a database
};



// Retrieve the user data from MySQL
$query = "SELECT id, username, fname, email, registry_date , password FROM phptest WHERE username IS NOT NULL ORDER BY id DESC LIMIT 7";


$data = mysqli_query($dbc, $query);

// if (mysqli_num_rows($data) == 2) {
    // The user row was found so display the user data
    /* While > mysqli num rows */
    while ($row = mysqli_fetch_array($data)) {
        if (!empty($row['id'])) {
            echo '<tr><th scope="row">'. $row['id'] .'</th>';
        }
        if (!empty($row['username'])) {
            echo '<td class="label">' . $row['username'] . '</td>';
        }
        if (!empty($row['registry_date'])) {
            echo '<td class="label">' . $row['registry_date'] . '</td>';
        }

        if (!empty($row['fname'])) {
            echo '<td class="label">' . $row['fname'] . '</td>';
        }
        if (!empty($row['email'])) {
            echo '<td class="label">' . $row['email'] . '</td>';
        }
        if (!empty($row['password'])) {
            echo '<td class="label">'. $row['password'] . '</td></tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';
  mysqli_close($dbc);

?>


          <!-- Modal for the registry form -->
          <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content ">
                <div class="modal-header text-center">
                  <h5 class="modal-title" id="exampleModalLabel">Register</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">,



                  <!-- Pulling registry functions -->

                  <?php 
                  include 'include/registry.inc.php';
                  ?>


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
            </div>
          </div>



  </div>

</div>