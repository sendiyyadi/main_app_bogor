<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">User POSPBB</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Users</a>
                                </li>
                                <li class="breadcrumb-item active">User POSPBB</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block(); ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>User ID</th>
                                        <th>Nama</th>
                                        <th>Nip</th>
                                        <th>Nama Pegawai(PBB)</th>
                                        <th>Jabatan</th>
                                        <th>Tempat Pembayaran</th>
                                        <th>Alamat Tempat Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<script>
    function show_rpt(rpt) {

        var id = "0";
        var rptparams = {
            rpt: rpt,
            id: id,
        }
        //
        var data = decodeURIComponent($.param(rptparams));
        var url = '<?php echo active_module_url(); ?>pos_user/cetak_draft/pdf/?' + data;
        //
        var winparams = 'width=' + screen.width + ',height=' + screen.height + ',directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no';
        window.open(url, 'Laporan', winparams);
    }

    var mID;
    var oTable;

    $(document).ready(function() {

        oTable = $('#table1').dataTable({
            // "sScrollY": "380px",
            "bScrollCollapse": true,
            "bPaginate": true,
            "bFilter": false,
            // "bJQueryUI": true,
            "sDom": '<"toolbar">frtip',
            "aoColumnDefs": [{
                "bSearchable": false,
                "bVisible": false,
                "aTargets": [0]
            }],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        /* mID = '';
                        $(this).removeClass('row_selected'); */
                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "fnDrawCallback": function(settings) {
                $("#table1").next().removeClass("card");

                $("#table1")
                    .closest(".dataTables_wrapper")
                    .children("div:eq(0)")
                    .removeClass("row")
                    .addClass(
                        "d-flex align-items-center justify-content-between flex-wrap w-100"
                    )
                    .find(".col-sm-12")
                    .removeAttr("class");

                $("#table1")
                    .closest(".dataTables_wrapper")
                    .children("table.dataTable")
                    // .removeClass("row")
                    // .children()
                    // .removeClass("col-sm-12")
                    // .addClass("table-responsive w-100");
                    .wrap('<div class="table-responsive w-100"></div>');
                // .css("max-height", "500px");

                $("#table1")
                    .closest(".dataTables_wrapper")
                    .children("div:eq(1)")
                    .removeClass("row")
                    .addClass(
                        "d-flex align-items-center justify-content-between flex-wrap w-100 mt-2"
                    )
                    .find(".col-sm-12")
                    .removeAttr("class");
            },
            "bSort": false,
            "bInfo": true,
            "bProcessing": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>pos_user/grid"
        });

        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        var tb_array = ['<div>'];
        if ("<?php echo $hak_add ?>" == 1) {
            tb_array.push(' <button id="btn_tambah" class="btn btn-primary waves-effect waves-light" type="button">Tambah <i class="uil uil-plus ms-2"></i></button>');
        }
        if ("<?php echo $hak_edit ?>" == 1) {
            tb_array.push(' <button id="btn_edit" class="btn btn-warning waves-effect waves-light" type="button">Edit <i class="uil uil-edit-alt ms-2"></i></button>');
        }
        if ("<?php echo $hak_delete ?>" == 1) {
            tb_array.push(' <button id="btn_delete" class="btn btn-danger waves-effect waves-light" type="button">Hapus <i class="uil uil-trash-alt ms-2"></i></button>');
        }
        //tb_array.push('<button id="btn_cetak" class="btn btn-success waves-effect waves-light" type="button">Tes Cetak</button>');
        tb_array.push('</div>');
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        $('#btn_tambah').click(function() {
            // window.location = '#';
            window.location = '<?php echo active_module_url(); ?>pos_user/add/';
        });

        $('#btn_edit').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>pos_user/edit/' + mID;
            } else {
                alert('Silahkan pilih data yang akan diedit');
            }
        });

        $('#btn_delete').click(function() {
            if (mID) {
                // alert(mID);
                var hapus = confirm('Hapus data ini?');
                if (hapus == true) {
                    // window.location = '#';
                    window.location = '<?php echo active_module_url(); ?>pos_user/delete/' + mID;
                };
            } else {
                alert('Silahkan pilih data yang akan dihapus');
            }
        });

        $("[id=btn_cetak]").click(function() {
            show_rpt('rpt');
        });

    });

    function update_unit(id, a) {
        var val = Number(a);
        $.ajax({
            url: '<?php echo active_module_url() ?>pos_user/update_unit/' + id + '/' + val,
            success: function(data) {
                /*  */
            }
        });
    }

    function disable_user(id, a) {
        var val = Number(a);
        $.ajax({
            url: '<?php echo active_module_url() ?>pos_user/disable_user/' + id + '/' + val,
            success: function(data) {
                /*  */
            }
        });
    }
</script>

<?= $this->load->view('layouts/footer.php'); ?>