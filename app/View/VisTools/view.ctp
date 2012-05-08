<h2>Visualization Tool: <?php echo h($visTool['VisTool']['name']); ?></h2>
<div class="row">
  <div class="span4 pull-right">
    <h3>Description</h3>
    <p><?php echo h($visTool['VisTool']['description']); ?></p>
    <p><strong>Keywords</strong>: <?php echo h($visTool['VisTool']['keywords']); ?></p>
    <p><strong>Tool Type</strong>: <?php echo h($visTool['VisTool']['tool_type']); ?></p>
    <p><strong>Status</strong>: <?php echo h($visTool['VisTool']['status']); ?></p>
    <p><strong>Author</strong>: <?php echo h($visTool['VisTool']['author']); ?></p>
    <p><strong>Institution</strong>: <?php echo h($visTool['VisTool']['institution']); ?></p>
		<p><?php echo $this->Form->postLink(__('Delete Tool'), array('action' => 'delete', $visTool['VisTool']['id']), array('class'=>'btn btn-danger'), __('Are you sure you want to delete %s?', $visTool['VisTool']['name'])); ?> <?php echo $this->Html->link(__('Edit Tool'), array('action' => 'edit', $visTool['VisTool']['id']),array('class'=>'btn btn-primary')); ?> </p>
  </div>
  <div class="span8">
    <h3>Example tool with default settings</h3>
    <div id="chart"></div>
    <?php 
    echo $this->Html->script('d3.v2.min');
    echo $this->Html->script('/files/tools/vistool' . $visTool['VisTool']['id'] . '.js');
    echo $this->Html->css('/files/tools/vistool' . $visTool['VisTool']['id'] . '.css');
    ?>
    <script>
      self.tool = eval(<?php echo h($visTool['VisTool']['function_name']); ?>);
      var b = new self.tool('chart', '');
    </script>
  </div>
</div>
<div class="row">
  <div class="span8">
    <h3>Custom Visualizations</h3>
	  <?php if (!empty($visTool['Visualization'])):?>
	  <table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Is Public'); ?></th>
		<th><?php echo __('Provenance Id'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($visTool['Visualization'] as $visualization): ?>
		<tr>
			<td><?php echo $visualization['id'];?></td>
			<td><?php echo $this->Html->link($visualization['name'], array('controller' => 'visualizations', 'action' => 'view', $visualization['id'])); ?></td>
			<td><?php echo $visualization['description'];?></td>
			<td><?php echo $visualization['is_public'];?></td>
			<td><?php echo $visualization['provenance_id'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

			<p><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'visualizations', 'action' => 'add', $visTool['VisTool']['id']),array('class'=>'btn btn-primary'));?> </p>
  </div>
  <div class="span4">&nbsp;
  </div>
</div>
