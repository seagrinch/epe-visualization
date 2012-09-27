      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Hello, EPE Visualization Gurus!</h1>
        <p>Welcome to the prototype <em><strong>Educational Visualization</strong></em> site of the Ocean Observatories Initiative's educational infrastructure.  This site was developed by the Education and Public Engagement (EPE) Implementing Organization.</p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="span6">
          <h2>Recent Public Visualizations</h2>
          <?php //echo $this->element('visualizations', array(), array('cache' => true)); ?>
          <?php echo $this->element('visualizations'); ?>
        </div>
        <div class="span6">
          <h2>Visualzation Tools</h2>
          <?php echo $this->element('vistools'); ?>
        </div>
      </div>
      <div class="row">
        <div class="span6">
          <p class="pull-left"><?php echo $this->Html->link('More Visualizations <i class="icon-chevron-right icon-white"></i>','/visualizations',array('class'=>'btn btn-info','escape'=>false));?></p>
        </div>
        <div class="span6">
          <p class="pull-right"><?php echo $this->Html->link('More Tools <i class="icon-chevron-right icon-white"></i>','/vis_tools',array('class'=>'btn btn-info','escape'=>false));?> </p>
        </div>
      </div>

<hr>

      <div class="row">
        <div class="span4">
          <h2>Who are we?</h2>
          <p>The EPE IO is designing an educational infrastructure for the Ocean Observatories Initiative.  This site is one of several prototype tools we will be developing over the next few years.</p>
          <p><?php echo $this->Html->link('Find out more <i class="icon-chevron-right"></i>','/pages/about',array('class'=>'btn','escape'=>false));?></p>
        </div>
        <div class="span4">
          <h2>Feedback</h2>
           <p>We would very much like to hear what you think about this prototype site.  Please send any comments or suggestions you have to Sage Lichtenwalner, Lead Developer. </p>
          <p><a class="btn" href="mailto:sage@marine.rutgers.edu"><i class="icon-envelope"></i> Contact Sage</a></p>
       </div>
        <div class="span3">
          <h2 style="color:#CC2200;">Warning</h2>
           <p>Please note, this site is very much only a preliminary version and is not meant for operational use. All data entered prior to the official release in the Fall 2013 is subject to loss.</p>
           <!--<p><a class="btn" href="#">View details &raquo;</a></p>-->
        </div>
      </div>