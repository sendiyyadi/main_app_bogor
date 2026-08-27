<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">NOP PROGRESSIVE</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">NOP PROGRESSIVE</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block();?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Status</span>
                                    </div>
                                    <?php echo $select_status; ?>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tgl Permohonan</span>
                                    </div>
                                    <input type="text" id="tgl_start" class="form-control" name="tgl_start" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">s/d</span>
                                    </div>
                                    <input type="text" id="tgl_end" class="form-control" name="tgl_end" autocomplete="off">
                                </div>

                                <div class="col-md-1"><button onclick="reload_grid();" class="btn btn-primary" id="btn_cari">Cari</button></div>
                            </div>

                            <br>


                            <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>IDX</th>
                                    <th>NO</th>
                                    <th>NIK</th>
                                    <th>NOP</th>
                                    <th>NAMA WP</th>
                                    <th>NO PERMOHONAN</th>
                                    <th>STS REG</th>
                                    <th>STS</th>
                                    <th>TANGGAL</th>
                                    <th>create</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
    var mID;
    var mNIK;
    var mSTS;
    var oTable;
    var crea_date;
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
        oTable.fnReloadAjax("<?php echo active_module_url().$controller;?>/grid/?"+data_params);
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 20,
            "sPaginationType": "full_numbers",
          //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 3, "asc" ]],
            "aoColumnDefs": [
            { "aTargets": [0], "bSearchable": false,  "bVisible": false,  "sWidth": "60px", "sClass": "" },
                { "aTargets": [1], "bSearchable": false,  "bVisible": true,  "sWidth": "60px", "sClass": "" },
                { "aTargets": [4], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [5], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [6], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [7], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
                { "aTargets": [8], "bSearchable": false,  "bVisible": true,  "sWidth": "100px", "sClass": "" },
                  { "aTargets": [9], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function (event) {
                    if ($(this).hasClass('row_selected')) {
                        mNIK = ''; mSTS = ''; crea_date='';mID='';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData( this );
                        mID=data[0];
                        mNIK = data[2];
                        mSTS = data[7];
                        crea_date = data[9];
                        oTable.$('tr.row_selected').removeClass('row_selected');
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
            "sAjaxSource": "<?php echo active_module_url().$controller;?>/grid"
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
                // window.location = '<?php echo active_module_url();?>reg_esppt/view/?'+data_params;
                window.location = '<?php echo active_module_url();?>reg_esppt/view/'+mNIK+'/'+mSTS;
            }else{
                alert('Silahkan pilih data yang akan diview');
            }
        });

        $('#btn_action').click(function() {
            if(mID) {
                if(mSTS == 0){
                    window.location = '<?php echo active_module_url().$controller;?>/action/'+mID;
                } else {
                    alert('Status Registrasi bukan Draft (0)')
                }
            }else{
                alert('Silahkan pilih data yang akan diedit');
            }
        });

        $('#btn_detail').click(function() {
            if(mNIK) {
                window.location = '<?php echo active_module_url().$controller;?>/detail/'+mID;
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