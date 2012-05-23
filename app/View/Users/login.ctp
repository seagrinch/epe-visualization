<?php echo $this->Session->flash('auth',array('params'=>array('class'=>'alert alert-error'))); ?>

<?php echo $this->Form->create('User',array('class'=>'form-horizontal'));?>
<div class="row-fluid">
  <div class="span6">
    <fieldset>
      <legend>Wizard Login</legend>
	    <?php echo $this->Form->input('username'); ?>
	    <?php echo $this->Form->input('password'); ?>
    </fieldset>
    <div class="form-actions">
      <?php echo $this->Html->link('Reset Your Password',array('controller'=>'users','action'=>'password'),array('class'=>'btn btn-warning'));?> &nbsp;
      <?php echo $this->Form->submit(__('Login <i class="icon-chevron-right icon-white"></i>'),array('class'=>'btn btn-success','div'=>false));?>
    </div>
    <?php echo $this->Form->end();?>
    </div>
    <div class="span6">
      <fieldset>
        <legend>Register</legend>
        <p>Don't yet have an account?</p>
        <p><?php echo $this->Html->link('Create an Account <i class="icon-chevron-right icon-white"></i>',array('controller'=>'users','action'=>'register'),array('class'=>'btn btn-success','escape'=>false));?> </p>
    </fieldset> 	   
  </div>
</div>

