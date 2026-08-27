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
                        <h4 class="mb-0">DAFTAR USULAN PERUBAHAN ALAMAT SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Daftar Usulan Perubahan Alamat SPPT</li>
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
                                <div class="col-md-3">
                                    <?php echo $select_status; ?>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:5px">
                                <div class="col-md-3">
                                    <input class="form-control" type="text" name="c_nop" id="c_nop" placeholder="NOP" value="<?php echo $c_nop;?>" maxlength="30" />
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" name="c_thn" id="c_thn" placeholder="TAHUN" value="<?php echo $c_thn;?>" />
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-info" id="btn_cari" >CARI</button>
                                    <button class="btn btn-success" id="btn_detail" >DETAIL</button>
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
  var thn = $('#c_thn').val();
  var kel = $('#KD_KEL').val();
  var kec = $('#KD_KEC').val();
  var sts = $('#STS').val();

  // alert(kec);

  var params = {
    nop: nop,
    thn: thn,
    kel: kel,
    kec: kec,
    sts: sts,
  };

  var data_params = decodeURIComponent($.param(params));
  oTable.fnReloadAjax("<?php echo active_module_url();?>perubahan_sppt/grid/?"+data_params);

}



function refresh_grid() {
  document.getElementById('c_nop').value='';
  document.getElementById('KD_KEL').value='999999';
  document.getElementById('KD_KEC').value='999999';
  reload_grid();

}

function get_kelurahan(kec_id) {
	$.ajax({
		url: "<?php echo active_module_url()?>perubahan_sppt/get_kelurahan/"+kec_id,
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
        window.history.replaceState({}, "", "<?php echo active_module_url();?>perubahan_sppt/");

        // BUAT PASINGAN DARI DTAIL
        var nop = $('#c_nop').val();
        var thn = $('#c_thn').val();
        var kel = $('#KD_KEL').val();
        var kec = $('#KD_KEC').val();
        var sts = $('#STS').val();

        var params = {
          nop: nop, thn: thn, kel: kel, kec: kec, sts: sts,
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
          // "sAjaxSource": "<?php echo active_module_url();?>Perubahan_sppt/grid/?sts=9"
      		"sAjaxSource": "<?php echo active_module_url();?>perubahan_sppt/grid/?"+data_params_awal
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

        // $('#gap_form').wrap('<form id="form_tarif" action="<?php echo active_module_url()?>perubahan_sppt/detail/" method="post"></form>');

        $("[id=btn_detail]").click(function(){
            if(ID){
                var nop = $('#c_nop').val();
                var thn = $('#c_thn').val();
                var kel = $('#KD_KEL').val();
                var kec = $('#KD_KEC').val();
                var sts = $('#STS').val();

                var params = {
                  pawal_nop: nop,
                  pawal_thn: thn,
                  pawal_kel: kel,
                  pawal_kec: kec,
                  pawal_sts: sts,
                };
                var data_params = decodeURIComponent($.param(params));
                window.location = '<?php echo active_module_url();?>perubahan_sppt/detail/'+ID+'/?'+data_params;

                // var mode = 1;

                // window.history.replaceState({}, "", "<?php echo active_module_url();?>perubahan_sppt/detail/aaaaaa");
                // window.history.pushState({}, "", "<?php echo active_module_url();?>perubahan_sppt/detail/aaaaaa");


                // var http = new XMLHttpRequest();
                // var url = '<?php echo active_module_url();?>perubahan_sppt/detail/'+ID;
                //
                // var nop = $('#c_nop').val();
                // var thn = $('#c_thn').val();
                // var kel = $('#KD_KEL').val();
                // var kec = $('#KD_KEC').val();
                // var sts = $('#STS').val();
                //
                // var params = {
                //   pawal_nop: nop,
                //   pawal_thn: thn,
                //   pawal_kel: kel,
                //   pawal_kec: kec,
                //   pawal_sts: sts,
                // };
                // var data_params = decodeURIComponent($.param(params));
                // var params = 'orem=ipsum&name=binny';
                //
                // http.open('POST', url, true);
                // //Send the proper header information along with the request
                // http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                // http.onreadystatechange = function() {//Call a function when the state changes.
                //     if(http.readyState == 4 && http.status == 200) {
                //         alert(http.responseText);
                //     }
                // }
                // http.send(data_params);

            } else{
                alert('Harap pilih data terlebih dahulu...');
            }

        });

    });
</script>
