<?php
include "header.php";
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
				<li class='dropdown'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Dropdown <b class='caret'></b></a>
					<ul class='dropdown-menu'>
						<li><a href='#'>Action</a></li>
						<li><a href='#'>Another action</a></li>
						<li><a href='#'>Something else here</a></li>
						<li class='divider'></li>
						<li class='dropdown-header'>Nav header</li>
						<li><a href='#'>Separated link</a></li>
						<li><a href='#'>One more separated link</a></li>
					</ul>
				</li>
			</ul>
			<form class='navbar-form navbar-right'>
				<div class='form-group'>
					<input type='text' placeholder='Email' class='form-control'>
				</div>
				<div class='form-group'>
					<input type='password' placeholder='Password' class='form-control'>
				</div>
				<button type='submit' class='btn btn-success'>Sign in</button>
			</form>
        </div><!--/.navbar-collapse -->
    </div>
</div>

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