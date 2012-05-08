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
		<li><?php echo $this->Html->link(__('List Vis Instances'), array('controller' => 'visualizations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'visualizations', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Vis Instances');?></h3>
	<?php if (!empty($user['Visualization'])):?>
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
		foreach ($user['Visualization'] as $visualization): ?>
		<tr>
			<td><?php echo $visualization['id'];?></td>
			<td><?php echo $visualization['vis_tool_id'];?></td>
			<td><?php echo $visualization['user_id'];?></td>
			<td><?php echo $visualization['name'];?></td>
			<td><?php echo $visualization['description'];?></td>
			<td><?php echo $visualization['config_settings'];?></td>
			<td><?php echo $visualization['is_public'];?></td>
			<td><?php echo $visualization['provenance_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'visualizations', 'action' => 'view', $visualization['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'visualizations', 'action' => 'edit', $visualization['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'visualizations', 'action' => 'delete', $visualization['id']), null, __('Are you sure you want to delete # %s?', $visualization['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'visualizations', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
