// Instance Editor Loader Version 1

/*
	
*/

var tool_instance_editor = function(instance_id,target_div){
	
	// set the instance Id, target_div, and requests object
	this.id = instance_id;
	
	this.target_div = target_div;
	
	this.requests = {};

	// create the placeholder div at the instance level.. this replaces the div creation at the tool level
	this.create_div();

	// now populate the too settings with JSON
	// 1. get_settings() CALLS get_controls() ON SUCCESSFUL JSON RESPONSE
	// 2. get_controls() CALLS get_source() ON SUCCESSFUL JSON RESPONSE
	// 3. get_source() CALLS initialize() ON SUCCESSFUL SCRIPT RESPONSE
	// 4. initialize() OVERRIDES INSTANCE CONFIGURATION, SETS TOOL SOURCE, DRAWS INSTANCE, 
	//		OVERTIDES CONTROL DEFAULTS AND CALLS load_controls() then CALLS setJSON()
	// 5. load_controls() DRAWS CONTROLS
	
	this.get_settings();
	
}

/************************************

	REQUEST FUNCTIONS

************************************/

tool_instance_editor.prototype.get_settings = function(){
	var instance = this;

	instance.requests.instance_settings =  "/visualizations/settings/" + instance.id + ".js";
		
	console.log(instance.requests.instance_settings);

	/*	
		- request the configuration settings as json
		- this is a typical response JSON.. it contains the parent tool and the configuration defaults
		- using the tool id, we then request..
	 	
			- tool source --> tool.source.7.js
			- control configuration --> tool.controls.7.js"
	
				{
					"tool":{
						"name":"EVtool_TimeSeriesA",
						"id":7,
						"css":5
					},

					"configuration":{
						"buoy_id":"44025",
						"start_date":"2012-02-01",
						"end_date":"2012-02-14",
						"color":"#000000"
					}
				}
	*/
	
	$.getJSON(instance.requests.instance_settings, function(instance_settings_json) {
	
		console.log(instance_settings_json);
	
		// now set the object configuration from the json response
		// might need to combine this object with a predefined defaults configuration even though it is set in tool
		
		instance.configuration = instance_settings_json.configuration;
		
		instance.metadata = instance_settings_json.tool;
		//instance.tool_id = instance_settings_json.tool.id;
		
		//	need to request controls config separately
		//	var url_config = "tool.controls." + instance_settings_json.tool.id + ".js";
		
		// set the request url for the tool controls
		instance.requests.tool_controls = "/vis_tools/settings/" + instance_settings_json.tool.id + ".js";
		
		// set the request url for the tool source
		instance.requests.tool_source = "/files/tools/vistool" + instance_settings_json.tool.id + ".js";
		
		// request the tool controls
		instance.get_controls();
		
	});
	
	// now that this is complete, let's grab the associated scripts
	//	var url_source = "tool.source." + json.tool.id + ".js";
	//	console.log("URL Source: " + url_source);	
	
}

tool_instance_editor.prototype.get_controls = function(){
	
	var instance = this;
	
	$.getJSON(instance.requests.tool_controls, function(controls_json) {
		
		// set the controls object from the JSON response
		instance.controls = controls_json.controls;
		
		console.log(controls_json);
		
		instance.get_source();
		
	});
	
}

tool_instance_editor.prototype.get_source = function(){
	var instance = this;
	
	$.getScript(instance.requests.tool_source, function(script, source_status, source_jsonxhr) {

		console.log("Tool Source Loaded. Now load tool control configuration");

		console.log(instance);
		// set tool source in object
		instance.tool = eval(instance.metadata.name);
		
		instance.initialize();

	})
	.fail(function(source_jsonxhr, settings, exception) {
	  	console.log("ajax error: " );
		console.log(exception);
	  	console.log(settings);
	});
	
}


/************************************
	
	INSTANCE OVERRIDE FUNCTIONS

************************************/

tool_instance_editor.prototype.control_overrides = function(){
	var instance = this;
		
	// override the tool defaults with the instance settings
	// we can not do this in the loader because not all controls always have overrides
	// we only need to update those that are defined in the configuration
	
	$.each(instance.configuration,function(control){		
	  if (typeof(instance.controls[control])!="undefined")
  		instance.controls[control]["default_value"] = instance.configuration[control];	
	});	
}

/************************************

	DRAWING AND UPDATING FUNCTIONS

************************************/

tool_instance_editor.prototype.create_div = function(){

	// no need to dynamically create the div for the instance editor
	$("<div>")
		.attr("id", this.target_div)
		.html('<img id="loading_'+ this.target_div + '" src="' + '/img/' + 'loading_a.gif" alt="Loading..."/>')
		.appendTo('#instance_display');

	console.log("create div " + this.target_div);
	
}

tool_instance_editor.prototype.initialize = function(){
	
	var instance = this;

	// create a new copy of the JSON configuraiton for saving. keep original in case the user decides to reload
	var current_config = instance.configuration;
	instance.current_config = current_config;
	
	// initalize the new instance of the tool, loading the instance configuration
	instance.toolInstance = new instance.tool(instance.target_div, instance.configuration);

	// override the control defaults with the instnace
	instance.control_overrides();
	
	// load the controls
	instance.load_controls();
	
	// update the default json
	
	instance.setJSON();
}

tool_instance_editor.prototype.redraw = function(){
	
	var instance = this;

	// remove children of the display window, which will clear all existing charts
	
	$('#'+instance.target_div).children().remove();

	// reinitialize the chart	
	// reinitalize the instance of the tool, loading the UPDATED instance configuration
	instance.toolInstance = new instance.tool(instance.target_div, instance.current_config);
	
}

