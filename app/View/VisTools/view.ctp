<div class="visTools view">
<h2><?php  echo __('Vis Tool');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($visTool['VisTool']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($visTool['VisTool']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Author'); ?></dt>
		<dd>
			<?php echo h($visTool['VisTool']['author']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Institution'); ?></dt>
		<dd>
			<?php echo h($visTool['VisTool']['institution']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keywords'); ?></dt>
		<dd>
			<?php echo h($visTool['VisTool']['keywords']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($visTool['VisTool']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tool Type'); ?></dt>
		<dd>
			<?php echo h($visTool['VisTool']['tool_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($visTool['VisTool']['status']); ?>
			&nbsp;
		</dd>
	</dl>


<p>Graph should go here.</p>
<div id="chart"></div>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vis Tool'), array('action' => 'edit', $visTool['VisTool']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vis Tool'), array('action' => 'delete', $visTool['VisTool']['id']), null, __('Are you sure you want to delete # %s?', $visTool['VisTool']['id'])); ?> </li>
    <li>&nbsp;</li>
		<li><?php echo $this->Html->link(__('List Vis Tools'), array('controller' => 'vis_tools', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Tool'), array('controller' => 'vis_tools', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vis Instances'), array('controller' => 'vis_instances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'vis_instances', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Vis Instances');?></h3>
	<?php if (!empty($visTool['VisInstance'])):?>
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
		foreach ($visTool['VisInstance'] as $visInstance): ?>
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

<?php 
echo $this->Html->script('d3.v2.min');
echo $this->Html->script('/files/tools/vistool' . $visTool['VisTool']['id'] . '.js');
echo $this->Html->css('/files/tools/vistool' . $visTool['VisTool']['id'] . '.css');
?>
<script>
chart();
</script>