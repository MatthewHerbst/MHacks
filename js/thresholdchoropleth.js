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