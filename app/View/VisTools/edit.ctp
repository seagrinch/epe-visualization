<div class="visTools form">
<?php echo $this->Form->create('VisTool',array('type'=>'file'));?>
	<fieldset>
		<legend>Edit Visualization Tool</legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('label'=>'Tool Name'));
		echo $this->Form->input('status',array('options'=>array('Draft','In Review','Published')));
		echo $this->Form->input('tool_type',array('options'=>array('Time Series','Profile','Map','Other')));
		echo $this->Form->input('description');
		echo $this->Form->input('author',array('label'=>'Tool Developer'));
		echo $this->Form->input('institution',array('label'=>"Tool Developer's Institution"));
		echo $this->Form->input('keywords',array('type'=>'text'));
		echo $this->Form->input('config_code');
		echo $this->Form->input('file_source', array('type'=>'file','label'=>'Tool JavaScript Source'));
		echo $this->Form->input('file_css', array('type'=>'file','label'=>'Tool CSS'));
		echo $this->Form->input('file_thumbnail', array('type'=>'file','label'=>'Thumbnail Image'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('VisTool.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('VisTool.id'))); ?></li>
    <li>&nbsp;</li>
		<li><?php echo $this->Html->link(__('List Vis Tools'), array('controller' => 'vis_tools', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Tool'), array('controller' => 'vis_tools', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vis Instances'), array('controller' => 'vis_instances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'vis_instances', 'action' => 'add')); ?> </li>
	</ul>
</div>
