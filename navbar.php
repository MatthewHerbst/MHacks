<?php
	echo "<div class='navbar navbar-inverse navbar-fixed-top'>
	<div class='container'>
		<div class='navbar-header'>
			<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
			</button>
			<a class='navbar-brand' href='#'>Profit Maker 3000</a>
        </div>
        <div class='navbar-collapse collapse'>
			<ul class='nav navbar-nav'>
				<li class='active'><a href='index.php'>Home</a></li>
				<li><a href='#about'>About</a></li>
				<li><a href='#contact'>Contact</a></li>";
				
				//Show user drop down if logged in
				if(isset($_SESSION['user_pk'])) {
					echo "
					<li class='dropdown'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>My Account <b class='caret'></b></a>
						<ul class='dropdown-menu'>
							<li><a href='#'>My Profile</a></li>
							<li><a href='#'>My Models</a></li>
						</ul>
					</li>";
				}
				
			echo "</ul>";
			
			//Show login and register or logout buttons
			if(isset($_SESSION['user_pk'])) {
				echo "<form class='navbar-form navbar-right' action='index.php' method='post'>				
						<button type='submit' class='btn btn-success'>Logout</button>				
						<input type='hidden' name='cmd' value='logout' />
					</form>";
			} else {
				echo "<form class='navbar-form navbar-right' action='index.php' method='post'>
						<div class='form-group'>
							<input type='text' placeholder='Username' name='username' maxlength='25' class='form-control'>
						</div>
						<div class='form-group'>
							<input type='password' placeholder='Password' name='password' maxlength='20' class='form-control'>
						</div>
					
						<button type='submit' class='btn btn-success'>Sign in</button>
					
						<input type='hidden' name='cmd' value='login' />
					</form>
					<form class='navbar-form navbar-right' action='register.php' method='post'>
						<button type='submit' class='btn btn-success'>Register</button>
						<input type='hidden' name='cmd' value='register' />
					</form>";
			}
        echo "</div><!--/.navbar-collapse -->
    </div><!--/.container -->
</div><!--/.navbar -->";
?>