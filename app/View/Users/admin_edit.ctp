<h1>Admin: Edit User</h1>
<?php echo $this->Session->flash('auth',array('params'=>array('class'=>'alert alert-error'))); ?>
<div class="pull-right"><?php echo $this->Html->link(__('Return to Users List'), array('action' => 'index'),array('class'=>'btn btn-primary'));?></div>
<div style="clear:both;"></div>

<?php echo $this->Form->create('User',array('class'=>'form-horizontal'));?>
<div class="row-fluid">
  <div class="span6">
  	<fieldset>
  		<legend>Account Information</legend>
    	<?php echo $this->Form->input('name',array('label'=>'Full Name')); ?>
    	<?php echo $this->Form->input('email'); ?>
    	<?php echo $this->Form->input('username',array('disabled'=>true)); ?>
    	<?php echo $this->Form->input('password'); ?>
    	<?php echo $this->Form->input('password2',array('type'=>'password','label'=>'Confirm Password')); ?>
    	<?php echo $this->Form->input('is_admin',array('label'=>'Site Administrator','options'=>array(0=>'No',1=>'Yes'))); ?>
  	</fieldset>
  </div>
  <div class="span6">
  	<fieldset>
  		<legend>Additional Information</legend>
  		<p>Please help the COSEE NOW team serve you better by letting us know a little about yourself.</p>
    	<?php 
    	echo $this->Form->input('institution',array('label'=>'University/Institution Name'));
    	echo $this->Form->input('career_stage',array('label'=>'Career Stage<br/>','options'=>$career_stages,'empty'=>true));
    	echo $this->Form->input('research_field',array('label'=>'Research Field'));
    	echo $this->Form->input('state',array('label'=>'State ','options'=>$this->Geography->states,'empty'=>true)); ?>
	</fieldset>
  </div>

</div>
<?php echo $this->Form->submit('Update',array('class'=>'btn pull-right'));?>
<?php echo $this->Form->end();?>
