<link href="<?= base_url('assets/templates/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/templates/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />

<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		font-family: 'Poppins', sans-serif;
	}

	body {
		/* background: #f5f6f8; */
		background-image: url(<?= base_url('assets/img/aiya.png'); ?>);
		background-size: cover;
		background-position: center;
	}

	.wrapper {
		max-width: 350px;
		min-height: 500px;
		margin: 80px auto;
		padding: 40px 30px 30px 30px;
		background-color: #ecf0f3;
		border-radius: 15px;
		/* box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff; */
	}

	.logo {
		width: 80px;
		margin: auto;
	}

	.logo img {
		width: 100%;
		height: 80px;
		object-fit: cover;
		/* border-radius: 50%; */
		/* box-shadow: 0px 0px 3px #5f5f5f,
            0px 0px 0px 5px #ecf0f3,
            8px 8px 15px #a7aaa7,
            -8px -8px 15px #fff; */
	}

	.wrapper .name {
		font-weight: 600;
		font-size: 1.4rem;
		letter-spacing: 1.3px;
		padding-left: 10px;
		color: #555;
	}

	.wrapper .form-field input {
		width: 100%;
		display: block;
		border: none;
		outline: none;
		background: none;
		font-size: 1.2rem;
		color: #666;
		padding: 10px 15px 10px 10px;
		/* border: 1px solid red; */
	}

	.wrapper .form-field {
		padding-left: 10px;
		margin-bottom: 20px;
		border-radius: 20px;
		box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
	}

	.wrapper .form-field .fas {
		color: #555;
	}

	.wrapper .btn {
		box-shadow: none;
		width: 100%;
		height: 40px;
		background-color: #03A9F4;
		color: #fff;
		border-radius: 25px;
		box-shadow: 3px 3px 3px #b1b1b1,
			-3px -3px 3px #fff;
		letter-spacing: 1.3px;
	}

	.wrapper .btn:hover {
		background-color: #039BE5;
	}

	.wrapper a {
		text-decoration: none;
		font-size: 0.8rem;
		color: #03A9F4;
	}

	.wrapper a:hover {
		color: #039BE5;
	}

	@media(max-width: 380px) {
		.wrapper {
			margin: 30px 20px;
			padding: 40px 15px 15px 15px;
		}
	}
</style>

<div class="wrapper">
	<div class="logo">
		<img src="<?= base_url('assets/img/eeee.png'); ?>" alt="">
	</div>
	<div class="text-center mt-4 name py-0">
		<p>PBB ONLINE</p>
		<p>KABUPATEN BOGOR</p>
	</div>
	<!-- <p class="text-center">-oracle</p> -->
	<h5 class="text-center text-muted mt-3">Login</h5>
	<?php echo form_open('login', array('id' => 'frmlogin', 'class' => 'form-horizontal p-3')); ?>
	<?php
	echo msg_block();
	if (validation_errors()) {
		echo '<div id="msg_helper" class="alert alert-error">';
		echo validation_errors('<small style="color:red;">', '</small>');
		echo '</div>';
	}
	?>

	<div class="form-field d-flex align-items-center">
		<i class="uil-user"></i>
		<input type="text" maxlength="30" name="userid" placeholder="User ID" autocomplete="off" required />
	</div>
	<div class="form-field d-flex align-items-center">
		<i class="uil-lock-alt"></i>
		<input type="password" maxlength="20" name="passwd" id="passwd" placeholder="Password" autocomplete="off" required />
	</div>
	<h6 class="text-center text-muted mt-1">One System for Every PBB Services</h6>
		
	
	<script>
		/** blok drop down password  ini ok  */
		window.jQuery('form input[type="password"]').on('focus input click', function(e) {
			var self = $(this);
			self.prop('readonly', true);
			setTimeout(function() {
				self.prop('readonly', false);
			}, 50);
		});
	</script>
	<button type="submit" class="btn mt-3">Sign in</button>
	</form>
</div>

<?php $this->session->sess_destroy(); ?>
<?php $this->load->view('_foot'); ?>