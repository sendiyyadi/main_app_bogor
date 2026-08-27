<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
.form-horizontal .controls {
  margin-left: 120px;  /* changed from 180px to 140px */
}
.form-horizontal .control-group {
    margin-bottom: 1px;
}
.form-horizontal .control-label{
	text-align:left;
	width: 120px; /* changed from 160px to 120px */
}
.form-horizontal input  {
	height: 14px !important;
	border-radius: 2px 2px 2px 2px !important;
	margin-bottom: 1px !important;
}
.form-horizontal select  {
	height: 24px !important;
	padding: 2px !important;
	border-radius: 2px 2px 2px 2px !important;
	margin-bottom: 1px !important;
}

button {
	height: 24px !important;
	padding: 4px 8px !important;
	border-radius: 2px 2px 2px 2px !important;
	margin-bottom: 1px !important;
}

hr {
  border: 0;
  border-bottom: 1px solid #dddddd;
}
</style>

<script>
$(document).ready(function() {	
	$('#myform').submit(function() {
		var c = confirm("Simpan perubahan?");
		return c; 
	});
	
	var tmt_dtp = $('#tmt').datepicker({
		format: 'dd-mm-yyyy'
	}).on('changeDate', function(ev) {
		tmt_dtp.hide();
	}).data('datepicker');
	
	$('#tgl_jatuhtempo_self, #tgl_spt, #reklame_id, #airtanah_id, #self_dok_id, #office_dok_id').autoNumeric('init', {
		aSep: '.', aDec: ',', vMax: '999999999999.99', mDec: '0'
	});
	
	$('#spt_denda, #pad_bunga').autoNumeric('init', {
		aSep: '.', aDec: ',', vMax: '999999999999.99'
	});
	
	$("#tgl_jatuhtempo_self").tooltip({
		'placement': 'right',
		'title': 'Tanggal jatuh tempo jenis pajak Self'
	});
	$("#tgl_spt").tooltip({
		'placement': 'right',
		'title': 'Tanggal paling lambat pelaporan SPTPD'
	});
	$("#spt_denda").tooltip({
		'placement': 'right',
		'title': 'Denda keterlambatan melaporkan SPTPD (decimal)'
	});
	$("#pad_bunga").tooltip({
		'placement': 'right',
		'title': 'Bunga keterlambatan membayar pajak (decimal)'
	});
	$("#thn_ang").tooltip({
		'placement': 'right',
		'title': 'This setting is sessionable'
	});

	$('#btn_cancel').click(function() {
		window.location = '<?php echo active_module_url();?>';
	});	
});

