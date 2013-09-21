<?php # Kyle L. Oswald 10/11/12
	
	DEFINE('DB_USER', 'amwebapp_admin');
	DEFINE('DB_PASSWORD', 'et2012am');
	DEFINE('DB_HOST', 'localhost');
	DEFINE('DB_NAME', 'amwebapp_MainDatabase');
	
	DEFINE('AES_KEY', 'ikcsSIs6iSeoPmtV');
	
	DEFINE('SHA_PASSWORD_SALT', 'o6UsywNf06Cud5a4');
	
	# Attempt to connect to the database, die on failure
	$cnn = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) OR die('Could not connect to SQL: ' . mysql_error());
	
	@mysql_select_db(DB_NAME) OR die('Could not select database: ' . mysql_error());
	
	# debug ( uncomment to test connection )
	#echo '<p>Connection Successful</p>';
	#mysql_close();
	
	# Returns a SQL-safe parameter value
	function escape_data($field) {
		# Handle magic quotes
		if (ini_get('magic_quotes_gpc')) {
			stripslashes($field);
		}
		
		# Check for mysql_real_escape_string() support
		if (function_exists('mysql_real_escape_string')) {
			global $cnn; 
			$field = mysql_real_escape_string(trim($field), $cnn);
		} else {
			$field = mysql_escape_string(trim($field));
		}
		
		return $field;
	}
	
?>