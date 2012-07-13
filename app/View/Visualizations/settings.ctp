{
	"metadata":{
		"name":"<?php echo $visualization['VisTool']['function_name']?>",
		"id":<?php echo $visualization['VisTool']['id']?>,
		"script_url":"<?php echo $this->Html->url( '/', true ) . 'files/tools/vistool' . $visualization['VisTool']['id'] . '.js'?>",
		"css_url":"<?php echo $this->Html->url( '/', true ) . 'files/tools/vistool' . $visualization['VisTool']['id'] . '.css'?>"
	},
	
	"configuration":<?php if (strlen($visualization['Visualization']['config_settings'])>0) {
	  echo $visualization['Visualization']['config_settings'];
	} else {
	  echo "{}";
	}?>
}