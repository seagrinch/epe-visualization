<div class="row">
  <div class="span4 pull-right well">
    <h3><?php echo h($visualization['Visualization']['name']); ?></h3>
    <p><?php echo h($visualization['Visualization']['description']); ?></p>
    <p><strong>Tool</strong>: <?php echo $this->Html->link($visualization['VisTool']['name'], array('controller' => 'vis_tools', 'action' => 'view', $visualization['VisTool']['id'])); ?></p>
    <p><strong>Status</strong>: <?php echo ($visualization['Visualization']['is_public']?'Public':'Private'); ?></p>
    <p><strong>Author</strong>: <?php echo $this->Html->link($visualization['User']['name'], array('controller' => 'users', 'action' => 'view', $visualization['User']['id'])); ?></p>
    <?php if ($visualization['Provenance']['id']) { ?>
      <p><strong>Provenance</strong>: <?php echo $this->Html->link($visualization['Provenance']['name'], array('controller' => 'visualizations', 'action' => 'view', $visualization['Provenance']['id'])); ?></p>
		<?php } ?> 
		<?php if ($this->Session->read('Auth.User.id')==$visualization['Visualization']['user_id']) { ?>
		  <?php echo $this->Html->link(__('<i class="icon-trash icon-white"></i> Delete'), array('action' => 'delete', $visualization['Visualization']['id']), array('class'=>'btn btn-danger','escape'=>false), __('Are you sure you want to delete %s?', $visualization['Visualization']['name'])); ?>
		  <?php echo $this->Html->link(__('<i class="icon-edit icon-white"></i> Edit'), array('action' => 'edit', $visualization['Visualization']['id']),array('class'=>'btn btn-primary','escape'=>false)); ?>
		<?php } ?> 
		<?php if ($this->Session->read('Auth.User.id')) { ?>
      <?php echo $this->Html->link(__('<i class="icon-plus icon-white"></i> Copy'), array('action' => 'copy', $visualization['Visualization']['id']),array('class'=>'btn btn-primary','escape'=>false)); ?>
		<?php } ?> 
  </div>
  <div class="span8">
    <div id="chart"></div>
    <?php echo $this->Html->script('d3.v2.min'); ?>
    <?php echo $this->Html->scriptBlock('var EV_BASE_URL="' . $this->Html->url( '/', true ) . '";'); ?>
    <?php echo $this->Html->script('ev_loader'); ?>
    <script>
      var tool = new tool_instance(<?php echo $visualization['Visualization']['id']; ?>,"chart");
    </script>
  </div>
</div>
