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
                        <h4 class="mb-0">LAPORAN DAFTAR USULAN PEMBATALAN SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Laporan Daftar Usulan Pembatalan SPPT</li>
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
                                <!-- <div class="col-md-2">
                                    <?php //echo $select_status; ?>
                                </div> -->
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
                                    <?php if ($hak_btn_appr == 1) { ?>
                                      <button class="btn btn-warning" id="btn_appr_sim" onclick="btn_cari_appr_sim()">APPROVE SIM</button>
                                    <?php } ?>
                                </div>

                            </div>
                          </div>

                          <table class="table table-striped" id="mytable" style="margin-top: 10px">
                              <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>CHK</th>
                                  <th>NOP</th>
                                  <th>KECAMATAN</th>
                                  <th>KELURAHAN</th>
                                  <th>TAHUN</th>
                                  <th>USER PENYERAHAN</th>
                                  <!-- <th>TGL PENYERAHAN</th> -->
                                  <th>STATUS</th>
                                  <!-- <th>STS VERIF</th> -->
                                  <th>STS PIUTANG</th>
                                  <th>STS SPPT</th>
                                  <!-- <th>FILE</th> -->
                                  <th>sts</th>
                                  <th>stsbtlnop</th>
                                  <!-- <th>stsbtlnop</th> -->
                                  <th>ACTION</th>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" id="btnSimpanSppt" class="btn btn-primary" onclick="simpanSppt(this)">
          <span class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
          Simpan
        </button>

      </div>
    </div>
  </div>
</div>

<!-- END MODAL EDIT -->

<!-- Modal Approve simultan -->
<div id="cuDialogApprSimultan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cuDialogApprSimultanLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
          <h3 id="cuDialogApprSimultanLabel">Proses Approve Pembatalan SPPT Simultan</h3>
          <input class="input" type="hidden" style="width:150px;" name="varid_ctk1" id="varid_ctk1" placeholder="Proses"/>
      </div>

      <div class="modal-body">

        <div id="gap_form">
          <div class="row" style="margin-bottom:5px">
              <div class="col-md-3">
                  <?php echo $select_kecamatan_sim; ?>
              </div>
              <div class="col-md-3">
                  <?php echo $select_kelurahan_sim; ?>
              </div>
              <!-- <div class="col-md-2">
                  <?php //echo $select_status_sim; ?>
              </div> -->
              <div class="col-md-3">
                  <?php echo $select_id_piutang_sim; ?>
              </div>
          </div>
          <div class="row" style="margin-bottom:5px">
              <div class="col-md-3">
                  <input class="form-control" type="text" name="c_nop_sim" id="c_nop_sim" placeholder="NOP" value="<?php echo $c_nop_sim;?>" maxlength="30" />
              </div>
              <div class="col-md-3">
                  <input class="form-control" type="number" name="c_thn_sim" id="c_thn_sim" placeholder="TAHUN" value="<?php echo $c_thn_sim;?>" />
              </div>
              <div class="col-md-5">
                  <button id="btn_cari_appr_sim" class="btn btn-primary">Cari</button>
                  <button id="btn_refresh_appr_sim" class="btn btn-primary">Refresh</button>
              </div>

          </div>
        </div>
        <div class="row" style="overflow-x:auto">
          <table class="table table-striped" id="table_as">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>CHK</th>
                  <th>NOP</th>
                  <th>KECAMATAN</th>
                  <th>KELURAHAN</th>
                  <th>TAHUN</th>
                  <th>USER PENYERAHAN</th>
                  <th>STATUS</th>
                  <th>STS PIUTANG</th>
                  <th>STS SPPT</th>
                  <th>sts</th>
                  <th>stsbtlnop</th>
                  <th>ACTION</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer" >
          <button id="btn_proses_apprv_simultan" class="btn btn-secondary" >PROSES APPROVE SIMULTAN</button>
          <button class="btn btn-info" data-bs-dismiss="modal" aria-hidden="true">Batal</button>
      </div>
    </div>
  </div>

