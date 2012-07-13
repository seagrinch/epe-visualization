<h2>Custom Visualization Editor</h2>
<div class="row">
  <div class="span4">
  
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#vistab1" data-toggle="tab">Metadata</a></li>
        <li><a href="#vistab2" data-toggle="tab">Configuration</a></li>
      </ul>
      <?php echo $this->Form->create('Visualization',array('class'=>'form-vertical'));?>
      <div class="tab-content">
        <div class="tab-pane active" id="vistab1">
          <?php
          echo $this->Form->input('id');
          echo $this->Form->input('name');
          echo $this->Form->input('description',array('type'=>'textarea'));
          echo $this->Form->input('is_public',array('options'=>array('0'=>'No','1'=>'Yes')));
          echo $this->Form->input('config_settings',array('type'=>'hidden','id'=>'instance_json_config'));
          ?>
        </div>
        <div class="tab-pane" id="vistab2">
          <div id="tool_controls"></div>
        </div>
      </div> <!-- tab-content-->
      <p>&nbsp;</p>
      <p><?php echo $this->Html->link('Cancel',array('action'=>'view',$this->data['Visualization']['id']),array('class'=>'btn')); ?> 
        <?php echo $this->Form->button('Save',array('class'=>'btn btn-primary','onclick'=>"vistool.setJSON('instance_json_config');"));?></p>
    </div> <!-- tabbable -->
    <?php echo $this->Form->end();?>
  </div> <!-- span4 -->

  <div class="span8">
    <div id="chart"></div>
      <?php echo $this->Html->script('d3.v2.min'); ?>
      <?php echo $this->Html->script('jquery.json-2.3.min'); // Required for ev_editor ?>
      <?php echo $this->Html->script('ev_editor'); ?>
      <?php echo $this->Html->script('/files/tools/vistool' . $this->data['VisTool']['id'] . '.js'); ?>
      <?php echo $this->Html->css('/files/tools/vistool' . $this->data['VisTool']['id'] . '.css'); ?>
      <script type="text/javascript">
        var settings = <?php echo $this->data['Visualization']['config_settings']; ?>;
        var vistool = new ToolEditor("<?php echo $this->data['VisTool']['function_name']?>","chart",settings,"tool_controls");
      </script>
  </div>
</div>
