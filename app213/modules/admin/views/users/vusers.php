<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">User</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">User & Privileges</a>
                                </li>
                                <li class="breadcrumb-item active">User</li>
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
                                        <th>NIP</th>
                                        <th>Nama Pegawai(PBB)</th>
                                        <th>Jabatan</th>
                                        <th>Email WP</th>
                                        <th>Disabled</th>
                                        <th>Tgl. Input</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="12" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

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
            // "sScrollY": "300px",
            "bScrollCollapse": true,
            "bPaginate": true,
            // "bJQueryUI": true,
            "sDom": '<"toolbar">frtip',
            "sPaginationType": "full_numbers",
            "aoColumnDefs": [{
                "bSearchable": false,
                "bVisible": false,
                "aTargets": [0]
            }],
            "aoColumns": [
                null,
                {
                    "sWidth": "12%"
                },
                null,
                {
                    "sWidth": "16%"
                },
                {
                    "sWidth": "16%"
                },
                {
                    "sWidth": "16%"
                },
                {
                    "sWidth": "16%"
                },
                {
                    "sWidth": "8%",
                    "sClass": "text-center"
                },
                {
                    "sWidth": "8%"
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        mID = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
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
            "bSort": true,
            "bInfo": true,
            "bProcessing": true,
            "sAjaxSource": "<?php echo active_module_url(); ?>users/grid"
        });

        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        // Settings Table Scroll Responsive
        let parent = $("#userTable").parent();
        let table_responsive = $("<div>").addClass("table-responsive mb-2").appendTo(parent);
        $("#userTable").appendTo("div.table-responsive");
        table_responsive.after($("#userTable_info"));
        $("#userTable_info").after($("#userTable_paginate"));

        $("div.toolbar").html('<div class="d-flex align-items-center gap-1"><button type="button" id="btn_tambah" class="btn btn-primary waves-effect waves-light">Tambah <i class="uil uil-plus ms-2"></i></button><button type="button" id="btn_edit" class="btn btn-warning waves-effect waves-light">Edit <i class="uil uil-edit-alt ms-2"></i></button><button type="button" id="btn_delete" class="btn btn-danger waves-effect waves-light">Hapus <i class="uil uil-trash-alt ms-2"></i></button></div></div>');
        $("div.toolbar").addClass("d-inline-block mb-2");

        $('#btn_tambah').click(function() {
            window.location = '<?php echo active_module_url(); ?>users/add/';
        });

        $('#btn_edit').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>users/edit/' + mID;
            } else {
                Swal.fire({
                    text: 'Silahkan pilih data yang akan diedit!',
                    icon: 'question',
                    confirmButtonColor: '#5b73e8'
                });
            }
        });

        $('#btn_delete').click(function() {
            if (mID) {
                Swal.fire({
                    title: "Hapus data ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes"
                }).then(function(result) {
                    if (result.value) {
                        window.location = '<?php echo active_module_url(); ?>users/delete/' + mID;
                    }
                });
            } else {
                Swal.fire({
                    text: 'Silahkan pilih data yang akan dihapus!',
                    icon: 'question',
                    confirmButtonColor: '#5b73e8'
                });
            }
        });
    });

    function update_unit(id, a) {
        var val = Number(a);
        $.ajax({
            url: '<?php echo active_module_url() ?>users/update_unit/' + id + '/' + val,
            success: function(data) {
                /*  */
            }
        });
    }

    function disable_user(id, a) {
        var val = Number(a);
        $.ajax({
            url: '<?php echo active_module_url() ?>users/disable_user/' + id + '/' + val,
            success: function(data) {
                /*  */
            }
        });
    }
</script>
<?= $this->load->view('layouts/footer.php'); ?>