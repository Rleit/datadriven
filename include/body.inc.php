<div class="container">
  <!-- Column for the login form -->
  <div class="col-sm">
    <!-- Form start -->
    <form class="form-signin" action="#" method="post">

      <h1 class="h3 mb-3 font-weight-normal">Login</h1>

      <!-- Username field -->
      <div>
        <label for="fname" class="sr-only">Username</label>

        <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required="" autofocus="" autocomplete="off">
      </div>

      <!-- Password Field  -->
      <div>
        <label for="lname" class="sr-only">Password</label>

        <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required="" autocomplete="off">
      </div>

      <!-- Remember me check box -->
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>

      </div>

      <!-- Login button  -->
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

      </br>

      <!-- MODAL For registry form -->
      <button type="button" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
        Register
      </button>


    </form>

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
$query = "SELECT id, username, fname, email, registry_date , password FROM phptest WHERE username IS NOT NULL ORDER BY registry_date DESC LIMIT 5";


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
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Register</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">


                  <!--FORM START-->
                  <form class="form-signin" action="#" method="post">

                    <div>
                      <label for="fname" class="sr-only">Username</label>

                      <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required="" autofocus="" autocomplete="off">
                    </div>


                    <div>
                      <label for="lname" class="sr-only">Password</label>

                      <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required="" autocomplete="off">
                    </div>

                  </form>
                  <!--  //////END CONTENT//////-->
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>

  </div>

</div>
