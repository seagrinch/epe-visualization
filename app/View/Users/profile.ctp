<div class="page-header">
  <h1><?php echo $user['User']['name'];?> <small><?php echo ($user['User']['institution'])? $user['User']['institution'] : '';?></small></h1>
</div>

<div class="row">
<div class="span3 well">
  <h3>Profile</h3>
  <?php
  if ($user['User']['career_stage'])
    echo '<p><strong>Position: </strong>' . $career_stages[$user['User']['career_stage']] . '</p>';
  if ($user['User']['research_field'])
    echo '<p><strong>Research Field: </strong>' . $user['User']['research_field'] . '</p>';
  if ($user['User']['state'])
    echo '<p><strong>State: </strong>' . $user['User']['state'] . '</p>';  
  ?>
<p class="pull-right"><?php
  if ($user['User']['id'] == $this->Session->read('Auth.User.id')) {
    echo $this->Html->link(__('Edit Profile'), array('action' => 'profile_update'),array('class'=>'btn btn-primary'));
  }
?>
</p>
</div>

<div class="span9">
  <h3>Custom Visualizations</h3>
  <?php if (!empty($user['Visualizations'])): ?>
    <table cellpadding = "0" cellspacing = "0" class="table table-striped">
    	<tr>
        <th>Title</th>
        <th>Description</th>
        <th>Modified</th>
    	</tr>
      <?php foreach ($user['Visualizations'] as $instance): ?>
    	<tr>
    		<td><?php echo $this->Html->link($instance['name'], array('controller' => 'visualizations', 'action' => 'view', $instance['id'])); ?></td>
    		<td><?php echo $instance['description'];?></td>
    		<td><?php echo $this->Time->niceShort($instance['modified']);?></td>
    	</tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <p>This tool does not yet have any custom visualizations.  Create your own now.</p>
  <?php endif; ?>
</div>
</div>