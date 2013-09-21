<?php
//Start session
session_start();

//Handle database connections
include "secure/db.php";

//Connect to the database
connectDB();

//Login variables
$errorMsg = "";
$request = "";

//If the user is not logged in (and they are not trying to register) send them to the homepage
if(!isset($_SESSION['user_pk']) && (basename($_SERVER['PHP_SELF']) != "register.php")) {
	if(basename($_SERVER['PHP_SELF']) != "index.php") { //Only do the send if we aren't already on the home page!
		header("Location: http://ec2-54-200-75-240.us-west-2.compute.amazonaws.com/MHacks/index.php");
	}
}

/*
	Header to be included on all pages.
*/

//Basic header tags
echo "<!DOCTYPE html><html lang='en'><head>";

//Basic header info
echo "<meta name='author' content='Matthew Herbst'>
		<meta charset='utf-8'>
		<title>MHacks</title>";

//Global imports
echo "<link rel='stylesheet' type='text/css' href='styles/styles.css'>
		<link rel='stylesheet' type='text/css' href='styles/bootstrap/css/bootstrap.css'>
		<script type='text/javascript' src='styles/bootstrap/js/bootstrap.min.js'></script>
		<script type='text/javascript' src='js/d3/d3.v3.js'></script>
		<script type='text/javascript' src='js/jquery-1.10.2.min.js'></script>
		<script src='http://d3js.org/queue.v1.min.js'></script>
		<script src='http://d3js.org/topojson.v1.min.js'></script>";
		
//Close header tag and open body
echo "</head><body>";
?>