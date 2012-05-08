<h2>Custom Visualization #<?php echo h($visualization['Visualization']['id']); ?>: <?php echo h($visualization['Visualization']['name']); ?></h2>
<div class="row">
  <div class="span4 pull-right">
    <h3>Description</h3>
    <p><?php echo h($visualization['Visualization']['description']); ?></p>
    <p><strong>Tool</strong>: <?php echo $this->Html->link($visualization['VisTool']['name'], array('controller' => 'vis_tools', 'action' => 'view', $visualization['VisTool']['id'])); ?></p>
    <p><strong>Status</strong>: <?php echo h($visualization['Visualization']['is_public']); ?></p>
    <p><strong>Author</strong>: <?php echo $this->Html->link($visualization['User']['id'], array('controller' => 'users', 'action' => 'view', $visualization['User']['id'])); ?></p>
    <p><strong>Provenance</strong>: <?php echo $this->Html->link($visualization['Provenance']['name'], array('controller' => 'visualizations', 'action' => 'view', $visualization['Provenance']['id'])); ?></p>
		<p><?php echo $this->Html->link(__('<i class="icon-trash icon-white"></i> Delete Visualization'), array('action' => 'delete', $visualization['Visualization']['id']), array('class'=>'btn btn-danger','escape'=>false), __('Are you sure you want to delete %s?', $visualization['Visualization']['name'])); ?></p>
		<p><?php echo $this->Html->link(__('<i class="icon-edit icon-white"></i> Edit Visualization'), array('action' => 'edit', $visualization['Visualization']['id']),array('class'=>'btn btn-primary','escape'=>false)); ?> </p>
  </div>
  <div class="span8">
    <div id="chart"></div>
    <?php 
    echo $this->Html->script('d3.v2.min');
    echo $this->Html->script('ev_loader');
    ?>
    <script>
      var tool = new tool_instance(<?php echo $visualization['Visualization']['id']; ?>,"chart");
    </script>
  </div>
</div>
