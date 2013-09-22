<?php #Kyle Oswald 09-21-2013

$suppress_error_redirect = true;

require_once('/../secure/db.php');

if (!isset($_GET['product_id'])) {
	exit();
}

header('Content-type: application/json');

$product_id = $_GET['product_id'];

connectDB();

$query = 
	'SELECT s.value, z.zipcode 
		FROM Sentiment AS s 
		INNER JOIN TwitterStatus AS t 
			ON t._id = s.status_id 
		INNER JOIN Zipcodes AS z 
			ON t.city = z.city_id';

$result = mysql_query($query);

ob_start();

echo "{\n";

if (!$result) {
	echo '"error": "';
	echo mysql_error();
	echo '",';
	echo '"query": "';
	echo $query;
	echo '",';
	echo '"params": ';
	echo json_encode($_POST);
} else {
	echo "\"points\": [\n";
	
	if (($count = mysql_num_rows($result)) > 0) {
		while ($point = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "{ "
			echo "\"value\": ";
			echo $point[0];
			echo "; ";
			echo "\"zipcode\": ";
			echo $point[1];
			echo "; ";
			echo "},\n";
		}
	}
	
	echo "]\n";
}

echo '}';

ob_end_flush();
?>