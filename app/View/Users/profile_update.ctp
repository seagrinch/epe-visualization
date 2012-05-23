<h1>Update your Profile</h1>
<?php echo $this->Session->flash('auth',array('params'=>array('class'=>'alert alert-error'))); ?>

<?php echo $this->Form->create('User',array('class'=>'form-horizontal'));?>
<div class="row-fluid">
  <div class="span6">
  	<fieldset>
  		<legend>Account Information</legend>
    	<?php echo $this->Form->input('name',array('label'=>'Full Name')); ?>
    	<?php echo $this->Form->input('email'); ?>
    	<?php echo $this->Form->input('password'); ?>
    	<?php echo $this->Form->input('password2',array('type'=>'password','label'=>'Confirm Password')); ?>
  	</fieldset>
  </div>
  <div class="span6">
  	<fieldset>
  		<legend>Additional Information</legend>
  		<p>Please help the COSEE NOW team serve you better by letting us know a little about yourself.</p>
    	<?php 
    	echo $this->Form->input('institution',array('label'=>'University/Institution'));
    	echo $this->Form->input('career_stage',array('label'=>'Career Stage<br/>','options'=>$career_stages,'empty'=>true));
    	echo $this->Form->input('research_field',array('label'=>'Research Field'));
    	echo $this->Form->input('state',array('label'=>'State ','options'=>$this->Geography->states,'empty'=>true)); ?>
	</fieldset>
  </div>

</div>
<?php echo $this->Form->submit('Update',array('class'=>'btn pull-right'));?>
<?php echo $this->Form->end();?>
