// Bar Chart Tool for Testing
// Adapted from http://bost.ocks.org/mike/d3/workshop/bar-chart.html
// By Sage 3/9/12

var chart = function(settings) {

//rect.bar.fill = 'red';

if (typeof(settings)==='undefined') {
  var data = [1, 1, 2, 3, 5, 8];
  var color = 'steelblue';
} else {
  var data = JSON.parse(settings.data);
  var color = settings.color;
}

var margin = {top: 40, right: 40, bottom: 40, left: 40},
    width = 640,
    height = 480;

var x = d3.scale.linear()
    .domain([0, d3.max(data)])
    .range([0, width - margin.left - margin.right]);

var y = d3.scale.ordinal()
    .domain(d3.range(data.length))
    .rangeRoundBands([height - margin.top - margin.bottom, 0], .2);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom")
    .tickPadding(8);

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickSize(0)
    .tickPadding(8);

var svg = d3.select("#chart").append("svg")
    .attr("width", width)
    .attr("height", height)
    .attr("class", "bar chart")
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

svg.selectAll(".bar")
    .data(data)
  .enter().append("rect")
    .attr("class", "bar")
    .attr("y", function(d, i) { return y(i); })
    .attr("width", x)
    .attr("height", y.rangeBand());

svg.selectAll("rect")
    .attr("style","fill:" + color); //Update color

svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + y.rangeExtent()[1] + ")")
    .call(xAxis);

svg.append("g")
    .attr("class", "y axis")
    .call(yAxis)
  .selectAll("text")
    .text(function(d) { return String.fromCharCode(d + 65); });
}