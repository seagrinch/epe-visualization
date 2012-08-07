	<h2>Custom Visualizations</h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('VisTool.name','Visualization Tool');?></th>
			<th><?php echo $this->Paginator->sort('User.name','User');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
	</tr>
	<?php
	foreach ($visualizations as $visualization): ?>
	<tr>
		<td><?php echo h($visualization['Visualization']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link('<i class="icon-signal"></i> ' . $visualization['Visualization']['name'], array('action' => 'view', $visualization['Visualization']['id']),array('escape'=>false)); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link('<i class="icon-wrench"></i>', array('controller' => 'vis_tools', 'action' => 'view', $visualization['VisTool']['id']),array('escape'=>false)); ?> <?php echo $visualization['VisTool']['name']?>
		</td>
		<td>
			<?php echo $this->Html->link($visualization['User']['name'], array('controller' => 'users', 'action' => 'profile', $visualization['User']['username'])); ?>
		</td>
		<td><?php echo h($visualization['Visualization']['description']); ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($visualization['Visualization']['created']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>

<?php echo $this->Paginator->pagination(); ?>

<?php echo $this->Html->link('Visualization Tool List', array('controller'=>'vis_tools','action' => 'index'),array('class'=>'btn btn-primary')); ?>