</div>
<!-- end Modal approve Simultan-->


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
        url: "<?= active_module_url('pembatalan_sppt_new/update_piutang') ?>",
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
  // var sts = $('#STS').val();
  var idp = $('#id_piutang').val();

  // alert(kec);

  var params = {
    nop: nop,
    thn: thn,
    kel: kel,
    kec: kec,
    // sts: sts,
    idp: idp,
  };

  var data_params = decodeURIComponent($.param(params));
  oTable.fnReloadAjax("<?php echo active_module_url();?>pembatalan_sppt_new/grid/?"+data_params);

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
    url: "<?php echo active_module_url()?>pembatalan_sppt_new/get_kelurahan/"+kec_id,
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

//// APPROVE SIMULTAN
function get_kelurahan_sim(kec_id) {
  $.ajax({
    url: "<?php echo active_module_url()?>pembatalan_sppt_new/get_kelurahan/"+kec_id,
    success: function (j) {
      var data = $.parseJSON(j);
      var select = $('#KD_KEL_sim');

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

function btn_cari_appr_sim() {

    var yyy = new Date();

    var jam = yyy.getHours();
    var menit = yyy.getMinutes();
    var detik = yyy.getSeconds();

    var bulan = (yyy.getMonth()+1);
    var tanggal = yyy.getDate();
    bulan = bulan < 10 ? '0'+bulan : bulan;
    tanggal = tanggal < 10 ? '0'+tanggal : tanggal;
    jam = jam < 10 ? '0'+jam : jam;
    menit = menit < 10 ? '0'+menit : menit;
    detik = detik < 10 ? '0'+detik : detik;

    var proses_id = yyy.getFullYear() +''+ bulan +''+ tanggal +''+ jam +''+ menit +''+ detik;

    document.getElementById('varid_ctk1').value= proses_id;
    reload_grid_appr_simultan();

    $('#cuDialogApprSimultan').modal('show');

}

function reload_grid_appr_simultan() {                     // EdSen 3-7-18

    // model ==>> 1=select all  2=reset all
    var model_id = 0;
    var nop = $('#c_nop_sim').val();
    var thn = $('#c_thn_sim').val();
    var kel = $('#KD_KEL_sim').val();
    var kec = $('#KD_KEC_sim').val();
    // var sts = $('#STS').val();
    var idp = $('#id_piutang_sim').val();
    var proses_id = $('#varid_ctk1').val();

    var params = {
      nop: nop,
      thn: thn,
      kel: kel,
      kec: kec,
      // sts: sts,
      idp: idp,
      model_id : model_id,
      proses_id: proses_id,
    };

    var data_params = decodeURIComponent($.param(params));
    oTable_AS.fnReloadAjax('<?php echo active_module_url();?>pembatalan_sppt_new/grid_appr_sim/?'+data_params);
}

function refresh_grid_appr_simultan() {
    document.getElementById('c_nop_sim').value='';
    document.getElementById('c_thn_sim').value='';
    document.getElementById('KD_KEL_sim').value='';
    document.getElementById('KD_KEC_sim').value='';
    reload_grid_appr_simultan();
}

function reload_grid_select_appr_simultan(model_id) {                      // EdSen 3-7-18
    // model_id ==>> 1=select all  2=reset all

    var nop = $('#c_nop_sim').val();
    var thn = $('#c_thn_sim').val();
    var kel = $('#KD_KEL_sim').val();
    var kec = $('#KD_KEC_sim').val();
    // var sts = $('#STS').val();
    var idp = $('#id_piutang_sim').val();
    var proses_id = $('#varid_ctk1').val();

    var params = {
      nop: nop,
      thn: thn,
      kel: kel,
      kec: kec,
      // sts: sts,
      idp: idp,
      model_id : model_id,
      proses_id: proses_id,
    };
    //alert(model_id);
    var data_params = decodeURIComponent($.param(params));
    oTable_AS.fnReloadAjax('<?php echo active_module_url();?>pembatalan_sppt_new/grid_appr_sim/?'+data_params);
}

// cekbok
function updateApprSim(value, nopx, thnx){
    // alert(nopx);
    var varflag = 0;
    $('#reset_all').attr('checked',false);

    if (value == true) {
        varflag = 1;
    }

    proses_id = document.getElementById('varid_ctk1').value;
    update_tmp_appr_sim(proses_id, varflag, nopx, thnx);
}

function update_tmp_appr_sim(prs_id, flag, nopx, thnx){ //, thn, nopd, masa) {
    //alert(nopx);
    $.ajax({
        url: "<?php echo active_module_url()?>pembatalan_sppt_new/update_tmp_appr_sim/"+prs_id+"/"+flag+"/"+nopx+"/"+thnx,
        async: false,
        success: function (j) {
            ///alert('TTTTTT : '+j);
            //alert('result  : ' + g_result_data);
            //alert('msg  : ' + g_result_msg);
        },
        error: function (xhr, desc, er) {
            alert(er);
            alert('error ' + prs_id)
        }
    });
    //alert(e);
}

function apprv_sim(proses_id){
    $.ajax({
        url: "<?php echo active_module_url()?>pembatalan_sppt_new/apprv_sim/"+proses_id,
        async: false,
        success: function (j) {
            alert(j);
        },
        error: function (xhr, desc, er) {
            // alert(er);
            alert('error ' + prs_id);
        }
    });

    window.location = '<?php echo active_module_url() .'pembatalan_sppt_new'; ?>';
}

//// END APPROVE Simultan

var ID;
var NOP;
var THN_SPPT;
var oTable;

    $(document).ready(function () {
        window.history.replaceState({}, "", "<?php echo active_module_url();?>pembatalan_sppt_new/");

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
            { "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] },
            { "bSearchable": false, "bVisible": false, "aTargets": [ 10 ] },
            { "bSearchable": false, "bVisible": false, "aTargets": [ 11 ] },
            { "bSearchable": false, "bVisible": false, "aTargets": [ 12 ] },
            //{ "bSearchable": false, "bVisible": false, "aTargets": [ 13 ] }, 
          ],
          "order": [[0, 'asc' ]],
          "aoColumns": [
            null,
            { "sWidth": "2%" ,"sClass": "center"},
            { "sWidth": "5%" ,"sClass": "center"},
            null,null,null,null,null,
            // { "sWidth": "110px" ,"sClass": "center"},
            null, null,
            null,
          ],
          "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $(nRow).on("click", function (event) {
              if ($(this).hasClass('row_selected')) {
                /* mID = '';
                $(this).removeClass('row_selected'); */
              } else {
                var data = oTable.fnGetData( this );
                        ID = data[0];
                        NOP = data[2];
                        THN_SPPT = data[5];

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
          // "sAjaxSource": "<?php echo active_module_url();?>Pembetulan_sppt/grid/?sts=9"
          "sAjaxSource": "<?php echo active_module_url();?>pembatalan_sppt_new/grid/?"+data_params_awal
        });

        $("[id=btn_cari]").click(function(){
          reload_grid();
        });

        $('#btn_cetak').click(function() {

          var nop = $('#c_nop').val();
          var thn = $('#c_thn').val();
          var kel = $('#KD_KEL').val();
          var kec = $('#KD_KEC').val();
          // var sts = $('#STS').val();
          var idp = $('#id_piutang').val();

          var filex = "xls";

          var params = {
            nop: nop,
            thn: thn,
            kel: kel,
            kec: kec,
            // sts: sts,
            idp: idp,
            filex: filex
          };
          
          var data = decodeURIComponent($.param(params));
          var url = '<?php echo active_module_url($this->router->fetch_class()); ?>exp_excel_csv/?' + data;
            window.open(url);

        });

        $('#btn_edit').click(function() {
          if (NOP) {
            $("#overlay").fadeIn(300);
            $.ajax({
                url: "<?= active_module_url('pembatalan_sppt_new/get_detail_sppt') ?>",
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

                        if (data.FOTO_PEMBATALAN) {
                            // $('#foto_sppt_baru').attr('src', 'http://bogorkab.net/sppt_api_neo/pembatalan/' + data.FOTO_PEMBATALAN);
                            $('#foto_sppt_baru').attr('src', '<?= active_module_url('pembatalan_sppt_new/proxy_foto/?id=') ?>' + data.FOTO_PEMBATALAN);
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


      //// approve simultan
      oTable_AS = $('#table_as').dataTable({
          "iDisplayLength": 6,
          "sPaginationType": "full_numbers",
        //  "bJQueryUI": true,
          "bAutoWidth": false,
          "bFilter": false, // buang input search
          "sDom": '<"toolbar3">frtip',
          "aaSorting": [[ 1, "asc" ]],
          "aoColumnDefs": [
              { "aTargets": [0], "bSearchable": false,  "bVisible": false,  "sWidth": "60px", "sClass": "" },
              { "aTargets": [1], "bSearchable": false,  "bVisible": true,  "sWidth": "10px",  "sClass": "center",
                  "mRender": function ( source, type, val ) {
                      //var valbox = val[1];
                      var nmb_nop = val[0];
                      var txt_nop = nmb_nop.toString(2) ;
                      if (val[1] == 1) {
                          var cekbox = "checked" ;
                      } else {
                          var cekbox = "";
                      }

                      var txt_thn = val[5];
                      return '<input type="checkbox" value="'+val[1]+'"  name="chkbx" id="chkbx" onchange="updateApprSim(this.checked, \''+txt_nop+'\', \''+txt_thn+'\')" '+cekbox+'>';

                  }
              },
              { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
              { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
              { "aTargets": [4], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
              { "aTargets": [5], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
              { "aTargets": [6], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
              // { "aTargets": [7], "bSearchable": false,  "bVisible": true,  "sWidth": "100px", "sClass": "" },
              { "aTargets": [10], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
              { "aTargets": [11], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
              { "aTargets": [12], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
          ],
          "fnRowCallback": function (nRow, aData, iDisplayIndex) {
              $(nRow).on("click", function (event) {
                  if ($(this).hasClass('row_selected')) {
                      $(this).removeClass('row_selected');
                  } else {
                      var data = oTable.fnGetData( this );
                      $(this).addClass('row_selected');
                  }
              })
          },
          "fnDrawCallback": function( oSettings ) {
              mNIK = ''; mSTS = '';
          },
          "oLanguage": {
              "sProcessing":   "<img border='0' src='<?php echo base_url('assets/pad/img/ajax-loader-big-circle-ball.gif')?>' />",
              "sLengthMenu":   "Tampilkan _MENU_ entri",
              "sZeroRecords":  "Tidak ada data",
              "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
              "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
              "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
              "sInfoPostFix":  "",
              "sSearch":       "Cari : ",
              "sUrl":          "",
              "oPaginate": {
                  "sFirst":    "&laquo;",
                  "sPrevious": "&lsaquo;",
                  "sNext":     "&rsaquo;",
                  "sLast":     "&raquo;",
              }
          },
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": "<?php echo active_module_url();?>pembatalan_sppt_new/grid_appr_sim"
      });

      var tb_array3 = [
          '<div class="btn-group pull-left">',
            '<button id="btn_select_all_appr_sim" class="btn btn-primary">Select All</button>',
          '</div>',
          '<div class="btn-group pull-left">',
            '<button id="btn_reset_all_appr_sim" class="btn btn-primary">Reset All</button>',
          '</div>'
      ];
      var tb3 = tb_array3.join(' ');
      $("div.toolbar3").html(tb3);

      $('#btn_proses_apprv_simultan').click(function() {
          var varidnya_cetak = $('#varid_ctk1').val();
          // alert(varidnya_cetak);
          apprv_sim(varidnya_cetak);
      });

      $("[id=btn_cari_appr_sim]").click(function(){
          reload_grid_appr_simultan();
      });
      $("[id=btn_refresh_appr_sim]").click(function(){
          refresh_grid_appr_simultan();
      });

      $("[id=btn_select_all_appr_sim]").click(function(){
          reload_grid_select_appr_simultan("1");
      });

      $("[id=btn_reset_all_appr_sim]").click(function(){
          reload_grid_select_appr_simultan("2");
      });

      //// end approve simultan

    });
</script>
