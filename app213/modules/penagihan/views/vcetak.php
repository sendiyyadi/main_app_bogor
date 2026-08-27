<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="shortcut icon" href="<?php echo base_url()?>assets/img/img_logo.ico">

  <title><?php echo APP_TITLE?> - <?php echo $this->uri->segment(1)?></title>

  <!-- Custom fonts for this template-->
  <!-- <link href="<?php echo base_url()?>assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->

  <link href="https://fonts.googleapis.com/css?family=Exo+2:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=cyrillic,latin-ext" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url()?>assets/sbadmin/css/sb-admin-2.css" rel="stylesheet">

  <!--<link href="<?php //echo base_url()?>assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">-->
  <link href="<?php echo base_url()?>assets/datatables/dataTables.css" rel="stylesheet">

  <!-- <link href="<?php echo base_url()?>assets/bootstrap/css/datepicker.css" rel="stylesheet"> -->



  <link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" rel="stylesheet">


</head>




<style>

body {
	background-color: #FFFFFF;
}

  table.dataTable tbody tr.row_selected {
    background-color: #B0BED9 !important;
  }

</style>

<?php //include_once('_side_menu.php'); ?>        <!-- MENU SIDEBAR -->

<?php //include_once('_navbar.php'); ?>            <!-- NAVBAR MENU -->

<!-- Begin Page Content -->
<!-- <div class="container-fluid"> -->
    <!--   Sppt_bermasalah CONTENT HERE -->
    <center>
        <h2>LAPORAN PENYERAHAN SPPT KABUPATEN BOGOR </h2>
    </center>
    <?php
    // echo msg_block();
    // if(validation_errors()){
    //   echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
    //   echo validation_errors('<small>','</small>');
    //   echo '</blockquote>';
    // }
    ?>
    <!-- <div class="form-group row">
        <div class="col-sm-4">
            <button class="btn btn-success" data-toggle="modal" id="btn_approve" >APPROVE</button>
            <button class="btn btn-warning" data-toggle="modal" id="btn_tolak" >TOLAK</button>
            <button class="btn btn-danger" data-toggle="modal" id="btn_batal" >BATAL</button>
        </div>
        <div class="col-xm-1">
            NOP
        </div>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-user" id="c_nop" name="c_nop" />
        </div>
        <div class="col-sm-1">
            <button class="btn btn-info" id="btn_cari" >CARI</button>
        </div>
    </div> -->

    <table class="table table-striped" id="mytable" style="margin-top: 10px">
        <thead>
        <tr>
            <th>NO</th>
            <th>NOP</th>
            <th>TGL PENYERAHAN</th>
            <th>KECAMATAN</th>
            <th>KELURAHAN</th>
            <th>TAHUN SPPT</th>
            <th>USER DISTRIBUSI</th>
        </tr>
        </thead>
    </table>
<!-- </div> -->


<!-- Footer -->
<?php //include_once('_foot.php'); ?>


<script src="<?php echo base_url() ?>assets/jquery/jquery.min.js"></script>

<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url() ?>assets/datatables/jquery.dataTables.min.js"></script>

<!-- <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script> -->
<!-- <script src=""></script> -->

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url() ?>assets/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url() ?>assets/sbadmin/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?php echo base_url() ?>assets/chart.js/Chart.min.js"></script>

<!-- tambahan datatables -->



<script>


    $(document).ready(function () {

        var nop    = '<?php echo $c_nop ?>';
        var kel    = '<?php echo $kel ?>';
        var kec    = '<?php echo $kec ?>';
        var login  = '<?php echo $login ?>';
        var thn    = '<?php echo $thn ?>';
        var sts    = '<?php echo $sts ?>';

        var params = {
          C_NOP: nop,
          KD_KEL: kel,
          KD_KEC: kec,
          LOGINNAME: login,
          THN: thn,
          STS: sts,
        };

        var data_params = decodeURIComponent($.param(params));

//DISABLE DULU
/*
        oTable = $('#mytable').dataTable({
      		// "sScrollY": "380px",
      		"iDisplayLength": 0,
      		"bScrollCollapse": true,
      		"bJQueryUI": true,
      		"bPaginate": true,
      		"sPaginationType": "full_numbers",
      		"sDom": 'Bfrtip',
          "buttons": [{
            "extend" : 'excel',
            "text" : 'Export to Excel',
            "exportOptions" : {
                "modifier" : {
                    // DataTables core
                    "order" : 'index',  // 'current', 'applied', 'index',  'original'
                    "page" : 'all',      // 'all',     'current'
                    "search" : 'none'     // 'none',    'applied', 'removed'
                }
            }
          } ],
      		"aoColumnDefs": [
            // { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
            // { "bSearchable": false, "bVisible": false, "aTargets": [ 9 ] }
      		],
          "order": [[0, 'asc' ]],
      		"aoColumns": [
      			null,null,null,null,null,null
      			// { "sWidth": "110px" ,"sClass": "center"}
      			//{ "sWidth": "6%" ,"sClass": "center"},
      		],
      		"fnRowCallback": function (nRow, aData, iDisplayIndex) {

      		},
          "fnDrawCallback": function( oSettings ) {

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
      		"sAjaxSource": "<?php echo base_url();?>Cetak/grid_cetak/?"+data_params
      	});
        */

        oTable = $('#mytable').dataTable({
          /* "sScrollY": "380px", */
      		"bScrollCollapse": true,
      		"bPaginate": false,
      		"bJQueryUI": true,
          // "sDom": '<"toolbar">frtip',
      		"sDom": 'Bfrtip',
          "buttons": [{
            "extend" : 'excel',
            "text" : 'Export to Excel',
            "exportOptions" : {
                "modifier" : {
                    // DataTables core
                    "order" : 'index',  // 'current', 'applied', 'index',  'original'
                    "page" : 'all',      // 'all',     'current'
                    "search" : 'none'     // 'none',    'applied', 'removed'
                }
            }
          } ],

      		"aoColumnDefs": [
      			// { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
      		],
      		"aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
      			null,
      		],

      		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
      			// $(nRow).on("click", function (event) {
      			// 	if ($(this).hasClass('row_selected')) {
      			// 		/* mID = '';
      			// 		$(this).removeClass('row_selected'); */
      			// 	} else {
      			// 		var data = oTable.fnGetData( this );
      			// 		mID = data[0];
            //
      			// 		oTable.$('tr.row_selected').removeClass('row_selected');
      			// 		$(this).addClass('row_selected');
      			// 	}
      			// })
      		},

      		"bSort": true,
          "bFilter": false,
      		"bInfo": false,
      		"bProcessing": false,
          "sAjaxSource": "<?php echo base_url();?>Cetak/grid_cetak/?"+data_params
        });

        $('#btn_cetak').click(function() {
            window.location = '<?php echo base_url(); ?>Cetak/to_excel/?'+data_params;
        });

    });
</script>
