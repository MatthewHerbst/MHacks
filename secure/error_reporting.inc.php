<?php # Kyle Oswald 09/21/2013

DEFINE('ERROR_LOG_LOCATION', 'error_log');

# Set site reporting level
error_reporting(E_ALL);

# Default log email
$log_email = 'kyleleeswald@gmail.com';

if (!isset($suppress_error_redirect)) {
	$suppress_error_redirect = false;
}

#Function for error reporting, do not call this directly
function handle_error($e_number, $e_message, $e_file, $e_line, $e_vars) {
	global $log_email;
	global $suppress_error_redirect;
	
	$date = date('d-m-Y H:i:s'); 
	$message = '[' . $date . '] ' . get_error_name($e_number) . ':  ' . 
		$e_message . ' in ' . $e_file . ' on line ' . $e_line . "\n";
	
	@error_log($message, 3, ERROR_LOG_LOCATION);
	
	@error_log($message, 1, $log_email);
	
	if (!$suppress_error_redirect) {
		@header('Location: error_page.html');
		exit();
	}
}

function get_error_name($e_number) {
	switch($e_number) {
		case E_ERROR: // 1 //
			return 'E_ERROR';
		case E_WARNING: // 2 //
			return 'E_WARNING';
		case E_PARSE: // 4 //
			return 'E_PARSE';
		case E_NOTICE: // 8 //
			return 'E_NOTICE';
		case E_CORE_ERROR: // 16 //
			return 'E_CORE_ERROR';
		case E_CORE_WARNING: // 32 //
			return 'E_CORE_WARNING';
		case E_CORE_ERROR: // 64 //
			return 'E_COMPILE_ERROR';
		case E_CORE_WARNING: // 128 //
			return 'E_COMPILE_WARNING';
		case E_USER_ERROR: // 256 //
			return 'E_USER_ERROR';
		case E_USER_WARNING: // 512 //
			return 'E_USER_WARNING';
		case E_USER_NOTICE: // 1024 //
			return 'E_USER_NOTICE';
		case E_STRICT: // 2048 //
			return 'E_STRICT';
		case E_RECOVERABLE_ERROR: // 4096 //
			return 'E_RECOVERABLE_ERROR';
		case E_DEPRECATED: // 8192 //
			return 'E_DEPRECATED';
		case E_USER_DEPRECATED: // 16384 //
			return 'E_USER_DEPRECATED';
		default:
			return 'UNKNOWN';
	} 
}

# Set delegate to receive error notifications
set_error_handler('handle_error');

?>