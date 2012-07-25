<?php $visualizations = $this->requestAction('/visualizations/index/sort:created/direction:desc/limit:8'); ?>
<div class="row">
<?php foreach ($visualizations as $vis): ?>
  <div class="span3">
  <p><?php echo $this->Html->link('<i class="icon-signal"></i> ' . $vis['Visualization']['name'], array('controller'=>'visualizations','action' => 'view', $vis['Visualization']['id']),array('escape'=>false)); ?> <br><small><?php echo $this->Time->niceShort($vis['Visualization']['created']); ?></small></p>
  </div>
<?php endforeach; ?>
</div>

