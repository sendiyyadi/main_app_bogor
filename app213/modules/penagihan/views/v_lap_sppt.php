<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>

  table.dataTable tbody tr.row_selected {
    background-color: #B0BED9 !important;
  }

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">DAFTAR PROSES LAPORAN SPPT TERSAMPAIKAN</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Daftar Proses Laporan SPPT Tersampaikan</li>
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
                          <div id="gap_form">
                            <div class="row" style="margin-bottom:5px">
                                <div class="col-md-3">
                                    <?php echo $select_kecamatan; ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $select_kelurahan; ?>
                                </div>
                                <div class="col-md-6">
                                  <div class="row" style="margin-bottom:5px">
                                   <!--  <div class="col-md-4">
                                      <?php //echo $select_status; ?>
                                    </div> -->
                                    <div class="col-md-4">
                                      <input class="form-control" type="text" name="c_tg_fr" id="c_tg_fr" placeholder="TGL SERAH FROM" value="<?php echo $c_tg_fr;?>" />
                                    </div>
                                    <div class="col-md-4">
                                      <input class="form-control" type="text" name="c_tg_to" id="c_tg_to" placeholder="TGL SERAH TO" value="<?php echo $c_tg_to;?>" />
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:5px">
                                <div class="col-md-3">
                                    <input class="form-control" type="text" name="c_nop" id="c_nop" placeholder="NOP" value="<?php echo $c_nop;?>" maxlength="18" />
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="number" name="c_thn" id="c_thn" placeholder="TAHUN" value="<?php echo $c_thn;?>" />
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control" type="text" name="c_ptgs" id="c_ptgs" placeholder="PTGS SERAH" value="<?php echo $c_ptgs;?>" />
                                </div>
                                <!-- <div class="col-md-2">
                                <?php //echo $select_status_verif; ?>
                                </div> -->
                                <div class="col-md-3">
                                    <button class="btn btn-info" id="btn_cari" >CARI</button>
                                    <!-- <button class="btn btn-success" id="btn_detail" >DETAIL</button> -->
                                    <!-- <button class="btn btn-warning" id="btn_terima_sim" >TERIMA</button> -->
                                    <!-- <button class="btn btn-danger" id="btn_tolak_sim" >TOLAK</button> -->
                                    <button class="btn btn-success" id="btn_cetak_sim" >CETAK</button>
                                    <!-- <button class="btn btn-dark" id="btn_tes" >TES</button> -->
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
                                  <th>TGL PENYERAHAN</th>
                                  <th>STS VERIF</th>
                                  <th>STS SPPT</th>
                                  <!-- <th>FILE</th> -->
                                  <th>sts</th>
                                  <th>stsbtlnop</th>
                                  <th>stsbtlnop</th>
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


<!-- Modal -->
<div id="cuDialog_terima_sim" class="modal" tabindex="-1" role="dialog" aria-labelledby="cuDialog_terima_simLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="cuDialog_terima_simLabel"></h3>
      </div>
      <form onsubmit="action_terima_sim(this);" method="post" accept-charset="utf-8" id="myFormModals" class="form-horizontal" enctype="multipart/form-data">
      <div class="modal-body">
          <input class="form-control" type="hidden" name="id_prf_terima" id="id_prf_terima">
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_kec_trm" id="prm_awal_kec_trm" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_kel_trm" id="prm_awal_kel_trm" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_sts_trm" id="prm_awal_sts_trm" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_nop_trm" id="prm_awal_nop_trm" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_thn_trm" id="prm_awal_thn_trm" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_ptgs_trm" id="prm_awal_ptgs_trm" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_tgl_fr_trm" id="prm_awal_tgl_fr_trm" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_tgl_to_trm" id="prm_awal_tgl_to_trm" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_sts_verif_trm" id="prm_awal_sts_verif_trm" />
          <h4>Terima Proses Laporan Data tersebut ?</h4>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btn_terima_sub">YA</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div id="cuDialog_tolak_sim" class="modal" tabindex="-1" role="dialog" aria-labelledby="cuDialog_tolak_simLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="cuDialog_tolak_simLabel"></h3>
      </div>
      <form onsubmit="action_tolak_sim(this);" method="post" accept-charset="utf-8" id="myFormModals" class="form-horizontal" enctype="multipart/form-data">
      <div class="modal-body">
          <input type="hidden" name="id_prf_tolak" id="id_prf_tolak">
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_kec_tlk" id="prm_awal_kec_tlk" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_kel_tlk" id="prm_awal_kel_tlk" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_sts_tlk" id="prm_awal_sts_tlk" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_nop_tlk" id="prm_awal_nop_tlk" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_thn_tlk" id="prm_awal_thn_tlk" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_ptgs_tlk" id="prm_awal_ptgs_tlk" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_tgl_fr_tlk" id="prm_awal_tgl_fr_tlk" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_tgl_to_tlk" id="prm_awal_tgl_to_tlk" />
          <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_sts_verif_tlk" id="prm_awal_sts_verif_tlk" />
          <h4>Tolak Proses Laporan Data tersebut ?</h4>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btn_tolak_sub">YA</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal -->

    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>


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



