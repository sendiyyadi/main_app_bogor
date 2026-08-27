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
                        <h4 class="mb-0">DAFTAR SPPT BERMASALAH</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Daftar SPPT Bermasalah</li>
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

                          <div class="form-group row">
                              <div class="col-sm-4">
                                  <button class="btn btn-success" data-toggle="modal" id="btn_approve" >APPROVE</button>
                                  <button class="btn btn-warning" data-toggle="modal" id="btn_tolak" >TOLAK</button>
                                  <button class="btn btn-danger" data-toggle="modal" id="btn_batal" >BATAL</button>
                              </div>
                              <div class="col-xm-1" style="align-self:center">
                                  NOP
                              </div>
                              <div class="col-sm-3">
                                  <input type="text" class="form-control form-control-user" id="c_nop" name="c_nop" />
                              </div>
                              <div class="col-sm-1">
                                  <button class="btn btn-info" id="btn_cari" >CARI</button>
                              </div>

                          </div>

                          <table class="table table-striped" id="mytable" style="margin-top: 10px">
                              <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>NOP</th>
                                  <th>TAHUN</th>
                                  <th>KELURAHAN</th>
                                  <th>KECAMATAN</th>
                                  <th>ALASAN</th>
                                  <th>USER ASSIGN</th>
                                  <th>ACTION BY</th>
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

  var nop    = $('#c_nop').val();
  // var kel    = $('#c_kel').val();
  // var kec    = $('#c_kec').val();

  var params = {
    nop: nop,
    // kel: kel,
    // kec: kec,
  };

  var data_params = decodeURIComponent($.param(params));
  oTable.fnReloadAjax("<?php echo active_module_url();?>sppt_bermasalah/get_nop_bermasalah/?"+data_params);

}



function refresh_grid() {
  document.getElementById('c_nop').value='';
  // document.getElementById('c_kel').value='';
  // document.getElementById('c_kec').value='';
  reload_grid();

}



var mID = '';
var mSTTSID = '';
var NOP;
var TAHUN;
var KELURAHAN;
var KECAMATAN;
var ALASAN;
var USER_ASSIGN;
var USER_APPROVE;
var STATUS;

$(document).ready(function () {
    

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
      { "bSearchable": false, "bVisible": false, "aTargets": [ 9 ] }
    ],
        "order": [[5, 'asc' ]],
    "aoColumns": [
      null,
      { "sWidth": "5%" ,"sClass": "center"},
      null,
      //{ "sWidth": "15%" },
//			{ "sWidth": "12%" ,"sClass": "center"},
//			{ "sWidth": "25%" ,"sClass": ""},
//			{ "sWidth": "12%" ,"sClass": ""},
//			{ "sWidth": "8%" ,"sClass": "center"},
      null,null,null,null,
      { "sWidth": "110px" ,"sClass": "center"},
      null,null
      //{ "sWidth": "6%" ,"sClass": "center"},
    ],
    "fnRowCallback": function (nRow, aData, iDisplayIndex) {
      $(nRow).on("click", function (event) {
        if ($(this).hasClass('row_selected')) {
          mID = ''; mSTTSID = '';
          /* $(this).removeClass('row_selected'); */
        } else {
          var data = oTable.fnGetData( this );
          mID = data[0];
          mSTTSID = data[9];

          oTable.$('tr.row_selected').removeClass('row_selected');
          $(this).addClass('row_selected');
        }
      })
    },
    "fnDrawCallback": function( oSettings ) {
      mID = ''; mSTTSID = '';
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
    "sAjaxSource": "<?php echo active_module_url();?>sppt_bermasalah/get_nop_bermasalah"
  });

  $('USER_GROUP').on('change', function (e) {
      var optionSelected = $("option:selected", this);
      var valueSelected = this.value;
      alert(valueSelected);
  });

  $('#btn_approve').click(function() {

      // alert('APPROVE '+mID);
      if(mID) {
        if(mSTTSID==0){
            var cnfr = confirm('Approve data ini?');
            if(cnfr==true) {
              window.location = '<?php echo active_module_url(); ?>sppt_bermasalah/approve/'+mID;
            };
        } else {
            alert('Status data bukan OPEN..');
        }

      } else {
        alert('Silahkan pilih data yang akan dihapus');
      }
  });

  $('#btn_tolak').click(function() {

      // alert('TOLAK '+mID);
      if(mID) {
        if(mSTTSID==0){
            var cnfr = confirm('Tolak data ini?');
            if(cnfr==true) {
              window.location = '<?php echo active_module_url(); ?>sppt_bermasalah/tolak/'+mID;
            };
        } else {
            alert('Status data bukan OPEN..');
        }
      } else {
        alert('Silahkan pilih data yang akan dihapus');
      }

  });

  $('#btn_batal').click(function() {

      // alert('BATAL '+mID);
      if(mID) {
        var cnfr = confirm('Batal data ini?');
        if(cnfr==true) {
          window.location = '<?php echo active_module_url(); ?>sppt_bermasalah/batal/'+mID;
        };
      } else {
        alert('Silahkan pilih data yang akan dihapus');
      }

  });

  $("[id=btn_cari]").click(function(){
    reload_grid();
  });



});
</script>
