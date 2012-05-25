<h2>Visualization Tool: <?php echo h($visTool['VisTool']['name']); ?></h2>
		<?php if ($this->Session->read('Auth.User.is_admin')) { ?>
		  <div class="pull-right">
		  <?php echo $this->Form->postLink(__('Delete Tool'), array('action' => 'delete', $visTool['VisTool']['id'],'admin'=>true), array('class'=>'btn btn-danger'), __('Are you sure you want to delete %s?', $visTool['VisTool']['name'])); ?>
		  <?php echo $this->Html->link(__('Edit Tool'), array('action' => 'edit', $visTool['VisTool']['id'],'admin'=>true),array('class'=>'btn btn-primary')); ?> 
  		</div>
		<?php } ?> 
<div class="row">
  <div class="span4 pull-right">
    <h3>Description</h3>
    <p><?php echo h($visTool['VisTool']['description']); ?></p>
    <p><strong>Keywords</strong>: <?php echo h($visTool['VisTool']['keywords']); ?></p>
    <p><strong>Tool Type</strong>: <?php echo h($visTool['VisTool']['tool_type']); ?></p>
    <p><strong>Status</strong>: <?php echo h($visTool['VisTool']['status']); ?></p>
    <p><strong>Author</strong>: <?php echo h($visTool['VisTool']['author']); ?></p>
    <p><strong>Institution</strong>: <?php echo h($visTool['VisTool']['institution']); ?></p>
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
	  <?php if (!empty($instances)):?>
	  <table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<tr>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Creator'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($instances as $instance): ?>
		<tr>
			<td><?php echo $this->Html->link($instance['Visualization']['name'], array('controller' => 'visualizations', 'action' => 'view', $instance['Visualization']['id'])); ?></td>
			<td><?php echo $instance['Visualization']['description'];?></td>
			<td><?php echo $instance['User']['name'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

			<p><?php echo $this->Html->link(__('Customize this Tool'), array('controller' => 'visualizations', 'action' => 'create', $visTool['VisTool']['id']),array('class'=>'btn btn-primary'));?> </p>
  </div>
  <div class="span4">&nbsp;
  </div>
</div>
