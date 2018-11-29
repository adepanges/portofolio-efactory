<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->config->item('app_name') ?> <?php echo $this->config->item('app_client') ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo $this->config->item('base_bootstrap') ?>css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo $this->config->item('base_media') ?>font-awesome-4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('base_media') ?>ionicons-2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('base_media') ?>dist/css/AdminLTE.min.css">

    <link rel="stylesheet" href="<?php echo $this->config->item('base_media') ?>dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    		#place_notif {
    			position: fixed;
			up: 3px;
			right: 3px;
			width: 300px;
			margin-top: 53px;
			z-index: 1;
    		}

    		.loader {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url('<?php echo $this->config->item('base_media') ?>images/page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
		}

         .warning_blink {
           animation-duration: 180ms;
           animation-name: blink;
           animation-iteration-count: infinite;
           animation-direction: alternate;
         }

         @keyframes blink {
          from {
             opacity: 1;
          }
          to {
             opacity: 0;
          }
        }
    </style>
    <script src="<?php echo $this->config->item('base_media') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo $this->config->item('base_bootstrap') ?>js/bootstrap.min.js"></script>

    <script type="text/javascript">
    		app = {
    			base_url: '<?php echo base_url() ?>',
    			site_url: '<?php echo site_url() ?>',
    			base_client_images: '<?php echo $this->config->item('base_client_images') ?>'
    		}

    		bootstrap_alert = function(title,msg,fn){
    			var fn = fn || '';
    			msg = '<div class="alert alert-danger alert-dismissable warning_blink" style="margin-bottom: 3px !important;">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                    '<h4><i class="icon fa fa-ban"></i> '+title+'</h4><p style="cursor: pointer;" onclick='+fn+'>'+msg+'</p></div>';

               $('#place_notif').append(msg);
    		}

    		un_mask_body = function(){
    			$(".loader").fadeOut("slow");
    		}

    		mask_body = function(){
    			$(".loader").fadeIn("slow");
    		}

		$(window).load(function() {
			un_mask_body();
		})

		$(document).ready(function(){
			$('#place_notif').delegate('.alert', 'click', function() {
				$(this).removeClass('warning_blink');
			});
		});
    </script>

  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-blue layout-top-nav">
	<div class="loader"></div>
  	<div id="place_notif"></div>
  	<div class="wrapper">
	      <header class="main-header">
	        <nav class="navbar navbar-static-top">
	          <div class="container">
	            <div class="navbar-header">
	              <a href="<?php echo site_url(); ?>" class="navbar-brand"><b><?php echo $this->config->item('app_name') ?></b> <?php echo $this->config->item('app_client') ?></a>
	              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
	                <i class="fa fa-bars"></i>
	              </button>
	            </div>

	              <div class="navbar-custom-menu">
	                <ul class="nav navbar-nav">
	                  <?php
	                  	$is_login = $this->session->userdata('is_login');

	                  	if(!$is_login){
	                  ?>
	                  <li><a href="<?php echo site_url('log/in') ?>">Masuk</a></li>
	                  <?php } else { ?>
	                  	<?php 
	                  		$usergroupid = (int) $this->session->userdata('usergroupid');

	                  		if($usergroupid==$this->config->item('usergroupid_supervisor')){
	                  	?>
	                	 <li class="dropdown">
		                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu <span class="caret"></span></a>
		                  <ul class="dropdown-menu" role="menu">
		                    <li><a href="<?php echo site_url('supervisor/app') ?>">Monitoring</a></li>
		                    <li><a href="<?php echo site_url('supervisor/report') ?>">Reporting Mesin Aktif</a></li>
		                    <li><a href="<?php echo site_url('supervisor/report/down_time') ?>">Reporting Mesin Down Time</a></li>
		                  </ul>
		                </li>
		               <?php
		          		} else if($usergroupid==$this->config->item('usergroupid_administrator')){
		          			echo '<li><a href="'.site_url('admin').'">Admin Page</a></li>';
		          		}
		          	?>

	                  <li class="dropdown user user-menu">
	                    <!-- Menu Toggle Button -->

	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                      <!-- The user image in the navbar-->
	                      <img src="<?php echo base_url() ?>client/images/photo/operator.png" class="user-image" alt="User Image">
	                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
	                      <span class="hidden-xs"><?php echo $this->session->userdata('nama'); ?></span>
	                    </a>


	                    <ul class="dropdown-menu">
	                      <!-- The user image in the menu -->
	                      <li class="user-header">
	                        <img src="<?php echo base_url() ?>client/images/photo/operator.png" class="img-circle" alt="User Image">
	                        <p>
	                          <?php echo $this->session->userdata('nama'); ?> - <?php echo $this->session->userdata('usergroup'); ?>
	                        </p>
	                      </li>
	                      <!-- Menu Footer-->
	                      <li class="user-footer">
	                        <div class="pull-right">
	                          <a href="<?php echo site_url() ?>/log/out" class="btn btn-default btn-flat">Sign out</a>
	                        </div>
	                      </li>
	                    </ul>
	                  </li>
	                  <?php } ?>
	                </ul>
	              </div><!-- /.navbar-custom-menu -->
	          </div><!-- /.container-fluid -->
	        </nav>
	      </header>

      <!-- Full Width Column -->
	     <div class="content-wrapper">
	     	<div class="container">
	     		<section class="content">
