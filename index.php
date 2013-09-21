<?php
include "header.php";

//See if this person has an open session
if(isset($_SESSION['user_pk'])) {
	echo "<script type=text/javascript>alert('Logged in. user_pk: '" . $_SESSION['user_pk'] . "');</script>";
	//Check if the user wants to logout
	if(isset($_REQUEST['cmd'])) { 
		if($_REQUEST['cmd'] == "logout") {
			unset($_SESSION['user_pk']);
			
			//Forward them back to the homepage
			header("Location: http://ec2-54-200-75-240.us-west-2.compute.amazonaws.com/MHacks/index.php");
		}
	}
} else { //They need to sign in or register
	//See if the user is requesting anything
	if(isset($_REQUEST['cmd'])) {
		$request = $_REQUEST['cmd'];
		echo "<script type=text/javascript>alert('cmd: " . $_REQUEST['cmd'] . "');</script>";
		//Get the entered username and password
		$u = $_REQUEST['username'];
		$p = $_REQUEST['password'];

		//Check if the user wants to login
		if($request == "login") {			
			//Ensure both a username and a password were entered
			if(empty($u)) {
				$errorMsg = "Please enter a username";
			} else if(empty($p)) {
				$errorMsg = "Please enter a password";
			} else { //Check the entered username and password
				//Get the user's primary key (if they exist)
				$pk = validateUser($u, $p);
				if($pk != -1) {
					//User exists, initialize session variables
					$_SESSION['user'] = $u;
					$_SESSION['user_pk'] = $pk;
					
					echo "<script type=text/javascript>alert('Login ok!');</script>";
				} else {
					$errorMsg = "Invalid Username/Password";
				}
			} //Check if the user wants to register
		} else if($request == "register") {	
			//Ensure both a username and a password were entered
			if(empty($u)) {
				$errorMsg = "Please enter a username";
			} else if(empty($p)) {
				$errorMsg = "Please enter a password";
			} else {
				//See if that username is already taken
				if(checkUserExist($u)) {
					$errorMsg = "Username " . $u . " already exists.";
				} else {
					$added = addUser($u, $p); //Returns 1 if succesful or an error message otherwise
					if($added) {
						$pk = validateUser($u, $p);

						//Check if the validation returned valid
						if($pk != -1) {
							$_SESSION['user_pk'] = $pk;
							$_SESSION['user'] = $u;
						} else {
							$errorMsg = "Failed to login.";
						}
					} else {
						$errorMsg = $added;
					}
				}
			}
		}
	}
}
?>

<div class='navbar navbar-inverse navbar-fixed-top'>
	<div class='container'>
		<div class='navbar-header'>
			<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
			</button>
			<a class='navbar-brand' href='#'>Project name</a>
        </div>
        <div class='navbar-collapse collapse'>
			<ul class='nav navbar-nav'>
				<li class='active'><a href='#'>Home</a></li>
				<li><a href='#about'>About</a></li>
				<li><a href='#contact'>Contact</a></li>
				<?php
				if(isset($_SESSION['user_pk'])) {
					echo "
					<li class='dropdown'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>My Account <b class='caret'></b></a>
						<ul class='dropdown-menu'>
							<li><a href='#'>Action</a></li>
							<li><a href='#'>Another action</a></li>
							<li><a href='#'>Something else here</a></li>
							<li class='divider'></li>
							<li class='dropdown-header'>Nav header</li>
							<li><a href='#'>Separated link</a></li>
							<li><a href='#'>One more separated link</a></li>
						</ul>
					</li>";
				}
				?>
			</ul>
			<form class='navbar-form navbar-right' action='index.php' method='post'>
				<div class='form-group'>
					<input type='text' placeholder='Username' name='username' maxlength='25' class='form-control'>
				</div>
				<div class='form-group'>
					<input type='password' placeholder='Password' name='password' maxlength='20' class='form-control'>
				</div>
				<script type='txt/javascript'>
					function clickLogin() {
						document.getElementById('loginRegisterLogout').innerHTML = '<input type=\'hidden\' name\'cmd\' value=\'login\' />';
					};
					function clickRegister() {
						document.getElementById('loginRegisterLogout').innerHTML = '<input type=\'hidden\' name=\'cmd\' value=\'register\' />';
					};
					function clickLogout() {
						document.getElementById('loginRegisterLogout').innerHTML = '<input type=\'hidden\' name=\'cmd\' value=\'logout\' />';
					};
				</script>
				<?php //Show login and register or logout buttons
				if(isset($_SESSION['user_pk'])) {
					echo "<button type='submit' class='btn btn-success' onclick='clickLogout'>Logout</button>";
				} else {
					echo "<button type='submit' class='btn btn-success' onclick='clickLogin()'>Sign in</button>
					<button type='submit' class='btn btn-success' onclick='clickRegister()'>Register</button>";
				}
				?>
				<div id='loginRegister'></div>
			</form>
        </div><!--/.navbar-collapse -->
    </div><!--/.container -->
</div><!--/.navbar -->

<div class='container wrapper'>
	<div id='vis'>
		<h1>Visualization will go here! Please work!</h1>
	</div>
</div>

<script type='text/javascript'>
var width = 960,
    height = 500;

var color = d3.scale.threshold()
    .domain([.02, .04, .06, .08, .10])
    .range(['#f2f0f7', '#dadaeb', '#bcbddc', '#9e9ac8', '#756bb1', '#54278f']);

var path = d3.geo.path();

var svg = d3.select('#vis').append('svg')
    .attr('width', width)
    .attr('height', height);

queue()
    .defer(d3.json, 'd/us.json')
    .defer(d3.tsv, 'd/unemployment.tsv')
    .await(ready);

function ready(error, us, unemployment) {
  var rateById = {};

  unemployment.forEach(function(d) { rateById[d.id] = +d.rate; });

  svg.append('g')
      .attr('class', 'counties')
    .selectAll('path')
      .data(topojson.feature(us, us.objects.counties).features)
    .enter().append('path')
      .attr('d', path)
      .style('fill', function(d) { return color(rateById[d.id]); });

  svg.append('path')
      .datum(topojson.mesh(us, us.objects.states, function(a, b) { return a.id !== b.id; }))
      .attr('class', 'states')
      .attr('d', path);
}
</script>

<?php
include "footer.php";
?>