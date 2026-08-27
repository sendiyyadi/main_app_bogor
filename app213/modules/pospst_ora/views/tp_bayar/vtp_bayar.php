<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Tempat Pembayaran</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Users</a>
                                </li>
                                <li class="breadcrumb-item active">Tempat Pembayaran</li>
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
                                        <th>Kode</th>
                                        <th>Kanwil</th>
                                        <th>Kantor</th>
                                        <th>Tipe</th>
                                        <th>Nama TP</th>
                                        <th>Alamat TP</th>
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
    var mID;
    var oTable;

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            // "sScrollY": "380px",
            "bScrollCollapse": true,
            "bPaginate": true,
            // "bJQueryUI": true,
            "sDom": '<"toolbar">frtip',
            "aoColumnDefs": [{
                    "bSearchable": true,
                    "bVisible": true,
                    "aTargets": [0]
                },
                {
                    "bSearchable": true,
                    "bVisible": true,
                    "aTargets": [4]
                },
                {
                    "bSearchable": true,
                    "bVisible": true,
                    "aTargets": [5]
                },
            ],
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
            "bSort": true,
            "bInfo": true,
            "bProcessing": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>tp_bayar/grid"
        });

        /*
        var tb_array  = ['<div class="btn-group pull-left">'];
        if ("<?php echo $hak_add ?>" == 1)  {tb_array.push('<button id="btn_tambah" class="btn pull-left" type="button">Tambah</button>');}
        if ("<?php echo $hak_edit ?>" == 1) {tb_array.push(' <button id="btn_edit" class="btn pull-left" type="button">Edit</button>');}
        if ("<?php echo $hak_delete ?>" == 1){tb_array.push('   <button id="btn_delete" class="btn pull-left" type="button">Hapus</button>');}
        if ("<?php echo $hak_view ?>" == 1) {tb_array.push('<button id="btn_view" class="btn pull-left" type="button">View</button>');}
        tb_array.push('</div>');
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);
        */
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
        tb_array.push('</div>');
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        $('#btn_tambah').click(function() {
            // window.location = '#';
            window.location = '<?php echo active_module_url(); ?>tp_bayar/add/';
        });

        $('#btn_edit').click(function() {
            if (mID) {
                // window.location = '#';
                window.location = '<?php echo active_module_url(); ?>tp_bayar/edit/' + mID;
            } else {
                alert('Silahkan pilih data yang akan diedit');
            }
        });

        $('#btn_delete').click(function() {
            if (mID) {
                var hapus = confirm('Hapus data ini?');
                if (hapus == true) {
                    // window.location = '#';
                    window.location = '<?php echo active_module_url(); ?>tp_bayar/delete/' + mID;
                };
            } else {
                alert('Silahkan pilih data yang akan dihapus');
            }
        });
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>