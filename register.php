<?php
include "header.php";
include "navbar.php";

//See if this person has an open session
if(isset($_SESSION['user_pk'])) {
	//They have either just registered, or are trying to access this page while logged in
	//Forward them back to the homepage
	header("Location: http://ec2-54-200-75-240.us-west-2.compute.amazonaws.com/MHacks/index.php");
} else { //They need to register
	if(isset($_REQUEST['cmd'])) { //See if the user is requesting anything		
		if($$_REQUEST['cmd'] == "register") { //See if they are asking to register
			echo "<script type='text/javascript'>alert('Register received');</script>";
			//Get the entered username, email, and password
			$u = $_REQUEST['username'];
			$e = $_REQUEST['email'];
			$p = $_REQUEST['password'];
			
			//Ensure all values entered
			if(empty($u)) {
				$errorMsg = "Please enter a username";
			} else if(empty($e)) {
				$errorMsg = "Please enter an email address";
			} else if(empty($p)) {
				$errorMsg = "Please enter a password"; 
			} else {
				if(checkUserExist($u)) { //See if that username is already taken
					$errorMsg = "Username " . $u . " already exists.";
				} else if(checkEmailExist($e)) { //See if that email is already in use
					$errorMsg = "The email adress " . $e . " is already in use.";
				} else {
					$added = addUser($u, $p, $e); //Returns 1 if succesful or an error message otherwise
					if($added) { //If the registration was a sucess
						$pk = validateUser($u, $p); //Login the user
						echo "<script type='text/javascript'>alert('User should be logged in. pk = " . $pk . "  u = " . $u . "  p = " . $u . "');</script>";
						if($pk != -1) { //Check to see if the login was a success
							$_SESSION['user_pk'] = $pk;
							$_SESSION['user'] = $u;
							
							//Send to the home page after logging in
							header("Location: http://ec2-54-200-75-240.us-west-2.compute.amazonaws.com/MHacks/index.php");
						} else { //The login failed
							$errorMsg = "Failed to automatically login after registering.";
						}
					} else { //The registration failed
						$errorMsg = $added;
					}
				}
			}
		}
	}
}

//Give the error message over to the JavaScript to deal with displaying it
echo "<script type='text/javascript'>var errorMessage = " . $errorMsg . ";</script>";
?>

<link href='styles/register.css' rel='stylesheet'>

<div class='container'>
    <form class='form-signin' action='register.php' method='post'>
		<h2 class='form-signin-heading'>Please register</h2>
        <input type='text' class='form-control' placeholder='Username' autofocus name='password' maxlength='25'>
		<input type='text' class='form-control' placeholder='Email address' name='email' maxlength='255'>
        <input type='password' class='form-control' placeholder='Password' name='password' maxlength='20'>
        <button class='btn btn-lg btn-primary btn-block' type='submit'>Register</button>
		<input type='hidden' name='cmd' value='register' />
    </form>
</div> <!-- /container -->

<?php
include "footer.php";
?>