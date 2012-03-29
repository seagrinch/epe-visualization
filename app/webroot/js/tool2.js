// Dot Chart Tool for Testing
// Adapted from http://bost.ocks.org/mike/d3/workshop/dot-chart.html
// By Sage 3/9/12

var chart = function(settings) {

if (typeof(settings)==='undefined') {
  var data = [
  {x: 10.0, y: 9.14},
  {x:  8.0, y: 8.14},
  {x: 13.0, y: 8.74},
  {x:  9.0, y: 8.77},
  {x: 11.0, y: 9.26},
  {x: 14.0, y: 8.10},
  {x:  6.0, y: 6.13},
  {x:  4.0, y: 3.10},
  {x: 12.0, y: 9.13},
  {x:  7.0, y: 7.26},
  {x:  5.0, y: 4.74},
  ];
  var color = 'steelblue';
} else {
  var data = eval(settings.data);
  var color = settings.color;
}

var margin = {top: 40, right: 40, bottom: 40, left: 40},
    width = 640,
    height = 480;

var x = pad(d3.scale.linear()
    .domain(d3.extent(data, function(d) { return d.x; }))
    .range([0, width - margin.left - margin.right]), 40);

var y = pad(d3.scale.linear()
    .domain(d3.extent(data, function(d) { return d.y; }))
    .range([height - margin.top - margin.bottom, 0]), 40);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom")
    .tickPadding(8);

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickPadding(8);

var svg = d3.select("#chart").append("svg")
    .attr("width", width)
    .attr("height", height)
    .attr("class", "dot chart")
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

svg.selectAll(".dot")
    .data(data)
  .enter().append("circle")
    .attr("class", "dot")
    .attr("cx", function(d) { return x(d.x); })
    .attr("cy", function(d) { return y(d.y); })
    .attr("r", 12);

svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + y.range()[0] + ")")
    .call(xAxis);

svg.append("g")
    .attr("class", "y axis")
    .call(yAxis);

function pad(scale, k) {
  var range = scale.range();
  if (range[0] > range[1]) k *= -1;
  return scale.domain([range[0] - k, range[1] + k].map(scale.invert)).nice();
}

//Added to update color
svg.selectAll("circle")
    .attr("style","fill:" + color);

}