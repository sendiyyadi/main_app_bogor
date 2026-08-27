<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Daftar NOP</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Daftar NOP</li>
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
                                <div class="">
                                    <div class="btn-group pull-left">
                                        <button id="btn_action" class="btn btn-success pull-left" type="button">Action</button>
                                    </div>
                                    <div class="btn-group pull-left">
                                        <button id="btn_detail" class="btn btn-primary pull-left" type="button">Detail</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div style="overflow-x:auto; width:100%;">
                                <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>rowid</th>
                                        <th>NOP</th>
                                        <th>ALAMAT OP</th>
                                        <th>NIK WP</th>
                                        <th>NAMA WP</th>
                                        <th>ALAMAT WP</th>
                                        <th>KELURAHAN WP</th>
                                        <th>KOTA WP</th>
                                        <th>STS REG</th>
                                        <th>STS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end card -->
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
   function reload_grid() {
        var statuskd_s = document.getElementById('status_kd');
        var statuskd = statuskd_s.options[statuskd_s.selectedIndex].value;
        var params = {
            status_kd : statuskd
            };

        var data_params = decodeURIComponent($.param(params));
        oTable.fnReloadAjax("<?php echo active_module_url();?>daftar_nop/grid/?"+data_params);
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "bScrollCollapse": true,
            "bPaginate": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"toolbar">frtip',
            "aoColumnDefs": [
                {
                    "bSearchable": false,
                    "bVisible": false,
                    "aTargets": [0]
                },
                {
                    "bSearchable": false,
                    "bVisible": false,
                    "aTargets": [9]
                }
            ],
            "aoColumns": [
                null,
                {
                    "sWidth": "15%",
                    "sClass": "text-center"
                },
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            "oLanguage": {
                "sLengthMenu": "Tampilkan _MENU_ entri",
                "sZeroRecords": "Tidak ada data",
                "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix": "",
                "sSearch": "Cari : ",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "&laquo;",
                    "sPrevious": "&lsaquo;",
                    "sNext": "&rsaquo;",
                    "sLast": "&raquo;",
                }
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        mID = ''; mNIK = ''; mSTS = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];
                        mNIK = data[3];
                        mSTS = data[9];

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "bSort": true,
            "bInfo": true,
            "bProcessing": true,
            "bFilter": true,
            "bAutoWidth": false,
            "bServerSide": true,
            "sAjaxSource": "<?php echo active_module_url(); ?>daftar_nop/grid"
        });

        // oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        // oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        // oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        // // Settings Table Scroll Responsive
        // let parent = $("#table1").parent();
        // let table_responsive = $("<div>").addClass("table-responsive mb-2").appendTo(parent);
        // $("#table1").appendTo("div.table-responsive");
        // table_responsive.after($("#table1_info"));
        // $("#table1_info").after($("#appTable_paginate"));

        var tb_array = [];
        // tb_array.push('<div class="btn-group pull-left"><button id="btn_action" class="btn btn-success pull-left" type="button">Action</button></div>');
        // tb_array.push('<div class="btn-group pull-left"><button id="btn_detail" class="btn btn-primary pull-left" type="button">Detail</button></div>');

        // var tb = tb_array.join(' ');
        // $("div.toolbar").html(tb);


        $('#btn_view').click(function() {
            if(mID) {
                // var params = {
                //     row_id: mID,
                // };
                // var data_params = decodeURIComponent($.param(params));
                // window.location = '<?php echo active_module_url();?>daftar_nop/view/?'+data_params;
                window.location = '<?php echo active_module_url();?>daftar_nop/view/'+mNIK;
            }else{
                alert('Silahkan pilih data yang akan diview');
            }
        });

        $('#btn_action').click(function() {
            if(mID) {
                if(mSTS == 0){
                    // var params = {
                    //     row_id: mID.toString(),
                    // };
                    // var data_params = decodeURIComponent($.param(params));
                    // // alert(data_params);
                    // window.location = '<?php echo active_module_url();?>daftar_nop/action/?'+data_params;
                    window.location = '<?php echo active_module_url();?>daftar_nop/action/'+mNIK;
                } else {
                    alert('Status Registrasi bukan Draft (0)')
                }
            }else{
                alert('Silahkan pilih data yang akan diedit');
            }
        });

        $('#btn_detail').click(function() {
            if(mID) {
                window.location = '<?php echo active_module_url();?>daftar_nop/detail/'+mNIK;
            }else{
                alert('Silahkan pilih data yang akan diedit');
            }
        });

        $('#status_kd').change(function(){
            reload_grid();
        });


    });
</script>