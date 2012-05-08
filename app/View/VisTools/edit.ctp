<h2>Edit and Upload a Visualization Tool</h2>
<p>This page is for system administrators to edit existing visualizations tools, with accompanying source code.  Note, this page will <strong>not</strong> be available to regular users.</p>

<div class="visTools form">
<?php echo $this->Form->create('VisTool',array('type'=>'file','class'=>'well form-horizontal'));?>
	<fieldset>
		<legend>Edit Visualization Tool</legend>
	<?php
	  $status_options = array('Draft'=>'Draft','In Review'=>'In Review','Published'=>'Published');
	  $tool_types = array('Time Series'=>'Time Series','Profile'=>'Profile','Map'=>'Map','Other'=>'Other');
	 
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('label'=>'Tool Name'));
		echo $this->Form->input('function_name',array('helpInline'=>'Please enter the parent class used in the JavaScript code'));
		echo $this->Form->input('status',array('options'=>$status_options));
		echo $this->Form->input('tool_type',array('options'=>$tool_types));
		echo $this->Form->input('description',array('class'=>'span6'));
		echo $this->Form->input('keywords',array('type'=>'text'));
		echo $this->Form->input('author',array('label'=>'Tool Developer'));
		echo $this->Form->input('institution',array('label'=>"Tool Developer's Institution"));
		echo $this->Form->input('config_code',array('rows'=>10,'escape'=>false,'class'=>'span6'));
		echo $this->Form->input('file_source', array('type'=>'file','label'=>'Tool JavaScript Source'));
		echo $this->Form->input('file_css', array('type'=>'file','label'=>'Tool CSS'));
		echo $this->Form->input('file_thumbnail', array('type'=>'file','label'=>'Thumbnail Image'));
	?>
	</fieldset>
<?php echo $this->Form->end(array('label'=>'Save Tool','class'=>'btn btn-primary'));?>