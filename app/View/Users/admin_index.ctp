<h1>User Administration</h1>
<h3>Site Administrators</h3>
<table class="table table-striped">
  <thead>
	  <tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('username');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th></th>
	  </tr>
  </thead>
  <tbody>
    <?php foreach ($admins as $user) { ?>
    <tr>
      <td><?php echo $user['User']['name'] ?></td>
      <td><?php echo $this->Html->link($user['User']['username'],array('action'=>'edit',$user['User']['id'])); ?></td>
      <td><?php echo $user['User']['email']?></td>
    <?php } ?> 
  </tbody>
</table>

<hr/>

<h3>Site Members</h3>
<div class="pull-right">
  <?php echo $this->Form->create('User',array('action'=>'index'),array('class'=>'well form-search')); ?>
  <?php echo $this->Form->input('search',array('class'=>'search-query','label'=>'','div'=>false));?>
  <?php echo $this->Form->submit('Search',array('class'=>'btn','div'=>false));?> 
  <?php echo $this->Html->link('Clear Results',array('action'=>'index','clear'),array('class'=>'btn'));?>
  <?php echo $this->Form->end(); ?> 
</div>

<?php if(!empty($users)) { ?>
<table class="table table-striped">
  <thead>
	  <tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('username');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('institution');?></th>
			<th><?php echo $this->Paginator->sort('career_stage');?></th>
			<th><?php echo $this->Paginator->sort('research_field');?></th>
			<th><?php echo $this->Paginator->sort('state');?></th>
			<th><?php echo $this->Paginator->sort('created','Joined');?></th>
			<th></th>
	  </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user) { ?>
    <tr>
      <td><?php echo $this->Html->link($user['User']['name'],array('action'=>'profile',$user['User']['username'])); ?></td>
      <td><?php echo $this->Html->link($user['User']['username'],array('action'=>'edit',$user['User']['id'])); ?></td>
      <td><?php echo $this->Html->link($user['User']['email'],'mailto:' . $user['User']['email']); ?></td>
      <td><?php echo $user['User']['institution']?></td>
      <td><?php echo ($user['User']['career_stage'] ? $career_stages[$user['User']['career_stage']] : '');?></td>
      <td><?php echo $user['User']['research_field']?></td>
      <td><?php echo $user['User']['state']?></td>
      <td><?php echo $this->Time->niceShort($user['User']['created']); ?></td>
    <?php } ?> 
  </tbody>
</table>
<?php } else { ?>
<p class="alert warning">No users found.</p>
<?php } ?> 

<?php echo $this->Paginator->pagination(); ?>
