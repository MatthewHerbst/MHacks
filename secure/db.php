<?php
/***** Configuration ****************/
$USER = 'root';
$PASSWORD = 'MHacks';
$DB='Mhacks';

$USER_TABLE = 'Users';
$USERNAME_MAX_SIZE = 25;
$USERNAME_MIN_SIZE = 3;
$PASSWORD_MAX_SIZE = 20;
$PASSWORD_MIN_SIZE = 3;
$EMAIL_MAX_SIZE = 255;
$EMAIL_MIN_SIZE = 5;
/************** END CONFIGURATION *************/

/*
Connect to the database
*/
function connectDB() {
	global $USER;
	global $PASSWORD;
	global $DB;
	mysql_connect("localhost", $USER, $PASSWORD) || die("can not connect");
	mysql_select_db($DB);
}

/*
Validate a user - check the password - returns the primary key if successful or -1 if failed
*/
function validateUser($user, $password) {
	global $USER_TABLE;

	//Username can only be alphanumeric
	if(!ctype_alnum($user)) {
		return -1;
	}

	//Password can only be alphanumeric
	if(!ctype_alnum($password)) {
		return -1;
	}

	//Run the query on the database
	$query = "select id, password from ". $USER_TABLE . " where username = '" . mysql_real_escape_string($user) . "'";
	$q = mysql_query($query);
	if(!$q) {
		return -1;
	}
	$r = mysql_fetch_array($q);
	if($r && $r['password'] != crypt($password, $user)) {
	    return -1;
	} else if ($r && $r['id'] > 0) {
		return $r['id'];
	} else {
		return -1;
	}
}

/*
Checks to see if a username is in the system
*/
function checkUserExist($user) {
	global $USER_TABLE;

	//Run the query on the database
	$sql = "select id from ". $USER_TABLE . " where username = '" . mysql_real_escape_string($user) . "'";
	$q = mysql_query($sql);

	//Check if there was an error running the query
	if(mysql_error()) {
		return false;
	}

	//Check if the query has results
	if(!$q) {
		return false;
	}

	//Check query results
	$r = mysql_fetch_array($q);
	return ($r && $r['id'] > 0);
}

/*
Checks to see if a username is in the system
*/
function checkEmailExist($email) {
	global $USER_TABLE;

	//Run the query on the database
	$sql = "select id from ". $USER_TABLE . " where email = '" . mysql_real_escape_string($email) . "'";
	$q = mysql_query($sql);

	//Check if there was an error running the query
	if(mysql_error()) {
		return false;
	}

	//Check if the query has results
	if(!$q) {
		return false;
	}

	//Check query results
	$r = mysql_fetch_array($q);
	return ($r && $r['id'] > 0);
}

/*
Add a new user to the system. Returns true if this succeeds, the error message otherwise
*/
function addUser($user, $password, $email = "") {
	global $USER_TABLE;
	global $USERNAME_MAX_SIZE;
	global $PASSWORD_MAX_SIZE;
	global $USERNAME_MIN_SIZE;
	global $PASSWORD_MIN_SIZE;
	global $EMAIL_MAX_SIZE;
	global $EMAIL_MIN_SIZE;

	//Check username rules
	if(!ctype_alnum($user) || strlen($user) > $USERNAME_MAX_SIZE || strlen($user) < $USERNAME_MIN_SIZE) {
		return "Username must be between " . $USERNAME_MIN_SIZE . " and " . $USERNAME_MAX_SIZE . " characters.";
	}
	
	//Check username is unique
	if(checkUserExist($user)) {
		return "Username " . $user . " already exists.";
	}

	//Check password rules
	if(!ctype_alnum($password) || strlen($password) > $PASSWORD_MAX_SIZE || strlen($password) < $PASSWORD_MIN_SIZE) {
		return "Password must be between " . $PASSWORD_MIN_SIZE . " and " . $PASSWORD_MAX_SIZE . " characters.";
	}
	
	//Only do checks on entered emails
	if(email != "") {
		//Check email rules
		if(strlen($email) > $EMAIL_MAX_SIZE || strlen($email) < $EMAIL_MIN_SIZE) {
			return "Email must be between " . $EMAIL_MIN_SIZE . " and " . $EMAIL_MAX_SIZE . " characters.";
		}
		
		//Check email is unique
		if(checkEmailExist($email)) {
			return "Email " . $email . " is already in use.";
		}
	}

	//Make username safe for db and hash the password
	$fixedUser = mysql_real_escape_string($user);
	$hashedPassword = crypt($password, $user);
	$fixedEmail = mysql_real_escape_string($email);
	
	//Run the query on the database
	$sql = "insert into " . $USER_TABLE . " (username,password,email) values ('$fixedUser','$hashedPassword','$fixedEmail')";
	mysql_query($sql);
	if(mysql_error()) {
		return false;
	} else {
		return true;
	}
}
?>