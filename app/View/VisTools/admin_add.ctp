<h2>Create a New Visualization Tool</h2>
  <p>This page allows system administrators to begin adding new visualizations tools to the site, incluidng uploading necessary source code.  This page will <strong>not</strong> be available to regular users.</p>

<?php echo $this->Form->create('VisTool', array('class'=>'well form-horizontal'));?>
	<fieldset>
	  <legend>Step 1</legend>
	    <?php echo $this->Form->input('name',array('label'=>'Tool Name','helpBlock'=>'You can always change this later')); ?>	
	</fieldset>
<?php echo $this->Form->end(array('label'=>'Create Tool','class'=>'btn btn-primary'));?>
