<h2>Edit a Custom Visualization</h2>
<div class="row">
  <div class="span4">
  
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#etab1" data-toggle="tab">Metadata</a></li>
        <li><a href="#etab2" data-toggle="tab">Configuration</a></li>
      </ul>
      <?php echo $this->Form->create('Visualization');?>
      <div class="tab-content">
        <div class="tab-pane active" id="etab1">
          <?php
          echo $this->Form->input('id');
          echo $this->Form->input('name');
          echo $this->Form->input('description');
          echo $this->Form->input('is_public');
          ?>
        </div>
        <div class="tab-pane" id="etab2">
          <div id="tool_controls"></div>
        </div>
      </div> <!-- tab-content-->
      <?php echo $this->Form->end('Save',array('class'=>'btn btn-primary'));?>
    </div> <!-- tabbable -->
    <p><?php echo $this->Html->link('Return to view',array('action'=>'view',$this->data['Visualization']['id']),array('class'=>'btn btn-success pull-right')); ?></p>
  </div> <!-- span4 -->

  <div class="span8">
    <div id="instance_display"></div>
    <?php 
      echo $this->Html->script('d3.v2.min');
      echo $this->Html->script('ev_editor');
      echo $this->Html->script('jquery.json-2.3.min');
     ?>
      <script type="text/javascript">
        var tool = new tool_instance_editor(<?php echo $this->data['Visualization']['id']; ?>,"chart");
      </script>
  </div>
</div>
