	<h2>Custom Visualizations</h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('VisTool.name');?></th>
			<th><?php echo $this->Paginator->sort('User.username');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('is_public');?></th>
			<th><?php echo $this->Paginator->sort('provenance_id');?></th>
	</tr>
	<?php
	foreach ($visualizations as $visualization): ?>
	<tr>
		<td><?php echo h($visualization['Visualization']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($visualization['Visualization']['name'], array('action' => 'view', $visualization['Visualization']['id'])); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($visualization['VisTool']['name'], array('controller' => 'vis_tools', 'action' => 'view', $visualization['VisTool']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($visualization['User']['username'], array('controller' => 'users', 'action' => 'view', $visualization['User']['id'])); ?>
		</td>
		<td><?php echo h($visualization['Visualization']['description']); ?>&nbsp;</td>
		<td><?php echo h($visualization['Visualization']['is_public']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($visualization['Provenance']['name'], array('controller' => 'visualizations', 'action' => 'view', $visualization['Provenance']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

<?php echo $this->Paginator->pagination(); ?>

<?php echo $this->Html->link('Create a New Custom Visualization', array('action' => 'add'),array('class'=>'btn btn-primary')); ?>