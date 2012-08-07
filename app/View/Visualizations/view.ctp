<div class="row-fluid">
  <div class="span9">
    <div id="chart"></div>
    <?php echo $this->Html->script('d3.v2.min'); ?>
    <?php echo $this->Html->script('ev_loader'); ?>
    <script>
      var vistool = new ToolLoader("<?php echo $this->Html->url(array('action'=>'settings',$visualization['Visualization']['id'])) ?>","chart");
    </script>
  </div>
  <div class="span3 well">
    <h3><?php echo h($visualization['Visualization']['name']); ?></h3>
    <p><?php echo h($visualization['Visualization']['description']); ?></p>
    <?php if ($visualization['Provenance']['id']) { ?>
      <p><strong>Copied from</strong>: <?php echo $this->Html->link($visualization['Provenance']['name'], array('controller' => 'visualizations', 'action' => 'view', $visualization['Provenance']['id'])); ?></p>
		<?php } ?> 
    <p><strong>Tool</strong>: <?php echo $this->Html->link($visualization['VisTool']['name'], array('controller' => 'vis_tools', 'action' => 'view', $visualization['VisTool']['id'])); ?></p>
    <p><strong>Status</strong>: <?php echo ($visualization['Visualization']['is_public']?'Public':'Private'); ?></p>
    <p><strong>Author</strong>: <?php echo $this->Html->link($visualization['User']['name'], array('controller' => 'users', 'action' => 'profile', $visualization['User']['username'])); ?></p>
		<?php if ($this->Session->read('Auth.User.id')) { ?>
      <?php echo $this->Html->link(__('<i class="icon-plus icon-white"></i> Copy'), array('action' => 'copy', $visualization['Visualization']['id']),array('class'=>'btn btn-primary','escape'=>false)); ?>
		<?php } ?> 
		<?php if ($this->Session->read('Auth.User.id')==$visualization['Visualization']['user_id']) { ?>
		  <?php echo $this->Html->link(__('<i class="icon-trash icon-white"></i> Delete'), array('action' => 'delete', $visualization['Visualization']['id']), array('class'=>'btn btn-danger','escape'=>false), __('Are you sure you want to delete %s?', $visualization['Visualization']['name'])); ?>
		  <?php echo $this->Html->link(__('<i class="icon-edit icon-white"></i> Edit'), array('action' => 'edit', $visualization['Visualization']['id']),array('class'=>'btn btn-primary','escape'=>false)); ?>
		<?php } ?> 
  </div>
  <?php if ($visualization['Visualization']['inquiry_questions']) {?>
  <div class="span3 well">
		<h3>Inquiry Questions</h3>
		<?php echo h($visualization['Visualization']['inquiry_questions']); ?></p>
  </div>
  <?php } ?>
</div>
