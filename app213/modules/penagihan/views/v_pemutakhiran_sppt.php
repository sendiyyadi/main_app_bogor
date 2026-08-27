<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
  table.dataTable tbody tr.row_selected {
    background-color: #B0BED9 !important;
  }

  /* SPINNER */
  #overlay{ 
    position: fixed;
    top: 0;
    z-index: 100;
    width: 100%;
    height:100%;
    display: none;
    background: rgba(0,0,0,0.6);
  }
  .cv-spinner {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;  
  }
  .spinner {
    width: 40px;
    height: 40px;
    border: 4px #ddd solid;
    border-top: 4px #2e93e6 solid;
    border-radius: 50%;
    animation: sp-anime 0.8s infinite linear;
  }
  @keyframes sp-anime {
    100% { 
      transform: rotate(360deg); 
    }
  }
  .is-hide{
    display:none;
  }
  /* END SPINNER */
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">LAPORAN DAFTAR USULAN PEMBETULAN ALAMAT SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Laporan Daftar Usulan Pembetulan Alamat SPPT</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                          <div id="gap_form">
                            <div class="row" style="margin-bottom:5px">
                                <div class="col-md-3">
                                    <?php echo $select_kecamatan; ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $select_kelurahan; ?>
                                </div>
                                <div class="col-md-2">
                                    <?php echo $select_status; ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $select_id_piutang; ?>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:5px">
                                <div class="col-md-3">
                                    <input class="form-control" type="text" name="c_nop" id="c_nop" placeholder="NOP" value="<?php echo $c_nop;?>" maxlength="30" />
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" name="c_thn" id="c_thn" placeholder="TAHUN" value="<?php echo $c_thn;?>" />
                                </div>
                                <div class="col-md-5">
                                    <button class="btn btn-info" id="btn_cari" >CARI</button>
                                    <button class="btn btn-success" id="btn_cetak" >CETAK</button>
                                    <?php if ($hak_btn_edit == 1) { ?>
                                      <button class="btn btn-secondary" id="btn_edit" >EDIT</button>
                                    <?php } ?>
                                </div>

                            </div>
                          </div>



                          <table class="table table-striped" id="mytable" style="margin-top: 10px">
                              <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>NOP</th>
                                  <th>TAHUN</th>
                                  <th>KECAMATAN</th>
                                  <th>KELURAHAN</th>
                                  <th>USER LOGIN</th>
                                  <th>USER PERUBAHAN</th>
                                  <th>STATUS</th>
                              </tr>
                              </thead>
                          </table>

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

<!-- MODAL EDIT -->
<!-- Spinner Loading -->
<!-- <div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center" style="z-index:2000; display:none;">
  <div class="text-center text-white">
    <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;"></div>
    <div class="mt-2">Memuat data...</div>
  </div>
</div> -->
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<!-- Modal Edit SPPT -->
<div class="modal fade" id="modalEditSppt" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit Detail SPPT</h5>
      </div>
      <div class="modal-body">
        <form id="formEditSppt">
          <div class="row mb-2">
            <div class="col-md-6">
              <label class="form-label">NOP</label>
              <input type="hidden" class="form-control" id="id_m" name="id_m" readonly>
              <input type="text" class="form-control" id="nop" name="nop" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nama WP</label>
              <input type="text" class="form-control" id="nm_wp_sppt" name="nm_wp_sppt" readonly>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-6">
              <label class="form-label">Kecamatan</label>
              <input type="text" class="form-control" id="nm_kecamatan" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Kelurahan</label>
              <input type="text" class="form-control" id="nm_kelurahan" readonly>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-6">
              <label class="form-label">Tanggal Penyerahan</label>
              <input type="text" class="form-control" id="tgl_rekam" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">User Penyerahan</label>
              <input type="text" class="form-control" id="loginname" readonly>
            </div>
          </div>

          <div class="mb-2">
            <label class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan">
          </div>

          <div class="mb-2">
            <label class="form-label">ID Piutang</label>
            <?php echo $select_id_piutang_all; ?>
          </div>

          <div class="mb-3">
            <label class="form-label">Foto</label><br>
            <img id="foto_sppt_baru" src="" alt="Foto SPPT" class="img-thumbnail" width="200">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" id="btnSimpanSppt" class="btn btn-primary" onclick="simpanSppt(this)">
          <span class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
          Simpan
        </button>

      </div>
    </div>
  </div>
</div>

<!-- END MODAL EDIT -->

<!-- tambahan datatables -->
<script>

