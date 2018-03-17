<!-- Function calls from functions.php -->
<?php 

include 'include/functions.php';
require_once('include/startSession.php'); 

?>

<div class="container">
  <!-- Column and include file for the login form -->
  <?php include ('include/login.inc.php'); ?>


    <!--    <p><h2><?php echo trim($_POST["fname"]);?></h2>	&nbsp; <h2> <?php echo trim($_POST["lname"]);?></h2> </p> -->


  <!-- Colum for things below login/registry -->
  <div class="col-sm">
    <p>Welcome to our website</p>

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