<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>

hr {
  border: 0;
  border-bottom: 1px solid #dddddd;
}
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Kelurahan</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Kelurahan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

			<?php
			echo msg_block();
			if(validation_errors()){
				echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
				echo validation_errors('<small>','</small>');
				echo '</blockquote>';
			}
			?>
			<div class="row">
                <div class="col-12">
                	<div class="card">
                        <div class="card-body">
							<?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal'));?>
								<input type="hidden" name="id" value="<?php echo $dt['id']?>"/>
								<div class="form-group row mt-2">
	                                <div class="col-md-2 col-sm-4 mb-2" for="kd_propinsi" style="align-self:center;">Propinsi / Dati2</div>
	                                <div class="input-group w-auto">
	                                    <input class="form-control" style="width:50px" type="text" name="kd_propinsi" id="kd_propinsi" value="<?php echo $dt['kd_propinsi']?>" readonly/>
	                                 
	                                    <p class="ms-1 me-2 mt-2 mb-2" style="align-self:center;">/</p>
	                                    <input class="form-control" style="width:50px" type="text" name="kd_dati2" id="kd_dati2" value="<?php echo $dt['kd_dati2']?>" readonly />
	                                </div>
	                            </div>

								<div class="form-group row mt-2">
									<div class="col-sm-2" for="kelurahankd" style="align-self:center;">Kode</div>
									<div class="col-sm-5">
										<input class="form-control" type="text" name="kelurahankd" id="kelurahankd" value="<?php echo $dt['kelurahankd']?>" required <?php echo $this->uri->segment(3)=='add' ? '' : 'readonly'; ?> />
									</div>
								</div>
								<div class="form-group row mt-2">
									<div class="col-sm-2" for="kecamatan_id" style="align-self:center;">Kecamatan</div>
									<div class="col-sm-5">
										<?php echo $select_kecamatan;?>
									</div>
								</div>
								<div class="form-group row mt-2">
									<div class="col-sm-2" for="kelurahannm" style="align-self:center;">Kelurahan</div>
									<div class="col-sm-5">
										<input class="form-control" type="text" name="kelurahannm" id="kelurahannm" value="<?php echo $dt['kelurahannm']?>" required />
									</div>
								</div>
								<!-- <div class="form-group row mt-2">
									<div class="col-sm-2" for="enabled">Aktif</div>
									<div class="col-sm-5">
										<input type="checkbox" name="enabled" <?php //echo $dt['enabled']?>>
									</div>
								</div> -->
								<hr />
								<button type="submit" class="btn btn-primary">Simpan</button>
								<button type="button" class="btn btn-dark" id="btn_cancel">Batal / Kembali</button>
							<?php echo form_close();?>
						</div>
					</div>
			    </div>
			</div>

        <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>


<script>
$(document).ready(function() {

	 $('#btn_cancel').click(function() {
            window.location = '<?php echo active_module_url();?>kelurahan';
        });

	var tmt_dtp = $('#tmt').datepicker({
		format: 'dd-mm-yyyy'
	}).on('changeDate', function(ev) {
		tmt_dtp.hide();
	}).data('datepicker');
});

$(document).keypress(function(event){
	if (event.which == '13') {
		event.preventDefault();
	}
});
</script>