$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw ){

  if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
    oSettings.sAjaxSource = sNewSource;
  }

  /* Server-side processing should just call fnDraw */
  if ( oSettings.oFeatures.bServerSide ) {
    this.fnDraw();
    return;
  }

  this.oApi._fnProcessingDisplay( oSettings, true );
  var that = this;
  var iStart = oSettings._iDisplayStart;
  var aData = [];

  this.oApi._fnServerParams( oSettings, aData );
  oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {

    /* Clear the old information from the table */
    that.oApi._fnClearTable( oSettings );

    /* Got the data - add it to the table */
    var aData =  (oSettings.sAjaxDataProp !== "") ?
      that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
    for ( var i=0 ; i<aData.length ; i++ ){
      that.oApi._fnAddData( oSettings, aData[i] );
    }
    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

    if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true ){
      oSettings._iDisplayStart = iStart;
      that.fnDraw( false );
    }
    else{
      that.fnDraw();
    }

    that.oApi._fnProcessingDisplay( oSettings, false );

    /* Callback user function - for event handlers etc */
    if ( typeof fnCallback == 'function' && fnCallback != null ){
      fnCallback( oSettings );
    }

  }, oSettings );

};

function simpanSppt() {
    const id_m = $('#id_m').val(); 
    const id_piutang_m = $('#id_piutang_m').val();

    if (!id_piutang_m) {
        alert('ID Piutang belum dipilih');
        return;
    }

    // Ubah tampilan tombol jadi loading
    const button = $('#btnSimpanSppt'); // ambil tombol langsung
    const spinner = button.find('.spinner-border');
    const originalText = button.text();
    spinner.removeClass('d-none');
    button.prop('disabled', true).contents().last().replaceWith(' Processing...');

    $.ajax({
        url: "<?= active_module_url('pemutakhiran_sppt/update_piutang') ?>",
        type: "POST",
        data: {
            id_m: id_m,
            id_piutang_m: id_piutang_m
        },
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                alert(res.message);
                $('#modalEditSppt').modal('hide');
            } else {
                alert(res.message);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan data.');
        },
        complete: function() {
            spinner.addClass('d-none');
            button.prop('disabled', false).contents().last().replaceWith(' Simpan');
        }
    });
}


function reload_grid() {

  var nop = $('#c_nop').val();
  var thn = $('#c_thn').val();
  var kel = $('#KD_KEL').val();
  var kec = $('#KD_KEC').val();
  var sts = $('#STS').val();
  var idp = $('#id_piutang').val();

  // alert(nop);
  if (!nop && (kec == '999999' || !kec) ) {
    alert('Harap Pilih Kecamatan'); return false;
  }

  var params = {
    nop: nop,
    thn: thn,
    kel: kel,
    kec: kec,
    sts: sts,
    idp: idp,
  };

  var data_params = decodeURIComponent($.param(params));
  oTable.fnReloadAjax("<?php echo active_module_url();?>pemutakhiran_sppt/grid/?"+data_params);

}



function refresh_grid() {
  document.getElementById('c_nop').value='';
  document.getElementById('KD_KEL').value='999999';
  document.getElementById('KD_KEC').value='999999';
  document.getElementById('id_piutang').value='999999';
  reload_grid();

}

