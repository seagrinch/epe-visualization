// EPE Visualization Tool Editor
//
// Ocean Observatories Initiative 
// Education & Public Engagement Implementing Organization
//
// Written by Mike Mills and Sage Lichtenwalner, Rutgers University
// Revised 6/5/12


/**
 * Instance editor parent object
 */
var tool_instance_editor = function(target_div,name,settings,controls){
	
	this.target_div = target_div;
	
  this.name          = name;
  this.configuration = settings;		
  this.controls      = controls.controls;
  this.tool = eval(this.name);		
  this.initialize();
	
}

/**
 * Initialize
 */
tool_instance_editor.prototype.initialize = function(){
	
	var instance = this;

	// create a new copy of the JSON configuration for saving. keep original in case the user decides to reload
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

/**
 * Control Overrides
 *
 * override the tool defaults with the instance settings
 * we can not do this in the loader because not all controls always have overrides
 * we only need to update those that are defined in the configuration
 */
tool_instance_editor.prototype.control_overrides = function(){
	var instance = this;

	$.each(instance.configuration,function(control){		
	  if (typeof(instance.controls[control])!="undefined")
  		instance.controls[control]["default_value"] = instance.configuration[control];	
	});	
}

/**
 * Redraw
 */
tool_instance_editor.prototype.redraw = function(){
	
	var instance = this;

	// remove children of the display window, which will clear all existing charts
	
	$('#'+instance.target_div).children().remove();

	// reinitalize the instance of the tool, loading the UPDATED instance configuration
	instance.toolInstance = new instance.tool(instance.target_div, instance.current_config);
	
}

/**
 * Load Controls
 */
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
		.addClass("btn pull-right")
		.click(function(){instance.redraw();return false;});
	
	$("#tool_controls").append(el_btn);

}

/**
 * Draw Control
 */
tool_instance_editor.prototype.draw_control = function(id, control){
	
	var self = this;
	
	console.log("ID: " + id + "  Control Type: " + control.type);

	var ctrl;
	switch(control.type){
		case "textbox":
	
			var lbl = $("<label />")
				.attr({'for':id}) //'title':control.tooltip
				.html(control.label);

			var input = document.createElement("input");
			$(input)
				.attr({
					'id':id,
					'type':'textbox',
					'value':control.default_value,
					'title':control.tooltip,
					'maxlength':typeof(control.maxlength)=="undefined"?"":control.maxlength
				})
				.change(function(){
					self.updateJSON()
				});

			ctrl = $("<div></div>").addClass("control").append(lbl).append(input);
			
			break;
		
		case "textarea":
	
			var lbl = $("<label />")
				.attr({'for':id})
				.html(control.label);

			var textarea = document.createElement("textarea");
			$(textarea)
				.attr({
					'id':id,
					'type':'textarea',
					'value':control.default_value,
					'title':control.tooltip,
				})
				.change(function(){
					self.updateJSON()
				});

			ctrl = $("<div></div>").addClass("control").append(lbl).append(textarea);
			
			break;

		case "dropdown":

			var lbl = $("<label />")
				.attr({'for':id,'title':control.tooltip})
				.html(control.label);
				
			// create select element and populate it
			var select = $("<select></select>")
				.attr({"id":id})
				.change(function(){
					self.updateJSON()
				});
			
			$.each(control.options,function(option){
				opt = control.options[option];	
				$(select).append($('<option></option>').val(opt.value).html(opt.name));
			});
			$(select).val(control.default_value);

			ctrl = $("<div></div>").addClass("control").append(lbl).append(select);
		
			break;
		
		case "checkbox":
		
			var lbl = $("<label />")
				.attr({'for':id,'title':control.tooltip})
				.html(control.label);
			
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
				.html(control.label);
			
			var el_input = $("<input />")
				.attr({"id":id,"type":"text"})
				.addClass("readonly span2")
				.val(control.default_value)
				.change(function(){
					self.updateJSON()
				});
				
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
				.html(control.label);
			
			var el_input = $("<input />")
				.attr({"id":id,"type":"text"})
				.addClass("readonly span2")
				.val(control.default_value)
				.change(function(){
					self.updateJSON()
				});
				
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

/**
 * setJSON
 */
tool_instance_editor.prototype.setJSON = function(){
	var instance = this;
	$('#instance_json_config').val(
		$.toJSON(instance.current_config)
	);
}

/**
 * updateJSON
 */
tool_instance_editor.prototype.updateJSON = function(){
	var instance = this;
	$.each(instance.controls,function(control){	
    //console.log(control);
    instance.current_config[control] = $('#'+control).val();
	});
	instance.setJSON();
}

