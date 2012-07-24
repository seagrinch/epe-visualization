<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="OOI EPE">

    <!-- Le styles -->
    <?php
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('colorpicker');
		//echo $this->Html->css('datepicker');
		echo $this->Html->css('start/jquery-ui-1.8.21.custom');
    ?>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <?php
		echo $this->Html->meta('icon');
    echo $this->Html->script('bootstrap');
    echo $this->Html->script('bootstrap-colorpicker');
    //echo $this->Html->script('bootstrap-datepicker');
    echo $this->Html->script('jquery-ui-1.8.21.custom.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <?php echo $this->Html->link(siteName,'/',array('class'=>'brand'))?>
          <div class="btn-group pull-right">
            <?php if ($this->Session->check('Auth.User')) { ?>
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php echo $this->Session->read('Auth.User.name') ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><?php echo $this->Html->link('My Visualizations','/visualizations/personal')?></li>
              <li><?php echo $this->Html->link('My Profile','/users/profile')?></li>
              <li class="divider"></li>
              <li><?php echo $this->Html->link('Sign Out','/users/logout')?></li>
            </ul>
            <?php } else { ?>
              <div class="btn"><?php echo $this->Html->link('Sign In','/users/login')?></div>
            <?php } ?>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
              <li><?php echo $this->Html->link('Home','/')?></li>
              <li class="dropdown" id="menu1">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#nav1">Visualizations<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><?php echo $this->Html->link('Public','/visualizations')?></li>
                  <li><?php echo $this->Html->link('Personal','/visualizations/personal')?></li>
                  <li class="divider"></li>
                  <li><?php echo $this->Html->link('Tool List','/vis_tools')?></li>
                </ul>
              </li>
              <li><?php echo $this->Html->link('Members','/users')?></li>
              <li><?php echo $this->Html->link('Updates','/pages/updates')?></li>
              <li><?php echo $this->Html->link('Help','/pages/help')?></li>
              <?php if ($this->Session->read('Auth.User.is_admin')) { ?>
              <li class="dropdown" id="menu2">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#nav1">Admin<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><?php echo $this->Html->link('User Management','/admin/users')?></li>
                  <li class="divider"></li>
                  <li><?php echo $this->Html->link('New Visualization Tool','/admin/vis_tools/add')?></li>
                  <li><?php echo $this->Html->link('Visualization Tool List','/admin/vis_tools/index')?></li>
                </ul>
              </li>
              <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div class="container-fluid">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->fetch('content'); ?>

      <hr>

      <footer>
        <p>&copy; <?php echo date("Y")?> Ocean Observatories Initiative 
          | <?php echo $this->Html->link('About Us',array('controller'=>'pages','action'=>'about'))?>
          | <?php echo $this->Html->link('Disclaimer',array('controller'=>'pages','action'=>'disclaimer'))?>
        </p>
      </footer>

    </div><!--/.fluid-container-->

	<?php echo $this->element('sql_dump'); ?>
  </body>
</html>