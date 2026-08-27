<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

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
    var mNIK;
    var mSTS;
    var oTable;
    var mOtp;
    function reload_grid() {
        var statuskd_s = document.getElementById('status_kd');
        var statuskd = statuskd_s.options[statuskd_s.selectedIndex].value;
        var tgl_start = document.getElementById('tgl_start').value;
        var tgl_end = document.getElementById('tgl_end').value;
        var params = {
            status_kd : statuskd,
            tgl_start: tgl_start,
            tgl_end: tgl_end,
        };  
        var data_params = decodeURIComponent($.param(params));
        oTable.fnReloadAjax("<?php echo active_module_url();?>appr_bsre/grid/?"+data_params);
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 20,
            "sPaginationType": "full_numbers",
          //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 2, "asc" ]],
            "aoColumnDefs": [
                { "aTargets": [0], "bSearchable": false,  "bVisible": true,  "sWidth": "60px", "sClass": "" },
                { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [4], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [5], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [6], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
                { "aTargets": [7], "bSearchable": false,  "bVisible": true,  "sWidth": "100px", "sClass": "" },
                { "aTargets": [8], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
                { "aTargets": [9], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function (event) {
                    if ($(this).hasClass('row_selected')) {
                        mNIK = ''; mSTS = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData( this );
                        mNIK = data[1];
                        mSTS = data[6];
                        mOtp = data[9];
                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "fnDrawCallback": function( oSettings ) {
                mNIK = ''; mSTS = ''; mOtp = '';
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
            "sAjaxSource": "<?php echo active_module_url();?>appr_bsre/grid"
        });

        var tb_array = [];
        tb_array.push('<div class="btn-group pull-left"><button id="btn_action" class="btn btn-success pull-left" type="button">Action</button></div>');
        tb_array.push('<div class="btn-group pull-left"><button id="btn_detail" class="btn btn-primary pull-left" type="button">Detail</button></div>');

        var tb = tb_array.join(' ');
        // var tb = '';
        $("div.toolbar").html(tb);


        $('#btn_view').click(function() {
            if(mNIK) {
                // var params = {
                //     row_id: mNIK,
                // };
                // var data_params = decodeURIComponent($.param(params));
                // window.location = '<?php echo active_module_url();?>appr_bsre/view/?'+data_params;
                window.location = '<?php echo active_module_url();?>appr_bsre/view/'+mNIK;
            }else{
                alert('Silahkan pilih data yang akan diview');
            }
        });

        $('#btn_action').click(function() {
            if(mNIK) {
                if(mSTS == 0){
                    // var params = {
                    //     row_id: mNIK.toString(),
                    // };
                    // var data_params = decodeURIComponent($.param(params));
                    // // alert(data_params);
                    // window.location = '<?php echo active_module_url();?>appr_bsre/action/?'+data_params;
                    window.location = '<?php echo active_module_url();?>appr_bsre/action/'+mNIK+'/'+mSTS;
                } else {
                    alert('Status Registrasi bukan Draft (0)')
                }
            }else{
                alert('Silahkan pilih data yang akan diedit');
            }
        });

        $('#btn_detail').click(function() {
            if(mNIK) {
                window.location = '<?php echo active_module_url();?>appr_bsre/detail/'+mNIK+'/'+mSTS;
            }else{
                alert('Silahkan pilih data yang akan dilihat');
            }
        });

        $('#status_kd').change(function(){
            reload_grid();
        });
        var tg_start_dtp = $('#tgl_start').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tg_start_dtp.hide();
        }).data('datepicker');

        var tg_end_dtp = $('#tgl_end').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tg_end_dtp.hide();
        }).data('datepicker');


    });
</script>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Approve BSRE</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Approve BSRE</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block();?>
            <div class="row">
                <div class="col-12">

                    <!-- <div class="row">
                        <div style="margin-right: -40px;" class="col-md-1"><div class="controls">Status</div> </div><div class="col-md-3"><div class="controls"><?php echo $select_status; ?></div> </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row"> <div style="margin-right: -30px;" class="col-md-3">
                            <div class="controls">Status</div> </div><div class="col-md-5"><div class="controls"><?php echo $select_status; ?></div> </div></div>
                        </div>
                         <div style="margin-left: -60px;" class="col-md-4">
                            <div class="row">
                                <div class="col-md-3" style="margin-left: -25px;">Tgl Permohonan</div>
                                <div class="col-md-4">
                            <div class="controls"><input type="text" id="tgl_start" class="form-control" name="tgl_start"></div></div>   S/D<div class="col-md-4"><div class="controls"><input type="text" id="tgl_end" class="form-control" name="tgl_end"></div> </div>
                        </div>
                        </div>
                        <div class="col-md-1"><button onclick="reload_grid();" class="btn btn-primary" id="btn_cari">Cari</button></div>
                    </div>

                    <br>


                    <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIK</th>
                            <th>NOP</th>
                            <th>NAMA WP</th>
                            <th>NO REG</th>
                            <th>STS REG</th>
                            <th>STS</th>
                            <th>TANGGAL</th>
                            <th>create</th>
                            <th>otp_email</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>

        <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>
