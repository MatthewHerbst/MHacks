<?php
include "header.php";

if(isset($_SESSION['user_pk'])) { //See if this person has an open session
	if(isset($_POST['cmd'])) { //See if the user is requesting anything
		if($_POST['cmd'] == "logout") { //Check if the user wants to logout
			unset($_SESSION['user_pk']);
			
			//Forward them back to the homepage
			header("Location: http://ec2-54-200-75-240.us-west-2.compute.amazonaws.com/MHacks/index.php");
		}
	}
} else { //They need to sign in (registration occurs on register.php)
	if(isset($_POST['cmd'])) { //See if the user is requesting anything
		if($_POST['cmd'] == "login" && isset($_POST['username']) && isset($_POST['password'])) { //Check if the user wants to login
			//Get the entered username and password
			$u = $_POST['username'];
			$p = $_POST['password'];
		
			//Ensure both a username and a password were entered
			if(empty($u)) {
				$errorMsg = "Please enter a username";
			} else if(empty($p)) {
				$errorMsg = "Please enter a password";
			} else { //Check the entered username and password
				$pk = validateUser($u, $p); //Login the user
				if($pk != -1) { //Check if that login was a success
					$_SESSION['user'] = $u;
					$_SESSION['user_pk'] = $pk;
				} else {
					$errorMsg = "Invalid Username/Password";
				}
			}
		}
	}
}

//Give the error message over to the JavaScript to deal with displaying it
echo "<script type='text/javascript'>var errorMessage = " . $errorMsg . ";</script>";

include "navbar.php";
?>

<div class='container wrapper'>
	<div id='vis'></div>
	<div id='sidebar'>
		<div id='productList'>
			<?php //Populate the list of products belonging to this user
			if(isset($_SESSION['user_pk'])) {
				$products = getUserProducts($_SESSION['user_pk']);
				
				foreach($products as $product) {
					echo "<div class='product'>" . $product . "</div>";
				}
			} else {
				echo "Login to view saved products!";
			}
			?>
		</div><!--/#productList -->
		<div id='productSearch'>
			<div id='search'></div>
			<div id='searchResults'></div>
		</div>
	</div><!--/#sidebar -->
</div><!--/.container wrapper -->

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