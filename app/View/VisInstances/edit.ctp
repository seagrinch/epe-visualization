<div class="visInstances form">
<?php echo $this->Form->create('VisInstance');?>
	<fieldset>
		<legend><?php echo __('Edit Vis Instance'); ?></legend>
	<?php
		echo $this->Form->input('id');
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
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('View Instance'), array('controller' => 'vis_instances', 'action' => 'view', $this->request->data['VisInstance']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('VisInstance.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('VisInstance.id'))); ?></li>
    <li>&nbsp;</li>
		<li><?php echo $this->Html->link(__('List Vis Tools'), array('controller' => 'vis_tools', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Tool'), array('controller' => 'vis_tools', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vis Instances'), array('controller' => 'vis_instances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'vis_instances', 'action' => 'add')); ?> </li>
	</ul>
</div>
