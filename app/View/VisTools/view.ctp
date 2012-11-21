<div class="row-fluid">
  <div class="span9">
    <div class="page-header">
        <h1><?php echo h($visTool['VisTool']['name']); ?> <small>Example tool with default settings</small></h1>
    </div>
    <div id="chart"></div>
      <?php echo $this->Html->script('d3.v2.min'); ?>
      <?php echo $this->Html->script('ev_tools'); ?>
      <?php echo $this->Html->script('/files/tools/' . $visTool['VisTool']['function_name'] . '.js'); ?>
      <?php echo $this->Html->css('/files/tools/' . $visTool['VisTool']['function_name'] . '.css'); ?>
    <script>
       var tool_instance = new <?php echo h($visTool['VisTool']['function_name']); ?>('chart', '');
    </script>
  </div>
  <div class="span3 well">
		<h3>Tool Information</h3>
    <p><?php echo h($visTool['VisTool']['description']); ?></p>
    <p><strong>Version</strong>: <?php echo h($visTool['VisTool']['version']); ?><br/>
      <strong>Tool Type</strong>: <?php echo h($visTool['VisTool']['tool_type']); ?><br/>
      <strong>Status</strong>: <?php echo h($visTool['VisTool']['status']); ?><br/>
      <strong>Author</strong>: <?php echo h($visTool['VisTool']['author']); ?><br/>
      <strong>Institution</strong>: <?php echo h($visTool['VisTool']['institution']); ?></p>
    <?php if ($visTool['VisTool']['help']) {?>
      <p><button type="button" class="btn btn-info" data-toggle="modal" data-target="#toolhelp"><i class="icon-question-sign icon-white"></i> Instructions</button></p>
    <?php } ?>
		<?php if ($this->Session->read('Auth.User.is_admin')) { ?>
		  <p><?php echo $this->Form->postLink(__('Delete Tool'), array('action' => 'delete', $visTool['VisTool']['id'],'admin'=>true), array('class'=>'btn btn-danger'), __('Are you sure you want to delete %s?', $visTool['VisTool']['name'])); ?> <?php echo $this->Html->link(__('Edit Tool'), array('action' => 'edit', $visTool['VisTool']['id'],'admin'=>true),array('class'=>'btn btn-primary')); ?> </p>
		<?php } ?> 
    <p><?php echo $this->Html->link(__('Customize this Tool <i class="icon-chevron-right icon-white"></i>'), array('controller' => 'visualizations', 'action' => 'create', $visTool['VisTool']['id']),array('class'=>'btn btn-primary','escape'=>false));?> </p>
  </div>
  <div id="toolhelp" class="modal hide fade">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Tool Instructions</h3>
    </div>
    <div class="modal-body" style="max-height:400px;">
      <?php echo $this->textile->process($visTool['VisTool']['help']); ?>
    </div>
    <div class="modal-footer">
      <a href="#" data-dismiss="modal" class="btn">Close</a>
    </div>
  </div>
</div>
<div class="row-fluid">
  <div class="span9">
    <hr/>
    <h3>Custom Visualizations</h3>
	  <?php if (!empty($instances)): ?>
	  <table cellpadding = "0" cellspacing = "0" class="table table-striped">
    	<tr>
        <th><?php echo $this->Paginator->sort('Visualization.name','Title');?></th>
        <th><?php echo $this->Paginator->sort('Visualization.description','Description');?></th>
        <th><?php echo $this->Paginator->sort('User.name','Creator');?></th>
    	</tr>
  	  <?php foreach ($instances as $instance): ?>
  		<tr>
  			<td><?php echo $this->Html->link($instance['Visualization']['name'], array('controller' => 'visualizations', 'action' => 'view', $instance['Visualization']['id'])); ?></td>
  			<td><?php echo $instance['Visualization']['description'];?></td>
  			<td><?php echo $instance['User']['name'];?></td>
  		</tr>
  	  <?php endforeach; ?>
	  </table>
    <?php echo $this->Paginator->pagination(); ?>
<?php else: ?>
  <p>This tool does not yet have any custom visualizations.  Create your own now.</p>
<?php endif; ?>

  <p><?php echo $this->Html->link(__('Customize this Tool <i class="icon-chevron-right icon-white"></i>'), array('controller' => 'visualizations', 'action' => 'create', $visTool['VisTool']['id']),array('class'=>'btn btn-primary','escape'=>false));?> </p>
  </div>
  <div class="span3">&nbsp;</div>
</div>
