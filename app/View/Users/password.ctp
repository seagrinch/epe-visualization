<?php echo $this->Session->flash('auth',array('params'=>array('class'=>'alert alert-error'))); ?>

<?php echo $this->Form->create('User',array('class'=>'form-horizontal'));?>
<div class="row-fluid">
  <div class="span6">
    <fieldset>
      <legend>Reset your Password</legend>
      <p>If you have forgotten your password, please enter your email here and we will send you instructions on how to reset your password.</p>
	    <?php echo $this->Form->input('email'); ?>
    </fieldset>
    <div class="form-actions">
      <?php echo $this->Form->submit(__('Reset Password <i class="icon-chevron-right icon-white"></i>'),array('class'=>'btn btn-success','div'=>false));?>
    </div>
    <?php echo $this->Form->end();?>
    </div>
  <div class="span6">
  </div>
</div>