tool_instance_editor.prototype.load_controls = function(){

	var instance = this;
	
	// draw each control to the page
	
	$.each(instance.controls,function(control){
		
		$("#tool_controls")
			.append(
				$(
					instance.draw_control(control, instance.controls[control])
				).addClass("ctlhandle")
			);

	});	
	
	// now draw an update button that will redraw the instance
	
	var el_btn = $("<button>Update Visualization</button>")
		.addClass("btn")
		.click(function(){instance.redraw();return false;});
	
	$("#tool_controls").append(el_btn);
			
	
}

tool_instance_editor.prototype.draw_control = function(id, control){
	
	var self = this;
	
	console.log("ID: " + id + "  Control Type: " + control.type);

	var ctrl;
	switch(control.type){
		case "textbox":
	
			var lbl = $("<label />")
				.attr({'for':id}) //'title':control.tooltip
				.html(control.description);

			var input = document.createElement("input");
			$(input)
				.attr({
					'id':id,
					'type':'textbox',
					'value':control.default_value,
					'title':control.tooltip,
					'maxlength':typeof(control.maxlength)=="undefined"?"":control.maxlength
				})
				.addClass("span2");

			ctrl = $("<div></div>").addClass("control").append(lbl).append(input);
			
			break;
		
		case "dropdown":

			var lbl = $("<label />")
				.attr({'for':id,'title':control.tooltip})
				.html(control.description);
				
			// create select element and populate it
			var select = $("<select></select>")
				.addClass("span2")
				.attr({"id":id})
				.change(function(){
					self.updateJSON()
				});
			
			$.each(control.options,function(option){
				opt = control.options[option];	
				$(select).append($('<option></option>').val(opt.value).html(opt.name));
			});
			
			ctrl = $("<div></div>").addClass("control").append(lbl).append(select);
		
			break;
		
		case "checkbox":
		
			var lbl = $("<label />")
				.attr({'for':id,'title':control.tooltip})
				.html(control.description);
			
			var input = document.createElement("input");
			$(input)
				.attr({
					'id':id,
					'type':'checkbox',
					//'value':control.default_value,
					'title':control.tooltip,
					'maxlength':typeof(control.maxlength)=="undefined"?"":control.maxlength,
					//'onclick':function(){alert("test");}
				});
			if(control.selected) $(input).attr({'checked':'checked'})
		
			ctrl = $("<div></div>").addClass("control").append(lbl).append(input);
			
			break;
				
		case "svg":

			var ctrl = document.createElement("svg");
			
			break;
		
		case "datepicker":
			
			var el_lbl = $("<label />")
				.attr({'for':id+"_dp",'title':control.tooltip})
				.html(control.description);
			
			var el_input = $("<input />")
				.attr({"id":id,"type":"text"})
				.addClass("readonly span2")
				.val(control.default_value);
				
			var el_i = $("<i></i>").css("background-color",control.default_value);
			var el_span = $("<span></span>").addClass("add-on").append(el_i);
			
			var el_div = $("<div></div>")
				.addClass("input-append date")
				.attr({"id":id+"_cp","data-date":control.default_value,"data-date-format":"yyyy-mm-dd"})
				.append(el_input)
				.append(el_span);
				
			$(el_div).datepicker()
			 .on("changeDate",function(dp){	
 				self.updateJSON();			
 			});
				
			ctrl = $("<div></div>")
					.addClass("control ctlhandle")
					.append(el_lbl)
					.append(el_div);
					
			break;
			
		case "colorpicker":
		
			// recursive function to call text box and apply color picker on top of it
			//control.type="textbox";
			
			//ctrl = self.draw_control(id,control);
			//ctrl = self.draw_control(id+"_cp",control);

			// find the textbox in the control and init colorpicker
			var el_lbl = $("<label />")
				.attr({'for':id+"_cp",'title':control.tooltip})
				.html(control.description);
			
			var el_input = $("<input />")
				.attr({"id":id,"type":"text"})
				.addClass("readonly span2")
				.val(control.default_value);
				
			var el_i = $("<i></i>").css("background-color",control.default_value);
			var el_span = $("<span></span>").addClass("add-on").append(el_i);
			
			var el_div = $("<div></div>")
				.addClass("input-append color")
				.attr({"id":id+"_cp","data-color":control.default_value,"data-color-format":"hex"})
				.append(el_input)
				.append(el_span)
				
			$(el_div).colorpicker().on("changeColor",function(cp){
				$("#"+id).val(self.current_config[id] = cp.color.toHex())	
				self.updateJSON();			
			});
				
			ctrl = $("<div></div>")
					.addClass("control ctlhandle")
					.append(el_lbl)
					.append(el_div);
			
			break;
		
		default: 
			ctrl = document.createElement("div");
			break;
			
			// recursive needs removed when converting bootstrap elements to components
			// 
			// recursive function to call text box and apply date picker on top of it
			// 		// change the control type to text box and create textbox control
			// 		//control.type = "textbox";
			// 		ctrl = self.draw_control(id,control);
			// 		//ctrl = self.draw_control(id+"_dp",control);
	}
	
	
	// now attach the popover to the div container for the control
	$(ctrl)
		.attr({'rel':'popover','title':control.label,'data-content':control.tooltip})
		.popover();
	
	return ctrl;
	
}

tool_instance_editor.prototype.setJSON = function(){
	var instance = this;
	$('#instance_json_config').html(
		$.toJSON(instance.current_config)
	);
}

tool_instance_editor.prototype.updateJSON = function(){

	var instance = this;
	
	$.each(instance.controls,function(control){	
//		console.log(control);
		instance.current_config[control] = $('#'+control).val();

	});

	instance.setJSON();
}

