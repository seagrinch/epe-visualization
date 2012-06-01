// Instance Loader Version 1

// page loads tool 5

/*
1. request is made for instance settings
	- inc/instance.settings.5.js
	- instance settings contains instance id, tool id [,and dependencies] and instance configuration
	
	EXAMPLE:
	
	{
		"tool":{
			"name":"EVtool_TimeSeriesA",
			"tool_id":5,
			"tool_css":5
		},

		"configuration":{
			"buoy_id":"44025",
			"start_date":"2012-02-01",
			"end_date":"2012-02-14",
			"color":"#000000"
		}
	}

2. request is made for tool source
	- inc/tool.source.5.js
*/


var tool_instance = function(instance_id,target_div){ //   do we want to also pass some security settings here? 
	
	// set the instance Id
	this.id = instance_id;
	this.target_div = target_div;

	// create the placeholder div at the instance level.. this replaces the div creation at the tool level
	this.create_div();

	// now populate the too settings with JSON
	this.get_settings();
	
}

tool_instance.prototype.create_div = function(){

	$("<div>")
		.attr("id", this.target_div)
		.html('<img id="loading_'+ this.target_div + '" src="' + '/img/' + 'loading_a.gif" alt="Loading..."/>')
		.appendTo('body');

	console.log("create div " + this.target_div);
	
}

tool_instance.prototype.get_settings = function(){
	var self = this;

	var url_instance_config = EV_BASE_URL + "visualizations/settings/" + self.id + ".js";
	console.log(url_instance_config);
	
	// request the configuration settings as json
	$.getJSON(url_instance_config, { toolid:5 }, function(json) {
		self.configuration = json.configuration;
		self.metadata = json.tool;
		self.name = json.tool.name;
		
		// now that this is complete, let's grab the associated scripts
		var url_source = EV_BASE_URL + "files/tools/vistool" + json.tool.id + ".js";
		console.log("URL Source: " + url_source);
		
		$.getScript(url_source, function(script, source_status, source_jsonxhr) {
	  
			//console.log(script); //data returned
			console.log(source_status); //success
			console.log(source_jsonxhr.status); //200
			console.log("Tool Source Loaded.");
		
			self.tool = eval(self.name);
			var b = new self.tool(self.target_div, self.configuration);
			
			//

		})
		.fail(function(source_jsonxhr, settings, exception) {
		  	console.log("ajax error: " );
			console.log(exception);
		  	console.log(settings);
		});
		
	});
	
}