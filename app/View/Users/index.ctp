<h1>Site Members</h1>
<div class="pull-right">
  <?php echo $this->Form->create('User',array('action'=>'index'),array('class'=>'well form-search')); ?>
  <?php echo $this->Form->input('search',array('class'=>'search-query','label'=>'','div'=>false));?>
  <?php echo $this->Form->submit('Search Members',array('class'=>'btn','div'=>false));?> 
  <?php echo $this->Html->link('Clear Results',array('action'=>'index','clear'),array('class'=>'btn'));?>
  <?php echo $this->Form->end(); ?> 
</div>
<?php if(!empty($users)) { ?>
<table class="table table-striped table-condensed">
  <thead>
	  <tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('institution');?></th>
			<th><?php echo $this->Paginator->sort('created','Joined');?></th>
			<th></th>
	  </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user) { ?>
    <tr>
      <td><?php echo $this->Html->link($user['User']['name'],array('action'=>'profile',$user['User']['username'])); ?></td>
      <td><?php echo $user['User']['institution']?></td>
      <td><?php echo $this->Time->niceShort($user['User']['created']); ?></td>
    <?php } ?> 
  </tbody>
</table>
<?php } else { ?>
<p class="alert warning">No users found.</p>
<?php } ?> 

<?php echo $this->Paginator->pagination(); ?>
