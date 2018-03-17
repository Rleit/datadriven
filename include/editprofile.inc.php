<?php 
    require_once("include/connectvars.php"); 
   
  // Make sure the user is logged in before going any further. 
  if (isset($_GET['id']) || ($_SESSION['$id'] == $_GET['id']))  
  { 

    /* Opens modal for the edit form */
  echo '      <button type="button" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#edit">Edit Profile</button>'; 
} 
// End of check for a single row of user results 
  else 
  { 

    /* Error accessing profile */
echo '<p class="error" >There was a problem accessing your profile ' . $_SESSION['username'] .  '.</p>'; 
  }  

 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
   
   if (isset($_POST['edit'])) { 
    // Grab the profile data from the POST 
    $username = mysqli_real_escape_string($dbc, trim($_POST['username'])); 
    $fname = mysqli_real_escape_string($dbc, trim($_POST['fname'])); 
    $email = mysqli_real_escape_string($dbc, trim($_POST['email'])); 
    $registry_date = mysqli_real_escape_string($dbc, trim($_POST['registry_date'])); 


    // Update the phptest data in the database 
    if (!$error) { 
      if (!empty($username) && !empty($fname) && !empty($email) && !empty($registry_date) ) { 
        if (!empty($registry_date)) { 
        $query = "UPDATE phptest SET username = '$username', fname = '$fname', email = '$email',  registry_date = '$registry_date'   WHERE id = '" . $_SESSION['id'] . "'";
    }
    else {
        $query = "UPDATE phptest SET username = '$username', fname = '$fname', email = '$email'   WHERE id = '" . $_SESSION['id'] . "'";

    }
        mysqli_query($dbc, $query); 

        // Confirm success with the user 
        echo '</br>';
        echo '<p class="alert alert-success" >Your Profile has been successfully updated. </p>'; 
        echo '<button class="btn btn-lg btn-primary btn-block" onClick="goBack()"> Back to home </button>';
        mysqli_close($dbc); 
        
        exit(); 
      } 
      else { 
        echo '<p class="alert alert-danger">You must enter all of the profile data .</p>'; 
      } 
    } 
  } // End of check for form submission 
  else { 
    // Grab the phptest data from the database 
    $query = "SELECT username, fname, email, registry_date, email FROM phptest  WHERE id = '" . $_SESSION['id'] . "'";
    $data = mysqli_query($dbc, $query); 
    $row = mysqli_fetch_array($data); 

    if ($row != NULL) { 
      $username = $row['username']; 
      $fname = $row['fname']; 
      $email = $row['email']; 
      $registry_date = $row['registry_date']; 
 
    } 
    else { 
      echo '<p class="alert alert-warning">There was a problem accessing your Profile.</p>'; 
    } 
  } 

  mysqli_close($dbc); 
  

  ?>

<!-- Modal for the registry form -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="exampleModalLabel">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">



                <form class="form-signin" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">


                    <legend>Personal Information</legend>
                    <label class="sr-only" for="username">User Name:</label>
                    <input class="form-control" type="text" id="usernamee" name="username" placeholder="" value="<?php if (!empty($username)) echo $username; else echo 'Username'; ?>"
                    />
                    <br />
                    <label class="sr-only" for="fname">First Name:</label>
                    <input class="form-control" type="text" id="fnamee" name="fname" placeholder="" value="<?php if (!empty($fname)) echo $fname; else echo 'First Name'; ?>"
                    />
                    <br />
                    <label class="sr-only" for="email">Email:</label>
                    <input class="form-control" type="text" id="emaile" name="email" placeholder="" value="<?php if (!empty($email)) echo $email; else echo 'email@email.email'; ?>"
                    />
                    <br />
                    <label class="sr-only" for="registry_date">Registry Date:</label>
                    <input class="form-control" type="text" id="registry_date" name="registry_date" placeholder="" value="<?php if (!empty($registry_date)) echo $registry_date; else echo 'YYYY-MM-DD'; ?>"
                    />
                    <br />

                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Save Profile" name="edit" />
                    
                </form>


            </div>

        </div>
    </div>
</div>
