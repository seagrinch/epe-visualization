<h2>Visualization Tools</h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('author');?></th>
			<th><?php echo $this->Paginator->sort('institution');?></th>
			<th><?php echo $this->Paginator->sort('keywords');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('tool_type');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
	</tr>
	<?php
	foreach ($visTools as $visTool): ?>
	<tr>
		<td><?php echo h($visTool['VisTool']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($visTool['VisTool']['name'], array('action' => 'view', $visTool['VisTool']['id'])); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['author']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['institution']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['keywords']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['description']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['tool_type']); ?>&nbsp;</td>
		<td><?php echo h($visTool['VisTool']['status']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>

<?php echo $this->Paginator->pagination(); ?>