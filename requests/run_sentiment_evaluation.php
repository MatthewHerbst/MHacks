<?php # Kyle Oswald 09/21/2013
	if (!isset($_SESSION) || !isset($_SESSION['user_pk'])) {
		exit();
	}
	
	if (!isset($_POST['product_id']) || && !is_numeric($_POST['product_id'])) {
		exit();
	}
	
	exec('java -jar sentimentprocessor.jar ' . $_POST['product_id']);
?>