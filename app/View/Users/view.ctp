<div class="users view">
<h2><?php  echo __('User');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Admin'); ?></dt>
		<dd>
			<?php echo h($user['User']['is_admin']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vis Instances'), array('controller' => 'vis_instances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'vis_instances', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Vis Instances');?></h3>
	<?php if (!empty($user['VisInstance'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Vis Tool Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Config Settings'); ?></th>
		<th><?php echo __('Is Public'); ?></th>
		<th><?php echo __('Provenance Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['VisInstance'] as $visInstance): ?>
		<tr>
			<td><?php echo $visInstance['id'];?></td>
			<td><?php echo $visInstance['vis_tool_id'];?></td>
			<td><?php echo $visInstance['user_id'];?></td>
			<td><?php echo $visInstance['name'];?></td>
			<td><?php echo $visInstance['description'];?></td>
			<td><?php echo $visInstance['config_settings'];?></td>
			<td><?php echo $visInstance['is_public'];?></td>
			<td><?php echo $visInstance['provenance_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'vis_instances', 'action' => 'view', $visInstance['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'vis_instances', 'action' => 'edit', $visInstance['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'vis_instances', 'action' => 'delete', $visInstance['id']), null, __('Are you sure you want to delete # %s?', $visInstance['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'vis_instances', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
