<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<script>

$(document).ready(function() {
	$('#btn_cancel').click(function() {
		window.location = "<?php echo active_module_url('pos_user');?>";
	});
});

</script>

<div class="content">
    <div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>USERS - Tempat Bayar</strong></a>
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
					<input class="input-small" type="text" name="userid" value="<?php echo $dt['userid']?>" readonly>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Nama</label>
				<div class="controls">
					<input class="input-xlarge" type="text" name="nama" value="<?php echo $dt['nama']?>" readonly>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Jabatan</label>
				<div class="controls">
					<input class="input-xlarge" type="text" name="jabatan" value="<?php echo $dt['jabatan']?>" readonly>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">NIP</label>
				<div class="controls">
					<input class="input-xlarge" type="text" name="nip" value="<?php echo $dt['nip']?>" readonly >&nbsp;isi sesuai nip sismiop
				</div>
			</div>
 
			<div class="control-group">
				<label class="control-label">Tmp. Pembayaran</label>
				<?php echo $select_grp_tp_bayar;?>
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