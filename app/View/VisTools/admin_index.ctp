<h2>Visualization Tools - Admin List</h2>

<table class="table table-striped">
  <thead>
	  <tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th><?php echo $this->Paginator->sort('tool_type');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th></th>
	  </tr>
  </thead>
  <tbody>
  	<?php foreach ($visTools as $visTool) { ?>
    <tr>
      <td><?php echo $this->Html->link($visTool['VisTool']['name'], array('action' => 'view', $visTool['VisTool']['id'],'admin'=>false)); ?></td>
      <td><?php echo $visTool['VisTool']['status']; ?></td>
      <td><?php echo h($visTool['VisTool']['tool_type']); ?></td>
      <td><?php App::uses('CakeTime', 'Utility'); echo CakeTime::format('F Y', $visTool['VisTool']['created'], true); ?></td>
    <?php } ?> 
  </tbody>
</table>

<?php echo $this->Paginator->pagination(); ?>