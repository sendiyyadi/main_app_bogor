<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style type="text/css">
    th { font-size: 15px; }
    td { font-size: 14px; }

    th {
        font-weight : bold
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">LAPORAN PERUBAHAN SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Laporan Perubahan SPPT</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row control-group" style="margin-bottom:5px">
                                <div class="col-md-2">
                                    <label class="control-label" style="vertical-align:sub">Kecamatan</label>
                                </div>
                                <div class="col-md-5">
                                    <?php echo $select_kecamatan;?>
                                </div>
                            </div>

                            <div class="row control-group" style="margin-bottom:5px">
                                <div class="col-md-2">
                                    <label class="control-label" style="vertical-align:sub">Kelurahan</label>
                                </div>
                                <div class="col-md-5">
                                    <?php echo $select_kelurahan;?>
                                </div>
                            </div>

                            <div class="row control-group" style="margin-bottom:5px">
                                <div class="col-md-2">
                                    <label class="control-label" for="c_nop" style="vertical-align:sub">NOP</label>
                                </div>
                                <div class="col-md-5">
                                    <input class="input form-control" type="text" style="margin-right: 5px;" name="c_nop" id="c_nop" placeholder="NOP" />
                                </div>
                            </div>

                            <div class="row control-group" style="margin-bottom:5px">
                                <div class="col-md-2">
                                    <label class="control-label" for="c_thn" style="vertical-align:sub">Tahun</label>
                                </div>
                                <div class="col-md-5">
                                    <input class="input form-control" type="number" style="margin-right: 5px;" value="<?php echo date('Y'); ?>" name="c_thn" id="c_thn" placeholder="Tahun" />
                                </div>
                            </div>

                            <div class="row control-group" style="margin-bottom:5px">
                                <div class="col-md-2">
                                    <label class="control-label" style="vertical-align:sub">Status</label>
                                </div>
                                <div class="col-md-5">
                                    <?php echo $select_sts;?>
                                </div>
                            </div>

                            &nbsp;
                            <div class="row control-group">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-5">
                                    <button id="btnshow_cetak" class="btn btn-sm btn-primary" name="btnshow_cetak">Cetak</button>
                                    <!-- <button id="btnshow_rpt" class="btn btn-sm btn-primary" name="btnshow_rpt">Export to Excel</button> -->
                                    <!-- <button id="btnshow_rpt" data-tipelaporan="export" class="btn btn-primary" name="btnshow_rpt">Export Excel</button>  -->
                                </div>
                            </div>
            
                        <!-- END DIV CARD BODY -->
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


function cetak(){

	rptparams = {
    KD_KEC: $("#KD_KEC").val(),
		KD_KEL: $("#KD_KEL").val(),
    C_NOP: $("#c_nop").val(),
		C_THN: $("#c_thn").val(),
    STS: $("#STS").val(),
  }
	// var url  = '<?php //echo base_url($this->router->fetch_class());?>/cetak/?'+data;
	var data = decodeURIComponent($.param(rptparams));

	var url  = '<?php echo active_module_url();?>pdf/?'+data;

  window.open(url);
}

function get_kelurahan(kec_id) {
	$.ajax({
		url: "<?php echo active_module_url()?>laporan_perubahan_sppt/get_kelurahan/"+kec_id,
		success: function (j) {
			var data = $.parseJSON(j);
			var select;
			select = $('[id=KD_KEL]');

			select.html("");
			// select.append($('<option />', { value: '99999', text: 'SEMUA KELURAHAN' }));
			$.each(data, function(i, val){
				select.append($('<option />', { value: val['KD_KELURAHAN'], text: val['NM_KELURAHAN'] }));
			});
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
}


$(document).ready(function() {

	// $("[id=btnshow_rpt]").click(function(){
  //       show_rpt($(this).data('tipelaporan'));
	// });

  $("[id=btnshow_cetak]").click(function(){
        cetak();
	});


});
</script>
