{
	"tool":{
		"name":"<?php echo $visualization['VisTool']['function_name']?>",
		"id":<?php echo $visualization['VisTool']['id']?>,
		"css":<?php echo $visualization['VisTool']['id']?>
	},
	
	"configuration":<?php if (strlen($visualization['Visualization']['config_settings'])>0) {
	  echo $visualization['Visualization']['config_settings'];
	} else {
	  echo "{}";
	}?>
}