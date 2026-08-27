<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<style>

input{
    -webkit-text-security: disc;
}

#passport{ 
	-webkit-text-security: disc; background-color:#fff;color:#fff;
 }

.noselect {
-webkit-touch-callout: none; /* iOS Safari */
-webkit-user-select: none;   /* Chrome/Safari/Opera */
-khtml-user-select: none;    /* Konqueror */
-moz-user-select: none;      /* Firefox */
-ms-user-select: none;       /* Internet Explorer/Edge */
user-select: none;           /* Non-prefixed version, currently not supported by any browser */
}

</style>

<script>

function updatePW()
{
    $("#pwchar").html($('#passport').val().replace(/./g,"*"));
}

$(document).ready(function() {

	$('#btn_cancel').click(function() {
		window.location = "<?php echo active_module_url('users');?>";
	});


	function xupdatePW()
	{
	    $("#pwchar").html($('#passport').val().replace(/./g,"*"));
	}

});

</script>

<div class="content">
    <div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>USERS</strong></a>
			</li>
		</ul>
		
		<?php
		if(validation_errors()){
			echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
			echo validation_errors('<small>','</small>');
			echo '</blockquote>';
		} ?>
		
		<?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>
			<input type="hidden" name="id" value="<?php echo $dt['id']?>"/>

			<div class="control-group">
				<label class="control-label">User ID</label>
				<div class="controls">
					<input class="input-medium" type="text" name="userid" maxlength="30" value="<?php echo $dt['userid']?>" <?php echo $model!='add' ? 'readonly' : '';?>>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Nama</label>
				<div class="controls">
					<input class="input-large" type="text" name="nama" maxlength="50" value="<?php echo $dt['nama']?>">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Handphone</label>
				<div class="controls">
					<input class="input-large" type="text" name="handphone" maxlength="20" value="<?php echo $dt['handphone']?>">
				</div>
			</div>

			<!-- counter untuk blok droplist user di atas-->
			<input type="text" id="hiddenID" style="display: none;"/>

			<div class="control-group">
				<label class="control-label">Password</label>
				<div class="controls">
					<input class="input-medium" type="password" name="passwd" maxlength="20" value="<?php echo $dt['passwd']?>" autocomplete="off">
					<?php echo $model=='add' ? '' : 'Kosongkan jika tdk berubah';?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Password (Confirm)</label>
				<div class="controls">
					<input class="input-medium" type="password" name="passconf" maxlength="20" value="<?php echo $dt['passconf']?>" autocomplete="off">
					<?php echo $model=='add' ? '' : 'Kosongkan jika tdk berubah';?>
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
				
			<div class="control-group">
				<label class="control-label">NIP</label>
				<?php echo $select_nip?>
			</div>

			<div class="control-group">
				<label class="control-label">Jabatan</label>
				<div class="controls">
					<input class="input-large" type="text" name="jabatan" maxlength="50" value="<?php echo $dt['jabatan']?>">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Disabled</label>
				<div class="controls">
					<label class="checkbox">
						<input type="checkbox" name="disabled" <?php echo $dt['disabled']?>>
					</label>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn" id="btn_cancel">Batal</button>
				</div>
			</div>
		</form>
    </div>
</div>
<?php $this->load->view('_foot'); ?>