<div class="visInstances index">
	<h2><?php echo __('Vis Instances');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('vis_tool_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('is_public');?></th>
			<th><?php echo $this->Paginator->sort('provenance_id');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($visInstances as $visInstance): ?>
	<tr>
		<td><?php echo h($visInstance['VisInstance']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($visInstance['VisTool']['name'], array('controller' => 'vis_tools', 'action' => 'view', $visInstance['VisTool']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($visInstance['User']['username'], array('controller' => 'users', 'action' => 'view', $visInstance['User']['id'])); ?>
		</td>
		<td><?php echo h($visInstance['VisInstance']['name']); ?>&nbsp;</td>
		<td><?php echo h($visInstance['VisInstance']['description']); ?>&nbsp;</td>
		<td><?php echo h($visInstance['VisInstance']['is_public']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($visInstance['Provenance']['name'], array('controller' => 'vis_instances', 'action' => 'view', $visInstance['Provenance']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $visInstance['VisInstance']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $visInstance['VisInstance']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $visInstance['VisInstance']['id']), null, __('Are you sure you want to delete # %s?', $visInstance['VisInstance']['id'])); ?>
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


