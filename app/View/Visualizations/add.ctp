<h2>Create a New Custom Visualization</h2>
<?php echo $this->Form->create('Visualization', array('class'=>'well form-horizontal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('vis_tool_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('is_public');
		echo $this->Form->input('provenance_id',array('empty'=>''));
    echo '<hr>';
//		echo $this->Form->input('config_settings');
		echo $this->Form->input('color',array('after'=>'CSS color or hex'));
		echo $this->Form->input('data',array('after'=>'Enter data in the appropriate format, [1,2,3] or [{x:10.0, y:9.14}, {x:8.0, y:8.14},]'));
	?>
	</fieldset>
<?php echo $this->Form->end(array('label'=>'Create Visualization','class'=>'btn btn-primary'));?>
