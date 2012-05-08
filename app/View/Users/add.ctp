<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		echo $this->Form->input('is_admin');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Vis Tools'), array('controller' => 'vis_tools', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Tool'), array('controller' => 'vis_tools', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vis Instances'), array('controller' => 'visualizations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'visualizations', 'action' => 'add')); ?> </li>
	</ul>
</div>
