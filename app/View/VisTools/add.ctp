<div class="visTools form">
<?php echo $this->Form->create('VisTool');?>
	<fieldset>
		<legend><?php echo __('Add Vis Tool'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('author');
		echo $this->Form->input('institution');
		echo $this->Form->input('keywords');
		echo $this->Form->input('description');
		echo $this->Form->input('source_code');
		echo $this->Form->input('config_code');
		echo $this->Form->input('tool_type');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Vis Tools'), array('controller' => 'vis_tools', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Tool'), array('controller' => 'vis_tools', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vis Instances'), array('controller' => 'vis_instances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'vis_instances', 'action' => 'add')); ?> </li>
	</ul>
</div>
