<div class="visTools index">
	<h2><?php echo __('Vis Tools');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('author');?></th>
			<th><?php echo $this->Paginator->sort('institution');?></th>
			<th><?php echo $this->Paginator->sort('keywords');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('tool_type');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($visTools as $visTool): ?>
	<tr>
		<td><?php echo h($visTool['VisTool']['id']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['name']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['author']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['institution']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['keywords']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['description']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['tool_type']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $visTool['VisTool']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $visTool['VisTool']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $visTool['VisTool']['id']), null, __('Are you sure you want to delete # %s?', $visTool['VisTool']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
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
