<?php $visTools = $this->requestAction('/vis_tools/index/sort:created/direction:desc/limit:3'); ?>
<ul class="thumbnails">
<?php foreach ($visTools as $visTool): ?>
  <li class="span2">
    <?php 
      $imgfile = '/files/tools/vistool' . $visTool['VisTool']['id'] . '.jpg';
      if (is_file(WWW_ROOT . $imgfile)) {
        $img = $this->Html->image($imgfile);
      } else {
        $img = $this->Html->image('http://placehold.it/260x180');
      }
      echo $this->Html->link($img, array('controller'=>'vis_tools','action' => 'view', $visTool['VisTool']['id']),array('escape'=>false,'class'=>'thumbnail')); 
      ?>    
      <p align="center"><?php echo $this->Html->link($visTool['VisTool']['name'], array('controller'=>'vis_tools','action' => 'view', $visTool['VisTool']['id'])); ?></p>
  </li>
<?php endforeach; ?>
</ul>
