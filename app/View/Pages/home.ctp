      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Hello, EPE Visualization Gurus!</h1>
        <p>Welcome to the prototype <em>Educational Visualization</em> site of the Ocean Observatories Initiative's educational infrastructure, developed by the Education and Public Engagement (EPE) Implementing Organization.</p>
        <p><?php echo $this->Html->link('Visualization Tools <i class="icon-chevron-right icon-white"></i>','/vis_tools',array('class'=>'btn btn-primary btn-large','escape'=>'false'));?> 
          <?php echo $this->Html->link('Custom Visualizations <i class="icon-chevron-right icon-white"></i>','/visualizations',array('class'=>'btn btn-primary btn-large','escape'=>'false'));?></p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="span4">
          <h2>What is the EPE</h2>
          <p>The EPE is designing an educational infrastructure for the Ocean Observatories Initiative.</p>
          <p><a class="btn" href="http://www.oceanobservatories.org/infrastructure/ooi-components/education-public-engagement/">Find out more <i class="icon-chevron-right icon-white"></i></a></p>
        </div>
        <div class="span4">
          <h2>Feedback</h2>
           <p>We would very much like to hear what you think about this prototype site.  Please send any comments or suggestions you have to Sage Lichtenwalner, Lead Developer. </p>
          <p><a class="btn" href="mailto:sage@marine.rutgers.edu">Contact Sage <i class="icon-envelope"></i></a></p>
       </div>
        <div class="span4">
          <h2 style="color:#CC2200;">Warning</h2>
           <p>Please note, this site is very much only a preliminary version and is not meant for operational use. All data entered prior to the official release in the Fall 2012 is subject to loss.</p>
           <!--<p><a class="btn" href="#">View details &raquo;</a></p>-->
        </div>
      </div>
