<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 d-flex align-items-center gap-2">
                            Groups
                        </h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">User & Privileges</a>
                                </li>
                                <li class="breadcrumb-item active">Groups</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block(); ?>

            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
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
                </div>
            <!-- </div> -->

            <!-- <div class="row"> -->
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="d-inline-block">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-end-0" id="forSelect">Status User</span>
                                        </div>
                                        <?= $select_disabled; ?>
                                    </div>
                                </div>
                                <div class="d-inline-block">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-end-0" id="forSelect">Level</span>
                                        </div>
                                        <?= $select_level_id; ?>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="in_group" name="in_group">
                                    <label class="form-check-label" for="in_group">Show In-Group</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">User ID</span>
                                    </div>
                                    <input type="text" class="form-control" id="user_login" name="user_login">
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Nama</span>
                                    </div>
                                    <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center gap-2" id="toolbarHead">
                                <button id="btn_cari" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                                <button id="btn_refresh" class="btn btn-danger waves-effect waves-light" type="button">Reset All <i class="uil uil-redo ms-2"></i></button>
                            </div>
                            <table id="table2" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>In Group</th>
                                        <th>User ID</th>
                                        <th>Nama</th>
                                        <th>Level User</th>
                                        <th>Disabled</th>
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
                </div>
            </div>

        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<script>
    var mID;
    var dID;
    var oTable;
    var oTable2;

    function reload_detail() {

        document.getElementById('nama').value = '';
        document.getElementById('user_login').value = '';
        document.getElementById('disabled_id').value = '0';
        document.getElementById('level_id').value = '9';

        $("#in_group").prop("checked", false);

        var group_id = mID;

        if ($('#in_group').is(':checked')) {
            in_grup = 1;
        } else {
            in_grup = 0;
        }

        var sts_disabled = $('#disabled_id').val();
        var usr_login = $('#user_login').val();
        var nama = $('#nama').val();
        var lvl_id = $('#level_id').val();

        var params = {
            group_id: group_id,
            in_grup: in_grup,
            sts_disabled: sts_disabled,
            usr_login: usr_login,
            nama: nama,
            lvl_id: lvl_id
        };
        var data_params = decodeURIComponent($.param(params));
        oTable2.fnReloadAjax('<?php echo active_module_url(); ?>groups/grid_users_in_grup/?' + data_params);
    }

    function reload_grid() {

        var group_id = mID;
        if ($('#in_group').is(':checked')) {
            in_grup = 1;
        } else {
            in_grup = 0;
        }

        var sts_disabled = $('#disabled_id').val();
        var usr_login = $('#user_login').val();
        var nama = $('#nama').val();
        var lvl_id = $('#level_id').val();

        var params = {
            group_id: group_id,
            in_grup: in_grup,
            sts_disabled: sts_disabled,
            usr_login: usr_login,
            nama: nama,
            lvl_id: lvl_id
        };
        var data_params = decodeURIComponent($.param(params));
        oTable2.fnReloadAjax('<?php echo active_module_url(); ?>groups/grid_users_in_grup/?' + data_params);
    }

    function refresh_grid() {

        document.getElementById('nama').value = '';
        document.getElementById('user_login').value = '';
        document.getElementById('disabled_id').value = '0';
        document.getElementById('level_id').value = '9';

        $("#in_group").prop("checked", false);
        reload_grid();
    }

    $(document).ready(function() {

        oTable = $('#table1').dataTable({
            //	"sScrollY": "380px",
            "bScrollCollapse": true,
            "bPaginate": true,
            //	"bJQueryUI": true,
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
                    "sWidth": "20%"
                },
                {
                    "sWidth": "80%"
                }
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {

                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        mID = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];
                        dID = '';

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                        reload_detail();
                    }
                })
            },
            "fnInitComplete": function(oSettings, json) {
                if (!mID) selecttopRow();
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
            // "bFilter": false,
            "bProcessing": true,
            "sAjaxSource": "<?php echo active_module_url(); ?>groups/grid"
        });

        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        // Settings Table Scroll Responsive
        let parent = $("#userGroupTable").parent();
        let table_responsive = $("<div>").addClass("table-responsive mb-2").appendTo(parent);
        $("#userGroupTable").appendTo("div.table-responsive");
        table_responsive.after($("#userGroupTable_info"));
        $("#userGroupTable_info").after($("#userGroupTable_paginate"));

        oTable2 = $('#table2').dataTable({
            //"sScrollY": "380px",
            "iDisplayLength": 12,
            "sPaginationType": "full_numbers",
            "bScrollCollapse": true,
            "bPaginate": true,
            //	"bJQueryUI": true,
            "sDom": '<"toolbar2x">frtip',
            "aoColumnDefs": [{
                "bSearchable": false,
                "bVisible": false,
                "aTargets": [0]
            }],
            "aaSorting": [
                [2, "asc"]
            ],
            "aoColumns": [
                null,
                {
                    "sWidth": "4%",
                    "sClass": "text-center"
                },
                {
                    "sWidth": "10%"
                },
                {
                    "sWidth": "20%"
                },
                {
                    "sWidth": "6%"
                }, // level_nama
                {
                    "sWidth": "4%",
                    "sClass": "text-center"
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        dID = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable2.fnGetData(this);
                        dID = data[0];

                        oTable2.$('tr.row_selected').removeClass('row_selected');
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
            // "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>groups/grid_users_in_grup/"
        });

        oTable2.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable2.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable2.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        let parent2 = $("#groupsTableDetail").parent();
        let table_responsive2 = $("<div>").addClass("table-responsive mb-2 grDetail").appendTo(parent2);
        $("#groupsTableDetail").appendTo("div.grDetail");
        table_responsive2.after($("#groupsTableDetail_info"));
        $("#groupsTableDetail_info").after($("#groupsTableDetail_paginate"));

        var tb_array = [
            // '<div class="d-flex align-items-center gap-1">',
            '<button id="btn_tambah" class="btn btn-primary waves-effect waves-light" type="button">Tambah <i class="uil uil-plus ms-2"></i></button>',
            '<button id="btn_edit" class="btn btn-warning waves-effect waves-light" type="button">Edit <i class="uil uil-edit-alt ms-2"></i></button>',
            '<button id="btn_delete" class="btn btn-danger waves-effect waves-light" type="button">Hapus <i class="uil uil-trash-alt ms-2"></i></button>',
            // '</div>',
        ];

        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        // var tb2_array = [];
        // var tb2 = tb2_array.join(' ');
        // $("div.toolbar2x").html(tb2);
        $("div.toolbar2x").addClass("d-inline-block mb-2");
        $("div.toolbar2x").append($("#toolbarHead"));

        $('#btn_tambah').click(function() {
            window.location = '<?php echo active_module_url(); ?>groups/add/';
        });

        $('#in_group').click(function() {
            reload_grid();
        });

        $('#btn_edit').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>groups/edit/' + mID;
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
                // var hapus = confirm('Hapus data ini?');
                // if (hapus == true) {
                //     window.location = '<?php echo active_module_url(); ?>groups/delete/' + mID;
                // };
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

        function selecttopRow() {

            var nTop = $('#table1 tbody tr')[0];
            var iPos = oTable.fnGetPosition(nTop);

            /* Use iPos to select the row */
            var data = oTable.fnGetData(iPos);
            mID = data[0];
            dID = '';

            $('#table1 tbody tr:eq(0)').addClass('row_selected');
            reload_detail();
        }

        $("[id=btn_cari]").click(function() {
            reload_grid();
        });

        $("[id=btn_refresh]").click(function() {
            refresh_grid();
        });

    });

    function update_stat(gid, id, a) {
        var val = Number(a);
        $.ajax({
            url: '<?php echo active_module_url() ?>groups/update_stat_users_in_grup/' + gid + '/' + id + '/' + val,
            success: function(data) {
                /*  */
            }
        });
    }
</script>
<?= $this->load->view('layouts/footer.php'); ?>