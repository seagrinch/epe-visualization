<h1><?php echo $user['User']['name'];?> 
<?php
  if ($user['User']['id'] == $this->Session->read('Auth.User.id')) {
    echo $this->Html->link(__('Edit Profile'), array('action' => 'profile_update'),array('class'=>'btn btn-primary'));
  }
?></h1>

<?php 
  if ($user['User']['institution'])
    echo '<p><strong>Institution: </strong>' . $user['User']['institution'] . '</p>';
  if ($user['User']['career_stage'])
    echo '<p><strong>Position: </strong>' . $career_stages[$user['User']['career_stage']] . '</p>';
  if ($user['User']['research_field'])
    echo '<p><strong>Research Field: </strong>' . $user['User']['research_field'] . '</p>';
  if ($user['User']['state'])
    echo '<p><strong>State: </strong>' . $user['User']['state'] . '</p>';  
    
?>