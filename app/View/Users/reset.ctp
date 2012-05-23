<?php echo $this->Session->flash('auth',array('params'=>array('class'=>'alert alert-error'))); ?>

<?php echo $this->Form->create('User',array('class'=>'form-horizontal'));?>
<div class="row-fluid">
  <div class="span6">
    <fieldset>
      <legend>Reset your Password</legend>
      <p>Please use this form to create a new password for your account.</p>
    	<?php echo $this->Form->input('password'); ?>
    	<?php echo $this->Form->input('password2',array('type'=>'password','label'=>'Confirm Password')); ?>
    </fieldset>
    <div class="form-actions">
      <?php echo $this->Form->submit(__('Change Password <i class="icon-chevron-right icon-white"></i>'),array('class'=>'btn btn-success','div'=>false));?>
    </div>
    <?php echo $this->Form->end();?>
    </div>
  <div class="span6">
  </div>
</div>