$(document).keypress(function(event){
	if (event.which == '13') {
		event.preventDefault();
	}
});
</script>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Referensi Pemda</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Referensi Pemda</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
		
					<?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal'));?>
					
						<div class="tabbable">
							<ul id="myTab" class="nav nav-tabs">
								<li class="active"><a href="#pemda" data-toggle="tab"><strong>Pemda</strong></a></li>
								<li><a href="#sptpd" data-toggle="tab"><strong>SPTPD</strong></a></li>
								<li><a href="#ref" data-toggle="tab"><strong>ID Referensi</strong></a></li>
								<li><a href="#ta" data-toggle="tab"><strong>Tahun Angggaran</strong></a></li>
							</ul>	
							<?php 
							echo msg_block();
							if(validation_errors()){
								echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
								echo validation_errors('<small>','</small>');
								echo '</blockquote>';
							} 
							?>
							<div class="tab-content">
								<div class="tab-pane fade in active" id="pemda">
									<input type="hidden" name="id" value="<?php echo $dt['id']?>"/>
									<div class="control-group">
										<label class="control-label" for="daerah">Nama Daerah</label>
										<div class="controls">
											<input class="input-xlarge" type="text" name="daerah" id="daerah" value="<?php echo $dt['daerah']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="pemdanm">Nama Pemda</label>
										<div class="controls">
											<input class="input-xlarge" type="text" name="pemdanm" id="pemdanm" value="<?php echo $dt['pemdanm']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="pemdanmskt">Singkatan</label>
										<div class="controls">
											<input class="input-medium" type="text" name="pemdanmskt" id="pemdanmskt" value="<?php echo $dt['pemdanmskt']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="ppkd_id">ID PPKD/Unit</label>
										<div class="controls">
											<input class="input-mini" type="text" name="ppkd_id" id="ppkd_id" value="<?php echo $dt['ppkd_id']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="type">Jenis</label>
										<div class="controls">
											<input class="input-small" type="text" name="type" id="type" value="<?php echo $dt['type']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="kepalanm">Nama Kepala</label>
										<div class="controls">
											<input class="input" type="text" name="kepalanm" id="kepalanm" value="<?php echo $dt['kepalanm']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="jabatan">Jabatan</label>
										<div class="controls">
											<input class="input-xlarge" type="text" name="jabatan" id="jabatan" value="<?php echo $dt['jabatan']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="alamat">Alamat</label>
										<div class="controls">
											<input class="input-xlarge" type="text" name="alamat" id="alamat" value="<?php echo $dt['alamat']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="alamat_lengkap">Alamat Lengkap</label>
										<div class="controls">
											<input class="input-xxlarge" type="text" name="alamat_lengkap" id="alamat_lengkap" value="<?php echo $dt['alamat_lengkap']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="ibukota">Ibukota</label>
										<div class="controls">
											<input class="input" type="text" name="ibukota" id="ibukota" value="<?php echo $dt['ibukota']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="telp">Telp.</label>
										<div class="controls">
											<input class="input" type="text" name="telp" id="telp" value="<?php echo $dt['telp']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="fax">Fax.</label>
										<div class="controls">
											<input class="input" type="text" name="fax" id="fax" value="<?php echo $dt['fax']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="website">Website</label>
										<div class="controls">
											<input class="input" type="text" name="website" id="website" value="<?php echo $dt['website']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="email">Email</label>
										<div class="controls">
											<input class="input" type="text" name="email" id="email" value="<?php echo $dt['email']?>" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="tmt">TMT</label>
										<div class="controls">
											<input class="input-small" type="text" name="tmt" id="tmt" value="<?php echo $dt['tmt']?>" />
										</div>
									</div>
								</div>

								<div class="tab-pane fade in" id="sptpd">
									<div class="control-group">
										<label class="control-label" for="tgl_jatuhtempo_self">Jatuh Tempo Self</label>
										<div class="controls">
											<input class="input-mini" type="text" name="tgl_jatuhtempo_self" id="tgl_jatuhtempo_self" value="<?php echo $dt['tgl_jatuhtempo_self']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="tgl_spt">Min. Lapor SPTPD</label>
										<div class="controls">
											<input class="input-mini" type="text" name="tgl_spt" id="tgl_spt" value="<?php echo $dt['tgl_spt']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="spt_denda">Denda SPTPD</label>
										<div class="controls">
											<input class="input-mini" type="text" name="spt_denda" id="spt_denda" value="<?php echo $dt['spt_denda']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="pad_bunga">Bunga PAD</label>
										<div class="controls">
											<input class="input-mini" type="text" name="pad_bunga" id="pad_bunga" value="<?php echo $dt['pad_bunga']?>" required />
										</div>
									</div>
								</div>
								
								<div class="tab-pane fade in" id="ref">
									<div class="control-group">
										<label class="control-label" for="reklame_id">ID Pajak Reklame</label>
										<div class="controls">
											<input class="input-mini" type="text" name="reklame_id" id="reklame_id" value="<?php echo $dt['reklame_id']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="airtanah_id">ID Pajak Air Tanah</label>
										<div class="controls">
											<input class="input-mini" type="text" name="airtanah_id" id="airtanah_id" value="<?php echo $dt['airtanah_id']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="self_dok_id">ID Dokumen Self</label>
										<div class="controls">
											<input class="input-mini" type="text" name="self_dok_id" id="self_dok_id" value="<?php echo $dt['self_dok_id']?>" required />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="office_dok_id">ID Dokumen Office</label>
										<div class="controls">
											<input class="input-mini" type="text" name="office_dok_id" id="office_dok_id" value="<?php echo $dt['office_dok_id']?>" required />
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="mineral_id">ID Mineral Bukan Logam</label>
										<div class="controls">
											<input class="input-mini" type="text" name="mineral_id" id="mineral_id" value="<?php echo $dt['mineral_id']?>" required />
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="ppj_id">ID Penerangan Jalan</label>
										<div class="controls">
											<input class="input-mini" type="text" name="ppj_id" id="ppj_id" value="<?php echo $dt['ppj_id']?>" required />
										</div>
									</div>

								</div>
			                    
								<div class="tab-pane fade in" id="ta">
									<div class="control-group">
										<label class="control-label" for="thn_ang">Tahun Anggaran</label>
										<div class="controls">
											<input class="input-mini" type="text" name="thn_ang" id="thn_ang" value="<?php echo $dt['thn_ang']?>" readonly />
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="bln_ang">Bulan Anggaran</label>
										<div class="controls">
											<input class="input-mini" type="text" name="bln_ang" id="bln_ang" value="<?php echo $dt['bln_ang']?>" readonly />
										</div>
									</div>						

								</div>
							</div>
						</div>
						<hr />
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="button" class="btn" id="btn_cancel">Batal / Kembali</button>
					<?php echo form_close();?>
			    </div>
			</div>

        <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>