function reload_grid() {

  var nop = $('#c_nop').val();
  var ptgs = $('#c_ptgs').val();
  var tgl_fr = $('#c_tg_fr').val();
  var tgl_to = $('#c_tg_to').val();
  var thn = $('#c_thn').val();
  var kel = $('#KD_KEL').val();
  var kec = $('#KD_KEC').val();
  var sts = $('#STS').val();
  var sts_verif = $('#STS_VER').val();
  // var sts = $('#STS').val();
  // var sts = $('#STS').val();

  // alert(kec);

  var params = {
    nop: nop,
    thn: thn,
    kel: kel,
    kec: kec,
    sts: sts,
    ptgs: ptgs,
    tgl_fr: tgl_fr,
    tgl_to: tgl_to,
    sts_verif: sts_verif
  };

  var data_params = decodeURIComponent($.param(params));
  oTable.fnReloadAjax("<?php echo active_module_url();?>lap_sppt/grid/?"+data_params);

}



function refresh_grid() {
  document.getElementById('c_nop').value='';
  document.getElementById('KD_KEL').value='999999';
  document.getElementById('KD_KEC').value='999999';
  reload_grid();

}

function get_kelurahan(kec_id) {
	$.ajax({
		url: "<?php echo active_module_url()?>lap_sppt/get_kelurahan/"+kec_id,
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
var tmp_id_sim = [];

function cek_array(param){
    var cek= tmp_id_sim.includes(param);
    if(cek == true){
        return 1;
    }else{
        return 2;
    }
}

function update_sim(value,idd){//,sptpdno,nopd,masa){			// FUNCTION CHECKBOX 				_EdSen	4-7-18
    // alert(String(idd));
    var prs_id = 0;
    var new_tmp = [];
    if(tmp_id_sim.length < 10){
        if(value == true){
          prs_id = 1;
          tmp_id_sim.push(idd);
        }else{
          index_id = tmp_id_sim.indexOf(idd);
          tmp_id_sim.splice(index_id,1);
          // tmp_id_sim = new_tmp;
        }
    }else{
        alert("maksimal 10 data yang dapat diproses simultan");
    }

    // alert(tmp_id_sim);


}

function action_terima_sim(form) {
      document.getElementById("btn_terima_sub").disabled = true;
      form.action = '<?php echo active_module_url()?>lap_sppt/terima_sim/';

}

function action_tolak_sim(form) {
      var id_prf = $('#id_prf_tolak').val();
      document.getElementById("btn_tolak_sub").disabled = true;
      var params = {
           id_prf: id_prf,
        }
    	var data = decodeURIComponent($.param(params));
      form.action = '<?php echo active_module_url()?>lap_sppt/tolak_sim/';

}

    $(document).ready(function () {
        $('#c_tg_fr').datepicker({ format: 'dd-mm-yyyy' });
        $('#c_tg_fr').on('changeDate', function(){
            $(this).datepicker('hide'); 
        });

        $('#c_tg_to').datepicker({ format: 'dd-mm-yyyy' }); 
        $('#c_tg_to').on('changeDate', function(){
            $(this).datepicker('hide'); 
        });
        
        window.history.replaceState({}, "", "<?php echo active_module_url();?>lap_sppt/");

        // BUAT PASINGAN DARI DTAIL
        var nop = $('#c_nop').val();
        var ptgs = $('#c_ptgs').val();
        var tgl_fr = $('#c_tg_fr').val();
        var tgl_to = $('#c_tg_to').val();
        var thn = $('#c_thn').val();
        var kel = $('#KD_KEL').val();
        var kec = $('#KD_KEC').val();
        var sts = $('#STS').val();

        var params = {
          nop: nop, thn: thn, kel: kel, kec: kec, sts: sts, ptgs: ptgs, tgl_fr: tgl_fr, tgl_to: tgl_to,
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
            { "aTargets": [1], "bSearchable": true,  "bVisible": true,  "sWidth": "40px" ,
              "mRender": function ( source, type, val ) {
                  var disabled = '';
                  var checked = '';
                  var cek_aray = tmp_id_sim.includes(parseInt(val[0]));
                  if (val[9] == 1 || val[9] == 2) {
                    disabled = 'disabled';
                  }
                  if(cek_aray == true){
                      checked = 'checked';
                  }
                  return '<input type="checkbox" value="'+val[1]+'"  name="chkbx" id="chkbx" class="form-check" onchange="update_sim(this.checked,\''+val[0]+'\')" '+checked+' '+disabled+'>';

                  }
            },
      		  { "bSearchable": false, "bVisible": false, "aTargets": [ 8 ] },
            { "bSearchable": false, "bVisible": false, "aTargets": [ 9 ] },
            { "bSearchable": false, "bVisible": false, "aTargets": [ 10 ] },
            { "bSearchable": false, "bVisible": false, "aTargets": [ 11 ] },
            { "bSearchable": false, "bVisible": false, "aTargets": [ 12 ] },
            { "bSearchable": false, "bVisible": true, "aTargets": [ 13 ], 
              "mRender": function( data, type, full) {
                var nop = $('#c_nop').val();
                var thn = $('#c_thn').val();
                var ptgs = $('#c_ptgs').val();
                var tgl_fr = $('#c_tg_fr').val();
                var tgl_to = $('#c_tg_to').val();
                var kel = $('#KD_KEL').val();
                var kec = $('#KD_KEC').val();
                var sts = $('#STS').val();
                var sts_ver = $('#STS_VER').val();

                if (full[12] == 1 || full[12] == 2 || full[12] == 3) {
                  var btn_a = '<a href="<?php echo URL_API_SPPT_NEO_R?>pembatalan/'+full[13]+'" target="_blank" class="btn btn-info" title="Lihat Foto" style="margin-right: 5px"><i class="fa fa-file-image"></i></button>';
                } else {
                  var btn_a = '<a href="<?php echo URL_API_SPPT_NEO_R?>gambar/spptbaru/'+full[14]+'" target="_blank" class="btn btn-info" title="Lihat Foto" style="margin-right: 5px"><i class="fa fa-file-image"></i></button>';
                }

                var params = {
                  pawal_nop: nop,
                  pawal_thn: thn,
                  pawal_kel: kel,
                  pawal_kec: kec,
                  pawal_sts: sts,
                  pawal_ptgs: ptgs,
                  pawal_tgl_fr: tgl_fr,
                  pawal_tgl_to: tgl_to,
                  pawal_sts_ver: sts_ver,
                };
                var prm = decodeURIComponent($.param(params));

                var btn_x = '<a href="<?php echo active_module_url()?>lap_sppt/detail/'+full[0]+'/?'+prm+'" target="_blank" class="btn btn-success" title="Detail" style="margin-right: 5px"><i class="fa fa-search"></i></button>';
                // var btn_y = '<a href="<?php echo active_module_url()?>lap_sppt/terima/'+full[0]+'" class="btn btn-warning" title="Terima" style="margin-right: 5px"><i class="fa fa-check-circle"></i></button>';
                // var btn_z = '<a href="<?php echo active_module_url()?>lap_sppt/tolak/'+full[0]+'" class="btn btn-danger" title="Tolak" ><i class="fa fa-times-circle"></i></button>';
                // return btn_a + btn_x + btn_y + btn_z;
                return btn_a + btn_x;
              }
            },
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
          // "sAjaxSource": "<?php echo active_module_url();?>lap_sppt/grid/?sts=9"
      		"sAjaxSource": "<?php echo active_module_url();?>lap_sppt/grid/?"+data_params_awal
      	});


        $('#btn_add_users').click(function() {

            $('#USER_GROUP').val('6');
            $('#LOGIN_NAME').val('');
            $('#NAMA').val('');
            $('#PASSWOD').val('');
            $('#EMAIL').val('');
            $('#NIP').val('');
            sel_kec.style.display = "none";
            sel_kel.style.display = "none";

        });


        $("[id=btn_cari]").click(function(){
          reload_grid();
        });

        $('#btn_terima_sim').click(function(){
            $('#id_prf_terima').val(tmp_id_sim.toString());

            $('#prm_awal_nop_trm').val($('#c_nop').val());
            $('#prm_awal_thn_trm').val($('#c_thn').val());
            $('#prm_awal_kel_trm').val($('#KD_KEL').val());
            $('#prm_awal_kec_trm').val($('#KD_KEC').val());
            $('#prm_awal_sts_trm').val($('#STS').val());
            $('#prm_awal_ptgs_trm').val($('#c_ptgs').val());
            $('#prm_awal_tgl_fr_trm').val($('#c_tg_fr').val());
            $('#prm_awal_tgl_to_trm').val($('#c_tg_to').val());
            $('#prm_awal_sts_verif_trm').val($('#STS_VER').val());

            // console.log();
            $('#cuDialog_terima_sim').modal('show');
        });

        $('#btn_tolak_sim').click(function(){
            $('#id_prf_tolak').val(tmp_id_sim.toString());

            //// kiriman awal dari search 
            $('#prm_awal_nop_tlk').val($('#c_nop').val());
            $('#prm_awal_thn_tlk').val($('#c_thn').val());
            $('#prm_awal_kel_tlk').val($('#KD_KEL').val());
            $('#prm_awal_kec_tlk').val($('#KD_KEC').val());
            $('#prm_awal_sts_tlk').val($('#STS').val());
            $('#prm_awal_ptgs_tlk').val($('#c_ptgs').val());
            $('#prm_awal_tgl_fr_tlk').val($('#c_tg_fr').val());
            $('#prm_awal_tgl_to_tlk').val($('#c_tg_to').val());
            $('#prm_awal_sts_verif_tlk').val($('#STS_VER').val());

            // console.log();
            $('#cuDialog_tolak_sim').modal('show');
        });

        $('#btn_cetak_sim').click(function(){
          var kd_kec = $('#KD_KEC').val();
          var kd_kel =$('#KD_KEL').val();
          var c_thn =$('#c_thn').val();
          var c_nop = $('#c_nop').val();

          var filex = "xls";

          var rptparams = {
              kd_kec: kd_kec,
              kd_kel: kd_kel,
              c_thn: c_thn,
              c_nop :c_nop,
              filex: filex,
          };
          //
          var data = decodeURIComponent($.param(rptparams));
          var url = '<?php echo active_module_url($this->router->fetch_class()); ?>exp_excel_csv/?' + data;
          window.open(url);
        });

        $('#btn_tes').click(function(){
          var tes = $('#c_nop').val();
          alert(tes);
        });

        // $('#gap_form').wrap('<form id="form_tarif" action="<?php echo active_module_url()?>lap_sppt/detail/" method="post"></form>');

        $("[id=btn_detail]").click(function(){
            if(ID){
                var nop = $('#c_nop').val();
                var thn = $('#c_thn').val();
                var ptgs = $('#c_ptgs').val();
                var tgl_fr = $('#c_tg_fr').val();
                var tgl_to = $('#c_tg_to').val();
                var kel = $('#KD_KEL').val();
                var kec = $('#KD_KEC').val();
                var sts = $('#STS').val();
                var sts_ver = $('#STS_VER').val();

                var params = {
                  pawal_nop: nop,
                  pawal_thn: thn,
                  pawal_kel: kel,
                  pawal_kec: kec,
                  pawal_sts: sts,
                  pawal_ptgs: ptgs,
                  pawal_tgl_fr: tgl_fr,
                  pawal_tgl_to: tgl_to,
                  pawal_sts_ver: sts_ver,
                };
                var data_params = decodeURIComponent($.param(params));
                window.location = '<?php echo active_module_url();?>lap_sppt/detail/'+ID+'/?'+data_params;

            } else{
                alert('Harap pilih data terlebih dahulu...');
            }

        });

    });
</script>
