<div class="visInstances view">
<h2>#<?php echo h($visInstance['VisInstance']['id']); ?> <?php echo h($visInstance['VisInstance']['name']); ?></h2>
<p>Graph should go here.</p>
<div id="chart"></div>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($visInstance['VisInstance']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vis Tool'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visInstance['VisTool']['name'], array('controller' => 'vis_tools', 'action' => 'view', $visInstance['VisTool']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visInstance['User']['id'], array('controller' => 'users', 'action' => 'view', $visInstance['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($visInstance['VisInstance']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($visInstance['VisInstance']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Config Settings'); ?></dt>
		<dd>
			<?php echo h($visInstance['VisInstance']['config_settings']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Public'); ?></dt>
		<dd>
			<?php echo h($visInstance['VisInstance']['is_public']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Provenance'); ?></dt>
		<dd>
			<?php echo $this->Html->link($visInstance['Provenance']['name'], array('controller' => 'vis_instances', 'action' => 'view', $visInstance['Provenance']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>


<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vis Instance'), array('action' => 'edit', $visInstance['VisInstance']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vis Instance'), array('action' => 'delete', $visInstance['VisInstance']['id']), null, __('Are you sure you want to delete # %s?', $visInstance['VisInstance']['id'])); ?> </li>
    <li>&nbsp;</li>
		<li><?php echo $this->Html->link(__('List Vis Tools'), array('controller' => 'vis_tools', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Tool'), array('controller' => 'vis_tools', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Vis Instances'), array('controller' => 'vis_instances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vis Instance'), array('controller' => 'vis_instances', 'action' => 'add')); ?> </li>
	</ul>
</div>

<?php 
echo $this->Html->script('d3.v2.min');
echo $this->Html->script($visInstance['VisTool']['source_code']);
echo $this->Html->css($visInstance['VisTool']['source_code']);
?>
<script>
chart( <?php echo $visInstance['VisInstance']['config_settings']?> );
</script>