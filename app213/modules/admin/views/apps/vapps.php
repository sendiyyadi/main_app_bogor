<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Aplikasi</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Pengaturan</a>
                                </li>
                                <li class="breadcrumb-item active">Aplikasi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Nama Aplikasi</th>
                                        <th>Direktori</th>
                                        <th>Disabled</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="12" class="text-center">Memuat Data...</td>
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
            // "sScrollY": "380px",
            /* "iDisplayLength": 100, */
            "bScrollCollapse": true,
            // "bJQueryUI": true,
            "bPaginate": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"toolbar">frtip',
            "aoColumnDefs": [{
                "bSearchable": false,
                "bVisible": false,
                "aTargets": [0]
            }],
            "aoColumns": [
                null,
                null,
                {
                    "sWidth": "20%"
                },
                {
                    "sWidth": "15%",
                    "sClass": "text-center"
                }
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
            "bSort": true,
            "bInfo": true,
            "bProcessing": true,
            "bFilter": true,
            "bAutoWidth": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>apps/grid"
        });
        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        // Settings Table Scroll Responsive
        let parent = $("#appTable").parent();
        let table_responsive = $("<div>").addClass("table-responsive mb-2").appendTo(parent);
        $("#appTable").appendTo("div.table-responsive");
        table_responsive.after($("#appTable_info"));
        $("#appTable_info").after($("#appTable_paginate"));
        // var tb_array = [
        // 	'<div class="btn-group pull-left" style="position: relative; margin-bottom: -50px;">',
        // 	'	<button id="btn_tambah" class="btn btn-outline-success btn-sm" type="button">Tambah</button>',
        // 	'	<button id="btn_edit" class="btn btn-outline-success btn-sm" type="button">Edit</button>',
        // 	'	<button id="btn_delete" class="btn btn-outline-success btn-sm" type="button">Hapus</button>',
        // 	'</div>',
        // ];
        var tb_array = [
            '<button type="button" id="btn_tambah" class="btn btn-primary waves-effect waves-light">Tambah <i class="uil uil-plus ms-2"></i></button>',
            '<button type="button" id="btn_edit" class="btn btn-warning waves-effect waves-light">Edit <i class="uil uil-edit-alt ms-2"></i></button>',
            '<button type="button" id="btn_delete" class="btn btn-danger waves-effect waves-light">Hapus <i class="uil uil-trash-alt ms-2"></i></button>',
        ];
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        $('#btn_tambah').click(function() {
            window.location = '<?php echo active_module_url(); ?>apps/add/';
        });

        $('#btn_edit').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>apps/edit/' + mID;
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
                        window.location = '<?php echo active_module_url(); ?>apps/delete/' + mID;
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

    function update_stat(id, a) {
        var val = Number(a);
        $.ajax({
            url: '<?php echo active_module_url() ?>apps/update_stat/' + id + '/' + val,
            success: function(data) {
                $('#app_id').html(data);
            }
        });
    }
</script>
<?= $this->load->view('layouts/footer.php'); ?>