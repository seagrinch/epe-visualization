<h2>Visualization Tools</h2>

<ul class="thumbnails">
	<?php foreach ($visTools as $visTool): ?>
  <li class="span3">
    <div class="thumbnail">
    <?php 
      $imgfile = '/files/tools/vistool' . $visTool['VisTool']['id'] . '.jpg';
      if (is_file(WWW_ROOT . $imgfile)) {
        echo $this->Html->link($this->Html->image($imgfile), array('action' => 'view', $visTool['VisTool']['id']),array('escape'=>false)); 
      } else {
        echo $this->Html->link($this->Html->image('http://placehold.it/260x180'), array('action' => 'view', $visTool['VisTool']['id']),array('escape'=>false));
      }
      ?>    
      <h5><?php echo $this->Html->link($visTool['VisTool']['name'], array('action' => 'view', $visTool['VisTool']['id'])); ?></h5>
      <p><?php echo h($visTool['VisTool']['description']); ?></p>
		  <p><small>Tool Type: <?php echo h($visTool['VisTool']['tool_type']); ?></small><br/>
		    <small>Added <?php App::uses('CakeTime', 'Utility'); echo CakeTime::format('F Y', $visTool['VisTool']['created'], true); ?></small></p>
    </div>
  </li>
  <?php endforeach; ?>
</ul>

<?php echo $this->Paginator->pagination(); ?>