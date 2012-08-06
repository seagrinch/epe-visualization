<h2>Custom Visualization Editor</h2>
<div class="row-fluid">
  <div class="span3">
  
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#vistab1" data-toggle="tab">Metadata</a></li>
        <li><a href="#vistab2" data-toggle="tab">Configuration</a></li>
        <li><a href="#vistab3" data-toggle="tab">Help</a></li>
      </ul>
      <?php echo $this->Form->create('Visualization',array('class'=>'form-vertical'));?>
      <div class="tab-content">
        <div class="tab-pane active" id="vistab1">
          <?php
          echo $this->Form->input('id');
          echo $this->Form->input('name',array('label'=>'Title'));
          echo $this->Form->input('description',array('type'=>'textarea','rows'=>4));
          echo $this->Form->input('inquiry_questions',array('type'=>'textarea','rows'=>4));
          echo $this->Form->input('is_public',array('type'=>'select','label'=>'Sharing','options'=>array('0'=>'Private','1'=>'Anyone with the link','2'=>'Public on the web')));
          echo $this->Form->input('config_settings',array('type'=>'hidden','id'=>'instance_json_config'));
          ?>
        </div>
        <div class="tab-pane" id="vistab2">
          <div id="tool_controls"></div>
        </div>
        <div class="tab-pane" id="vistab3">
          <?php echo $vistool['VisTool']['help']?>
        </div>
      </div> <!-- tab-content-->
      <p>&nbsp;</p>
      <p><?php echo $this->Html->link('Cancel',array('action'=>'view',$this->data['Visualization']['id']),array('class'=>'btn')); ?> 
        <?php echo $this->Form->button('Reset Tool',array('class'=>'btn','type'=>'button','onclick'=>"vistool.reset();"));?>
        <?php echo $this->Form->button('Save',array('class'=>'btn btn-primary','onclick'=>"vistool.setJSON('instance_json_config');"));?></p>
    </div> <!-- tabbable -->
    <?php echo $this->Form->end();?>
  </div> <!-- span4 -->

  <div class="span9">
    <div id="chart"></div>
      <?php echo $this->Html->script('d3.v2.min'); ?>
      <?php echo $this->Html->script('jquery.json-2.3.min'); // Required for ev_editor ?>
      <?php echo $this->Html->script('ev_editor'); ?>
      <?php echo $this->Html->script('/files/tools/' . $vistool['VisTool']['function_name'] . '.js'); ?>
      <?php echo $this->Html->css('/files/tools/' . $vistool['VisTool']['function_name'] . '.css'); ?>
      <script type="text/javascript">
        var settings = <?php echo (isset($this->data['Visualization']['config_settings']) ? $this->data['Visualization']['config_settings'] : "''"); ?>;
        var vistool = new ToolEditor("<?php echo $vistool['VisTool']['function_name']?>","chart",settings,"tool_controls");
      </script>
  </div>
</div>