function get_kelurahan(kec_id) {
	$.ajax({
		url: "<?php echo active_module_url()?>pemutakhiran_sppt/get_kelurahan/"+kec_id,
		success: function (j) {
			var data = $.parseJSON(j);
			var select = $('#KD_KEL');

			select.html("");
            select.append($('<option />', { value: '999999', text: 'SEMUA KELURAHAN' }));
			$.each(data, function(i, val){
				select.append($('<option />', { value: val['KD_KELURAHAN'], text: val['NM_KELURAHAN'] }));
			});
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});
}

var ID;
var NOP;
var THN_SPPT;
var oTable;

    $(document).ready(function () {
        window.history.replaceState({}, "", "<?php echo active_module_url();?>pemutakhiran_sppt/");

        // BUAT PASINGAN DARI DTAIL
        var nop = $('#c_nop').val();
        var thn = $('#c_thn').val();
        var kel = $('#KD_KEL').val();
        var kec = $('#KD_KEC').val();
        var sts = $('#STS').val();
        var idp = $('#id_piutang').val();

        var params = {
          nop: nop, thn: thn, kel: kel, kec: kec, sts: sts, idp:idp,
        };
        var data_params_awal = decodeURIComponent($.param(params));
        // END PASINGAN DARI DTAIL

        oTable = $('#mytable').dataTable({
      		/* "sScrollY": "380px", */
      		/* "iDisplayLength": 100, */
      		"bScrollCollapse": true,
      		"bJQueryUI": true,
      		"bPaginate": true,
      		"sPaginationType": "full_numbers",
      		"sDom": '<"toolbar">frtip',

      		"aoColumnDefs": [
            { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
      		// { "bSearchable": false, "bVisible": false, "aTargets": [ 3 ] }
      		],
            "order": [[0, 'asc' ]],
      		"aoColumns": [
      			null,
      			{ "sWidth": "5%" ,"sClass": "center"},
      			null,null,null,null,null,
      			{ "sWidth": "110px" ,"sClass": "center"},
      		],
      		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
      			$(nRow).on("click", function (event) {
      				if ($(this).hasClass('row_selected')) {
      					/* mID = '';
      					$(this).removeClass('row_selected'); */
      				} else {
      					var data = oTable.fnGetData( this );
                        ID = data[0];
                        NOP = data[1];
                        THN_SPPT = data[2];

      					oTable.$('tr.row_selected').removeClass('row_selected');
      					$(this).addClass('row_selected');
      				}
      			})
      		},
      		"language": {
      			"paginate": {
      			  "first": "First page"
      			},
      			"searchPlaceholder": "Search here...",
      			"search": "",
      			"loadingRecords": "",
      			"processing":   "<img border='0' src='<?php echo base_url('assets/pad/img/ajax-loader-big-circle-ball.gif')?>' />",
      		},
      		"bSort": true,
      		"bInfo": true,
      		"bProcessing": true,
          "bFilter": false,
          "bAutoWidth": false,
          "bServerSide": true,
          // "sAjaxSource": "<?php echo active_module_url();?>Pemutakhiran_sppt/grid/?sts=9"
      		"sAjaxSource": "<?php echo active_module_url();?>pemutakhiran_sppt/grid/"
      	});

        $("[id=btn_cari]").click(function(){
          reload_grid();
        });

        $('#btn_cetak').click(function() {
	        
	        var nop = $('#c_nop').val();
    		 	var thn = $('#c_thn').val();
    		 	var kel = $('#KD_KEL').val();
    		 	var kec = $('#KD_KEC').val();
    		 	var sts = $('#STS').val();
    		 	var idp = $('#id_piutang').val();

	        var filex = "xls";

    		 	var params = {
    		   		nop: nop,
    		    	thn: thn,
    		    	kel: kel,
    		    	kec: kec,
    		    	sts: sts,
    		    	idp: idp,
    	        filex: filex,
    		  };

		  	  var data = decodeURIComponent($.param(params));
	        var url = '<?php echo active_module_url($this->router->fetch_class()); ?>exp_excel_csv/?' + data;
	        window.open(url);

	    });

        $('#btn_edit').click(function() {
          if (NOP) {
            $("#overlay").fadeIn(300);
            $.ajax({
                url: "<?= active_module_url('pemutakhiran_sppt/get_detail_sppt') ?>",
                type: "POST",
                data: { nop: NOP, thn: THN_SPPT },
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $('#id_m').val(data.NOPTHN);
                        $('#nop').val(data.NOP);
                        $('#nm_wp_sppt').val(data.NM_WP_SPPT);
                        $('#nm_kecamatan').val(data.NM_KECAMATAN);
                        $('#nm_kelurahan').val(data.NM_KELURAHAN);
                        $('#tgl_rekam').val(data.TGL_REKAM);
                        $('#loginname').val(data.LOGINNAME);
                        $('#keterangan').val(data.KETERANGAN);

                        $('#id_piutang_m').val(data.ID_PIUTANG);

                        if (data.FOTO_PEMBETULAN) {
                            // $('#foto_sppt_baru').attr('src', 'http://bogorkab.net/sppt_api_neo/pembatalan/' + data.FOTO_PEMBETULAN);
                            $('#foto_sppt_baru').attr('src', '<?= active_module_url('pemutakhiran_sppt/proxy_foto/?id=') ?>' + data.FOTO_PEMBETULAN);
                        } else {
                            $('#foto_sppt_baru').attr('src', '<?= base_url('assets/img/no-image.jpg') ?>');
                        }
                        $('#modalEditSppt').modal('show');
                    } else {
                        alert('Data tidak ditemukan');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data.');
                },
                complete: function() {
                    $("#overlay").fadeOut(300);
                }
            });

          } else {
            alert('Pilih data yang akan diedit');
            return false;
          }
      });

    });
</script>
