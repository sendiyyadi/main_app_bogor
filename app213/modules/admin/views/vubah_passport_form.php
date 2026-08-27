<?php //$this->load->view('_head'); ?>
<?php //$this->load->view(active_module().'/_navbar'); ?>

<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">UBAH PASSWORD</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Admin</a>
                                </li>
                                <li class="breadcrumb-item active">Ubah Password</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

			<?php
			if(validation_errors()){
				echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
				echo validation_errors('<small>','</small>');
				echo '</blockquote>';
			} ?>
			
			<?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
				<input type="hidden" name="id" value="<?php echo $dt['id']?>"/>
				<div class="panel">
					<div class="row">
	                  	<div class="col-md-4" style="padding-left:20px;">
	                    	<label for="nama_wp_re">User ID</label>
	                  	</div>
	                  	<div class="col-md-7">
	                    	<input class="form-control" type="text" id="userid" name="userid" value="<?php echo $dt['userid']?>" readonly>
	                  	</div>
	                </div>

	                <div class="row">
	                  	<div class="col-md-4" style="padding-left:20px;">
	                    	<label for="nama_wp_re">Nama</label>
	                  	</div>
	                  	<div class="col-md-7">
	                    	<input class="form-control" type="text" id="nama" name="nama" value="<?php echo $dt['nama']?>" readonly>
	                  	</div>
	                </div>

	                <div class="row">
	                  	<div class="col-md-4" style="padding-left:20px;">
	                    	<label for="nama_wp_re">Password (old)</label>
	                  	</div>
	                  	<div class="col-md-7">
	                    	<input class="form-control" type="password" id="passwd_old" name="passwd_old" value="<?php echo $dt['passwd_old']?>" required>
	                  	</div>
	                </div>

	                <div class="row">
	                  	<div class="col-md-4" style="padding-left:20px;">
	                    	<label for="nama_wp_re">Password (new)</label>
	                  	</div>
	                  	<div class="col-md-7">
	                    	<input class="form-control" type="password" id="passwd" name="passwd" value="<?php echo $dt['passwd']?>" required>
	                  	</div>
	                </div>

	                <div class="row">
	                  	<div class="col-md-4" style="padding-left:20px;">
	                    	<label for="nama_wp_re">Password (Confirm)</label>
	                  	</div>
	                  	<div class="col-md-7">
	                    	<input class="form-control" type="password" id="passconf" name="passconf" value="<?php echo $dt['passconf']?>" required>
	                  	</div>
	                </div>

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

					<div class="row mt-3">
	                  	<div class="col-md-4" style="padding-left:20px;">
	                  	</div>
	                  	<div class="col-md-7">
	                    	<div class="controls">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="button" class="btn" id="btn_cancel">Batal</button>
						</div>
	                  	</div>
	                </div>
						
				</div>
			</form>
	    </div>
	</div>
<?php //$this->load->view('_foot'); ?>

<?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>


<script>
$(document).ready(function() {
	$('#btn_cancel').click(function() {

		window.location = "<?php echo active_module_url();?>";
  
	});

    $('#passwd_old').change(function() {
		var passwd_old = $('#passwd_old').val();
		passwd_old = passwd_old.replace(/ /g,''); // replace all space
		$('#passwd_old').val(passwd_old);
    });

    $('#nama').change(function() {
		var nama = $('#nama').val();
        nama = nama.replace(/^\s+|\s+$/g,'');  // trim spasi depan blakang
		$('#nama').val(nama);
    });

    $('#passwd').change(function() {
		var passwd = $('#passwd').val();
		passwd = passwd.replace(/ /g,''); // replace all space
		$('#passwd').val(passwd);
    });

    $('#passconf').change(function() {
		var passconf = $('#passconf').val();
		passconf = passconf.replace(/ /g,''); // replace all space
		$('#passconf').val(passconf);
    }); 

});
</script>


