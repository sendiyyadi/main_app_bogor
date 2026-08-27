<?php //$this->load->view('_head');?>
<?php //$this->load->view(active_module().'/_navbar');?>
<?php $this->load->view('_head.php'); ?>       <!-- CSS JS -->
<?php include_once('_side_menu.php'); ?>    <!-- MENU SIDEBAR -->
<?php $this->load->view('_navbar'); ?>      <!-- NAVBAR MENU -->
<?php $this->load->view('_js.php'); ?>

<style>

.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}

#table1 {
   /** font-family: Arial, Arial, Helvetica, sans-serif;  **/
    border-collapse: collapse;
    font-size: 12px;
    width: 100%;
}

#table1 td, #table1 th {
    border: 1px solid #ddd;
    padding: 4px;
}

#table1 tr:nth-child(even){background-color: #f2f2f2;}
#table1 tr:hover {background-color: #ffa;}  /** #ddd=abu2  #ffa=kuning   *****/
#table1 th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4CAF50;  /* warna hijau */
    color: white;
}

</style>

<script>
    var mID;
    var mNIK;
    var mSTS;
    var oTable;
    function reload_grid() {
        var tgl_fr = $('#tgl_fr').val();
        var tgl_to = $('#tgl_to').val();
        var jns_ply = $('#jns_ply').val();
        var thn_ply = $('#thn_ply').val();
        var bundel_ply = $('#bundel_ply').val();
        var urut_ply = $('#urut_ply').val();
        var nop = $('#nop').val();

        var params = {
            tgl_fr : tgl_fr,
            tgl_to : tgl_to,
            jns_ply : jns_ply,
            thn_ply : thn_ply,
            bundel_ply : bundel_ply,
            urut_ply : urut_ply,
            nop : nop,
        };

        var data_params = decodeURIComponent($.param(params));
        oTable.fnReloadAjax("<?php echo active_module_url();?>monitoring_permo_upt/grid/?"+data_params);
    }

    function f_dtl(id) {
        window.location = '<?php echo active_module_url("monitoring_permo_upt/detail"); ?>'+id;
    }

    function f_edit(id, sts) {
        if(sts == 0) {
            window.location = '<?php echo active_module_url("monitoring_permo_upt/edit"); ?>'+id;
        } else {
            alert('Tidak bisa edit data. Status dokumen bukan Draft'); return false;
        }
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 13,
            "sPaginationType": "full_numbers",
            //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 0, "desc" ]],
            "aoColumnDefs": [
                { "aTargets": [0], "bSearchable": false, "bVisible": false, "sWidth": "", "sClass": "" },
                { "aTargets": [1], "bSearchable": true, "bVisible": true, "sWidth": "", "sClass": "" },
                { "aTargets": [2], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [4], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [5], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [6], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [7], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [8], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "",
                    "mRender": function( data, type, full) {
                        var edt = '<button class="btn btn-danger" onclick="f_edit(\''+full[0]+'\', '+full[9]+')" type="button">Edit</button>';
                        var dtl = '<button class="btn btn-warning" onclick="f_dtl(\''+full[0]+'\')" type="button" style="margin-left:5px">Detail</button>';
                        return edt + dtl;
                    }
                },
                { "aTargets": [9], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function (event) {
                    if ($(this).hasClass('row_selected')) {
                        mID = ''; 
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData( this );
                        mID = data[0];

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "fnDrawCallback": function( oSettings ) {
                mID = ''; 
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
            "sAjaxSource": "<?php echo active_module_url();?>monitoring_permo_upt/grid"
        });

        var tb_array = [];
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);



        $('#nop').formatter({
            'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
        });

        $('#tahun').formatter({
            'pattern': '{{9999}}',
        });

        var tgl_fr_dtp = $('#tgl_fr').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tgl_fr_dtp.hide();
        }).data('datepicker');

        var tgl_to_dtp = $('#tgl_to').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tgl_to_dtp.hide();
        }).data('datepicker');

        $("[id=btn_cari]").click(function(){
          reload_grid();
        });


    });
</script>

<div class="content" style="">
    <div class="container-fluid">

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#"><strong>MONITORING PELAYANAN</strong></a>
            </li>
        </ul>

        <?php
        if (validation_errors()) {
            echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
            echo validation_errors('<small>', '</small>');
            echo '</blockquote>';
        } ?>

        <?php echo msg_block();?>
        
        <!-- ROW 1 -->
        <div class="form-row">

            <!-- Tanggal Pelayanan -->
            <div class="col-md-4 mb-3 d-flex flex-column flex-md-row align-items-md-center">
              <label class="mb-1 mb-md-0 mr-md-2" style="min-width:85px;">Tgl Pelayanan</label>
              
              <div class="d-flex flex-column flex-md-row w-100">
                <input type="text" id="tgl_fr" class="form-control mb-2 mb-md-0">
                <span class="px-md-2 py-1 text-center">s/d</span>
                <input type="text" id="tgl_to" class="form-control">
              </div>
            </div>

            <!-- Jenis Pelayanan -->
            <div class="col-md-4 mb-3 d-flex flex-column flex-md-row align-items-md-center">
              <label class="mb-1 mb-md-0 mr-md-2" style="min-width:90px;">Jns Pelayanan</label>
              <?php echo $select_jns_ply; ?>
            </div>

        </div>

        <!-- ROW 2 -->
        <div class="form-row">

            <!-- No Pelayanan -->
            <div class="col-md-4 mb-3 d-flex flex-column flex-md-row align-items-md-center">
              <label class="mb-1 mb-md-0 mr-md-2" style="min-width:85px;">No Pelayanan</label>

              <div class="d-flex flex-column flex-md-row w-100">
                <input type="text" id="thn_ply" class="form-control mb-2 mb-md-0 mr-md-2" placeholder="Tahun">
                <input type="text" id="bundel_ply" class="form-control mb-2 mb-md-0 mr-md-2" placeholder="Bundel">
                <input type="text" id="urut_ply" class="form-control" placeholder="Urut">
              </div>
            </div>

            <!-- NOP -->
            <div class="col-md-3 mb-3 d-flex flex-column flex-md-row align-items-md-center">
              <label class="mb-1 mb-md-0 mr-md-2" style="min-width:50px;">NOP</label>
              <input type="text" id="nop" class="form-control w-100">
            </div>

            <!-- Cari -->
            <div class="col-md-1 mb-3 d-flex align-items-md-center">
              <button type="button" class="btn btn-primary btn-block w-100" id="btn_cari">Cari</button>
            </div>

        </div>

        <table class="table mt-2" id="table1">
            <thead>
            <tr>
                <th>id</th>
                <th>NO PLY</th>
                <th>NOP</th>
                <th>JNS PLY</th>
                <th>NAMA PEMOHON</th>
                <th>KECAMATAN</th>
                <th>KELURAHAN</th>
                <th>STATUS</th>
                <th>ACTION</th>
                <th>sts</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>
</div>
<?php //$this->load->view('_foot');?>
<!-- Footer -->
<?php $this->load->view('_foot.php'); ?>
<!-- End of Footer -->

<!-- Logout Modal-->
<?php $this->load->view('_logout_modal.php'); ?>
