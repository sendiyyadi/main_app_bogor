<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<script>
$(document).ready(function() {
	$('#btn_cancel').click(function() {
		window.location = '<?php echo active_module_url();?>groups';
	});
});
</script>

<div class="content">
    <div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>GROUPS</strong></a>
			</li>
		</ul>

		<?php echo msg_block();?>
		<?php
		if(validation_errors()){
			echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
			echo validation_errors('<small>','</small>');
			echo '</blockquote>';
		} ?>

		<?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal','enctype'=>'multipart/form-data'));?>

			<input type="hidden" name="id" id="id" value="<?php echo $dt['id']?>"/>

			<div class="control-group">
				<label class="control-label">Kode</label>
				<div class="controls">
					<input class="input-xlarge" type="text" name="kode" id="kode" value="<?php echo $dt['kode']?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Nama</label>
				<div class="controls">
					<input class="input-xlarge" type="text" name="nama" id="nama" value="<?php echo $dt['nama']?>">
				</div>
			</div>
			
			<div class="form-group row">
				<div class="controls">
					<button type="submit" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn" id="btn_cancel">Batal</button>
				</div>
			</div>
		</form>
    </div>
</div>

<?php $this->load->view('_foot'); ?>
