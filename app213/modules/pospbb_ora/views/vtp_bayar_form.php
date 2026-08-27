<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<script>

$(document).ready(function() {

	$('#btn_cancel').click(function() {
		window.location = "<?php echo active_module_url('tp_bayar');?>";
	});
});

</script>

<div class="content">
    <div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>TEMPAT_PEMBAYARAN</strong></a>
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
				<label class="control-label">Kode</label>
				<div class="controls">

		          	<?php if (DEF_POS_TYPE==1) { ?>
		                <input class="input-small" type="text" name="kd_kanwil" value="<?php echo $dt['kd_kanwil'];?>">
		                <input class="input-small" type="text" name="kd_kantor" value="<?php echo $dt['kd_kantor'];?>">
		                <input class="input-small" type="text" name="kd_tp" value="<?php echo $dt['kd_tp'];?>">
		          	<?php } else {?>
		                <input class="input-small" type="text" name="kd_bank_tunggal" value="<?php echo $dt['kd_bank_tunggal'];?>">
		                <input class="input-small" type="text" name="kd_bank_persepsi" value="<?php echo $dt['kd_bank_persepsi'];?>">
		                <input class="input-small" type="text" name="kd_kanwil" value="<?php echo $dt['kd_kanwil'];?>">
		                <input class="input-small" type="text" name="kd_kantor" value="<?php echo $dt['kd_kantor'];?>">
		                <input class="input-small" type="text" name="kd_tp" value="<?php echo $dt['kd_tp'];?>">
		          	<?php }?>

				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Nama</label>
				<div class="controls">
					<input class="input-xlarge" type="text" name="nm_tp" value="<?php echo $dt['nm_tp']?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Alamat</label>
				<div class="controls">
					<input class="input-xlarge" type="text" name="alamat_tp" value="<?php echo $dt['alamat_tp']?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Rekening</label>
				<div class="controls">
					<input class="input-xlarge" type="text" name="no_rek_tp" value="<?php echo $dt['no_rek_tp']?>">
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