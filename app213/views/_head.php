<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo APP_TITLE?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="sistem informasi keuangan daerah">
	<meta name="author" content="Ironman">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

	<!-- Fav and touch icons -->
	<link rel="shortcut icon" href="<?php echo base_url()?>assets/img/favicon.ico">

	<!-- Le styles -->
	<link href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/css/font-static.css" rel="stylesheet">
	<style>
	  body {
		padding-top: 70px; /* 60px to make the container go all the way to the bottom of the topbar */
		padding-bottom: 40px;
	  }
	  html {
		overflow: -moz-scrollbars-vertical; /* Always show scrollbar */
	  }
	</style>
	<link href="<?php echo base_url()?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/jq/ui-lightness/jquery-ui-1.10.2.custom.min.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/datatables/media/css/jquery.dataTables.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/datatables/extras/TableTools/media/css/TableTools.css" rel="stylesheet">
	
	<link href="<?php echo base_url()?>assets/datatables/media/css/demo_page.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/datatables/media/css/demo_table_jui.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/jq/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet">
	
	<link href="<?php echo base_url()?>assets/css/global.css" rel="stylesheet">
  
	<script src="<?php echo base_url()?>assets/jq/js/jquery-1.8.2.min.js"></script>
	<script src="<?php echo base_url()?>assets/jq/js/jquery-ui-1.10.2.custom.min.js"></script>
  
	<script src="<?php echo base_url()?>assets/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url()?>assets/datatables/media/js/jquery.dataTables.ext.js"></script>
	<script src="<?php echo base_url()?>assets/datatables/extras/TableTools/media/js/ZeroClipboard.js"></script>
	<script src="<?php echo base_url()?>assets/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
	
	<!-- FROM PAD -->
	<link href="<?php echo base_url()?>assets/pad/css/jquery-dialog2/jquery.dialog2.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/pad/css/datepicker.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/pad/css/bootstrap-combobox.css" rel="stylesheet">
	<script src="<?php echo base_url()?>assets/pad/js/bootstrap-combobox.js"></script>
	<script src="<?php echo base_url()?>assets/pad/js/jquery.controls.js"></script>
	<script src="<?php echo base_url()?>assets/pad/js/jquery.form.js"></script>
	<script src="<?php echo base_url()?>assets/pad/js/jquery.dialog2.js"></script>
	<script src="<?php echo base_url()?>assets/pad/js/jquery.dialog2.helpers.js"></script>    
	<script src="<?php echo base_url()?>assets/pad/js/bootstrap-datepicker.js"></script>	
	
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-transition.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-alert.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-modal.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-dropdown.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-scrollspy.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-tab.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-tooltip.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-popover.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-button.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-collapse.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-carousel.js"></script>
	<script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-typeahead.js"></script>	

	<script src="<?php echo base_url()?>assets/js/numberFormatter.js"></script>	
	<script src="<?php echo base_url()?>assets/js/autoNumeric.js"></script>

	
	<script>
	var timer;
	var wait=30;
	document.onkeypress=resetTimer;
	document.onmousemove=resetTimer;

	function resetTimer() {
		clearTimeout(timer);
		timer=setTimeout("logout()", 60000*wait);
	}

	function logout() {
        <?php if(MY_ENV != 'development'): ?>
		window.location.href='<?php echo base_url()?>logout';
        <?php else: ?>
        resetTimer();
        <?php endif; ?>
	}

	$(document).ready(function() {	
		$('#app_id').change( function() {
			window.location = '<?php echo base_url();?>change_module/'+$('#app_id').val();
		});

		$('#msg_helper').delay(5000).fadeOut('slow');
		$('#modalform').on('hidden', function() {
			$(this).removeData('modal');
		});
	});
	</script>
	
	<style>
	.navbar-inverse .navbar-inner {
		background-color: #00008B;
	}
	.navbar-inverse .nav > li > a {
		color: #E6E6E6;
		text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.25);
	}

	judul {
		color: yellow;
		font-style: italic;
		font-size: 25px;
		text-shadow: 1px 1px 2px red, 0 0 25px blue, 0 0 5px darkblue;
	}

	</style>
</head>

<body>
  
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
        <button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse" type="button"></button>

        <a class="brand" href="<?php echo base_url()?>" style="padding: 1px; margin-left: 6px; ">

            <img src="<?php echo app_img_header('assets/img/img_logo.png')?>"  style="height:68px;">

            <span><judul>Pos PBB Oracle - Kabupaten Bogor</judul></span>
        </a>

        <?php if(is_login()) :?>
		<div class="btn-group pull-right">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->session->userdata('username');?></a>
			<ul class="dropdown-menu pull-right">
				<li><a href="<?php echo base_url().'admin/ubah_passport/changepwd/'.lda_user_id();?>">Ubah Password</a></li>
				<li><a href="<?php echo base_url().'logout';?>">Logout</a></li>
			</ul>
		</div>
      	<?php endif;?>
		
      	<?php if(is_super_admin() || $this->session->userdata('canchangemod')) :?>
		<form class="btn-group pull-right" >
			<select name="app_id" id="app_id" <?//if(!$app_enabled) echo 'disabled';?>>
				<?php if( isset($apps) && $apps): ?>
                    <?php if(is_super_admin()): ?>
                        <option value="admin">ADMIN</option>
                    <?php endif; ?>
                    
                    <?php foreach($apps as $data): ?>
                        <option value="<?php echo $data->APP_PATH;?>" <?php if(active_module()==$data->APP_PATH) echo 'selected';?>><?php echo $data->NAMA;?></option>
                    <?php endforeach;?>
				<?php else:?>
                    <option value="">Not configured!</option>
				<?php endif; ?>
			</select>
		</form>
      	<?php endif?>
    </div>
  </div>
</div>
