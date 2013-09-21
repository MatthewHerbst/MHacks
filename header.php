<?php
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
		<script type='text/javascript' src='js/d3/d3.v3.js'></script>
		<script type='text/javascript' src='js/jquery-1.10.2.min.js'></script>
		<script src='http://d3js.org/queue.v1.min.js'></script>
		<script src='http://d3js.org/topojson.v1.min.js'></script>";
		
//Close header tags
echo "</head>";
?>