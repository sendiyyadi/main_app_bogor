<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 d-flex align-items-center gap-2">
                            Privileges
                        </h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">User & Privileges</a>
                                </li>
                                <li class="breadcrumb-item active">Privileges</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block(); ?>

            <div style="width:100%; overflow-x: auto;">

            <div class="row" style="min-width:1800px">
                <div class="col-sm-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Group Privileges</h4>
                            <div class="d-inline-block mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0" id="forSelect">Aplikasi</span>
                                    </div>
                                    <select name="apps_id" id="apps_id" class="form-control select2 w-auto"><?= $select_app_modul; ?></select>
                                </div>
                            </div>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Kode Group</th>
                                        <th>Nama Group</th>
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
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Menu Privileges</h4>
                            <div class="d-flex align-items-center gap-2">
                                <?= $select_menu_utama; ?>
                                <div class="input-group w-auto">
                                    <input class="form-control" type="text" maxlength="1" name="tp_modul" id="tp_modul" style="width:80px" placeholder="M/S/T" />
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center gap-2" id="toolbarHead">
                                <button id="btn_go" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                                <button id="btn_refresh" class="btn btn-danger waves-effect waves-light" type="button">Reset All <i class="uil uil-redo ms-2"></i></button>
                            </div>
                            <table id="table2" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Kode</th>
                                        <th>Module</th>
                                        <th>Baca</th>
                                        <th>Tambah</th>
                                        <th>Edit</th>
                                        <th>Hapus</th>
                                        <th>Level</th>
                                        <th>Path Menu</th>
                                        <th>root_id</th>
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
                <div class="col-sm-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">Button Privileges</h4>
                            <table id="table3" class="table table-striped dt-responsive table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>#</th>
                                        <th>Button</th>
                                        <th>Hak</th>
                                        <th>Keterangan</th>
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
            </div> <!-- end row -->
            </div>

        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>

<?= $this->load->view('layouts/scripts.php'); ?>

<script src="<?php echo base_url() ?>assets/js_xls/excellentexport.js"></script>
<script src="<?php echo base_url() ?>assets/js_pdf/jspdf.min.js"></script>
<script src="<?php echo base_url() ?>assets/js_pdf/jspdf.plugin.autotable.src.js"></script>

<script>
    var mID;
    var dID;
    var oTable;
    var oTable2;
    var oTable3;

    var glo_module = "";
    var glo_grup_id = "";
    var glo_modul_id = "";
    var glo_modules_btn_id = "";
    var ket_btn = "";

    function get_judul() {
        var header = ['No.', 'Kode', 'Module', 'Path Menu'];
        return header;
    }

    function get_data() {

        var d = new Date();
        var n = d.getUTCMilliseconds();

        var table = $('#table2').DataTable();
        var get_data = table.fnGetData();

        var jason = JSON.stringify(get_data);
        var get_dtl = JSON.parse(jason);
        var dt_detil = [];

        for (var c = 0; c < get_dtl.length; c++) {
            var x = c;
            var detailData = [
                x,
                get_dtl[c][1],
                get_dtl[c][2],
                get_dtl[c][8]
            ];
            dt_detil.push(detailData);
        }
        return dt_detil;
    }

    function generat_pdf_ori() {
        var judul = get_judul();
        var data = get_data();
        var doc = new jsPDF('p', 'pt');
        doc.autoTable(judul, data);
        doc.save("data_export.pdf");
    }

    function examples_long() {
        var doc = new jsPDF('l', 'pt');
        var columnsLong = getColumns().concat([{
                title: shuffleSentence(),
                dataKey: "text"
            },
            {
                title: "Text with a\nlinebreak",
                dataKey: "text2"
            }
        ]);

        doc.text("Overflow 'ellipsize' (default)", 10, 40);
        doc.autoTable(columnsLong, getData(), {
            startY: 55,
            margin: {
                horizontal: 10
            },
            columnStyles: {
                text: {
                    columnWidth: 250
                }
            }
        });

        doc.text("Overflow 'linebreak'", 10, doc.autoTableEndPosY() + 30);
        doc.autoTable(columnsLong, getData(3), {
            startY: doc.autoTableEndPosY() + 45,
            margin: {
                horizontal: 10
            },
            styles: {
                overflow: 'linebreak'
            },
            bodyStyles: {
                valign: 'top'
            },
            columnStyles: {
                email: {
                    columnWidth: 'wrap'
                }
            },
        });
        return doc;
    };

    function generat_pdf() {

        var judul = get_judul();
        var data = get_data();
        var doc = new jsPDF('p', 'pt');

        doc.setFontSize(12);
        doc.setTextColor(0);
        doc.setFontStyle('bold');

        doc.text("Role Menu Akses", 10, doc.autoTableEndPosY() + 30);
        doc.autoTable(judul, data, {
            margin: {
                horizontal: 10
            },
            styles: {
                overflow: 'linebreak'
            },
            bodyStyles: {
                valign: 'top'
            },
        });
        doc.save("data_export.pdf");
    }

    function fn_new_api(format) {
        var file_nm = "data_export";
        var header = get_judul();
        var dt_main = [header];
        var data = get_data();
        Array.prototype.push.apply(dt_main, data);

        return ExcellentExport.convert({
            anchor: 'anchor_new_api-' + format,
            filename: file_nm,
            format: format
        }, [{
            name: 'Sheet 1',
            from: {
                array: dt_main
            }
        }]);
    }

    function get_menu_utama(app_id) {
        $.ajax({
            url: "<?php echo active_module_url() ?>privileges/get_menu_utama/" + app_id,
            success: function(j) {
                var data = $.parseJSON(j);
                var select = $('#root_id');
                select.html("");
                $.each(data, function(i, val) {
                    select.append($('<option />', {
                        value: val['ROOT_ID'],
                        text: val['NAMA']
                    }));
                });
            },
            error: function(xhr, desc, er) {
                alert(er);
            }
        });
    }

    function btn_tambah_subdtl() {
        if (glo_module == '') {
            alert("Module belum di Pilih...!");
        } else {
            document.getElementById('cuDialogButtonLabel').innerHTML = 'Tambah Button';
            document.getElementById('dtl_module').value = glo_module;
            document.getElementById('dtl_modul_id').value = glo_modul_id;

            document.getElementById('dtl_nama').value = '';
            document.getElementById('dtl_kode').value = '';
            document.getElementById('dtl_btn_no').value = '';

            $('#cuDialogButton').modal('show');
        }
    };

    function tambah_btn_detil() {
        var nama = document.getElementById('dtl_nama').value;
        var module_id = glo_modul_id;
        var kode = document.getElementById('dtl_kode').value;
        var btn_no = document.getElementById('dtl_btn_no').value;

        var params = {
            nama: nama,
            module_id: module_id,
            kode: kode,
            btn_no: btn_no,
        };
        var data_params = decodeURIComponent($.param(params));

        $.ajax({
            url: "<?php echo active_module_url() ?>privileges/tambah_btn_detil/?" + data_params,
            async: false,
            success: function(data) {
                //$('#pajak_id').html(data);
                $('#cuDialogButton').modal('hide');
            },
            error: function(xhr, desc, er) {
                alert(er);
            }
        });

    }

    $(document).ready(function() {

        oTable = $('#table1').dataTable({
            /* "sScrollY": "380px", */
            "bScrollCollapse": true,
            "bPaginate": true,
            // "bJQueryUI": true,
            "sDom": '<"toolbar">frtip',
            "sPaginationType": "full_numbers",
            "aaSorting": [
                [0, "asc"]
            ],
            "aoColumnDefs": [{
                "bSearchable": false,
                "bVisible": false,
                "aTargets": [0]
            }],
            "aoColumns": [
                null,
                {
                    "sWidth": ""
                },
                {
                    "sWidth": ""
                }

            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {

                        glo_module = "";
                        glo_modul_id = "";
                        glo_modules_btn_id = "";

                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];
                        glo_grup_id = data[0];
                        dID = '';
                        glo_module = "";
                        glo_modul_id = "";
                        glo_modules_btn_id = "";

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                        //
                        $('#root_id').val('0');
                        $('#tp_modul').val("");

                        var app_id = $('#apps_id').val();
                        var grup_id = glo_grup_id;
                        var modul_id = glo_modul_id;
                        var root_id = '0';
                        var tp_modul = "";

                        var params = {
                            app_id: app_id,
                            grup_id: grup_id,
                            modul_id: modul_id,
                            tp_modul: tp_modul,
                            root_id: root_id,
                        };
                        var data_params = decodeURIComponent($.param(params));

                        oTable2.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
                        oTable2.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_go/?' + data_params);

                        oTable3.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
                        oTable3.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_btn_go/?' + data_params);
                    }
                })
            },
            "fnInitComplete": function(oSettings, json) {
                if (!glo_grup_id) $('#apps_id').trigger('change');
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
            "bFilter": false,
            "bProcessing": true,
            "sAjaxSource": "<?php echo active_module_url(); ?>privileges/grid_grup_users"
        });

        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        // let parent = $("#table1").parent();
        // let table_responsive = $("<div>").addClass("table-responsive mb-2").appendTo(parent);
        // $("#table1").appendTo("div.table-responsive");

        let parent = $("#userTable").parent();
        let table_responsive = $("<div>").addClass("table-responsive mb-2").appendTo(parent);
        $("#userTable").appendTo("div.table-responsive");
        table_responsive.after($("#userTable_info"));
        $("#userTable_info").after($("#userTable_paginate"));

        oTable2 = $('#table2').dataTable({
            /* "sScrollY": "380px", */
            "bScrollCollapse": true,
            "bPaginate": true,
            // "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayLength": 10,
            "sDom": '<"toolbar2">frtip',
            //"aaSorting": [[ 0, "asc" ]],
            //"aaSorting": [[9,'desc'],[7,'desc'],[0,'desc']]  ,
            "aoColumnDefs": [{
                    "bSearchable": false,
                    "bVisible": false,
                    "aTargets": [0]
                },
                {
                    "bSearchable": false,
                    "sClass": "text-center",
                    "aTargets": [3]
                },
                {
                    "bSearchable": false,
                    "sClass": "text-center",
                    "aTargets": [4]
                },
                {
                    "bSearchable": false,
                    "sClass": "text-center",
                    "aTargets": [5]
                },
                {
                    "bSearchable": false,
                    "sClass": "text-center",
                    "aTargets": [6]
                },
                {
                    "bSearchable": false,
                    "sClass": "text-center",
                    "aTargets": [7]
                },
                {
                    "bSearchable": false,
                    "bVisible": false,
                    "aTargets": [9]
                },
            ],
            "aoColumns": [
                null,
                {
                    "sWidth": "100px"
                },
                {
                    "sWidth": "150px"
                },
                {
                    "sWidth": "10px"
                },
                {
                    "sWidth": "10px"
                },
                {
                    "sWidth": "10px"
                },
                {
                    "sWidth": "10px"
                },
                {
                    "sWidth": "10px"
                },
                {
                    "sWidth": "250px"
                },
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
                        /* dID = '';
                        $(this).removeClass('row_selected'); */
                        glo_module = "";
                        glo_modul_id = "";
                        glo_modules_btn_id = "";

                    } else {

                        var data = oTable2.fnGetData(this);
                        dID = data[0];
                        glo_module = data[2];
                        glo_modul_id = data[0];
                        glo_modules_btn_id = "";

                        oTable2.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                        //
                        var app_id = $('#apps_id').val();
                        var grup_id = glo_grup_id;
                        var modul_id = glo_modul_id;
                        var params = {
                            app_id: app_id,
                            grup_id: grup_id,
                            modul_id: modul_id,
                        };

                        var data_params = decodeURIComponent($.param(params));
                        oTable3.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
                        oTable3.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_btn_go/?' + data_params);
                    }
                })
            },
            "bSort": false,
            "bInfo": true,
            "bProcessing": true,
            "bFilter": true,
            "fnDrawCallback": function(settings) {
                $("#table2").next().removeClass("card");
                $("#table2")
                    .closest(".dataTables_wrapper")
                    .children("div:eq(0)")
                    .removeClass("row")
                    .addClass(
                        "d-flex align-items-center justify-content-between flex-wrap w-100"
                    )
                    .find(".col-sm-12")
                    .removeAttr("class");

                $("#table2")
                    .closest(".dataTables_wrapper")
                    .children("table.dataTable")
                    .wrap('<div class="table-responsive w-100"></div>');

                $("#table2")
                    .closest(".dataTables_wrapper")
                    .children("div:eq(1)")
                    .removeClass("row")
                    .addClass(
                        "d-flex align-items-center justify-content-between flex-wrap w-100 mt-2"
                    )
                    .find(".col-sm-12")
                    .removeAttr("class");
            },
            "sAjaxSource": "<?php echo active_module_url(); ?>privileges/grid_go/"
        });

        oTable2.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable2.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable2.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        let parent2 = $("#privilegeNavTable").parent();
        let table_responsive2 = $("<div>").addClass("table-responsive privnavTable mb-2").appendTo(parent2);
        $("#privilegeNavTable").appendTo("div.privnavTable");
        table_responsive2.after($("#privilegeNavTable_info"));
        $("#privilegeNavTable_info").after($("#privilegeNavTable_paginate"));

        var tb2_array = ['<div class="btn-group pull-left">'];

        tb2_array.push('<?php echo $select_menu_utama; ?>');
        tb2_array.push('<input class="input" type="text" maxlength="1" name="tp_modul" id="tp_modul" style="width:60px; height: 30px;" placeholder="M/S/T"/>');
        tb2_array.push('<div class="he" style="padding-left: 20px;">');
        tb2_array.push('<button id="btn_go" class="btn btn-outline-success btn-sm" type="button">Cari</button>');
        tb2_array.push('<strong>&nbsp;&nbsp;</strong>');
        tb2_array.push('<button id="btn_refresh" class="btn btn-outline-success btn-sm" type="button">Refresh</button>');
        tb2_array.push('</div>');
        tb2_array.push('</div>');

        var tb2 = tb2_array.join(' ');

        $("div.toolbar2").addClass("d-inline-block mb-2");
        $("div.toolbar2").append($("#toolbarHead"));
        // $("div.toolbar2").html(tb2);

        oTable3 = $('#table3').dataTable({
            /* "sScrollY": "380px", */
            "bScrollCollapse": true,
            "bPaginate": false,
            // "bJQueryUI": true,
            "sDom": '<"toolbar3">frtip',
            "aaSorting": [
                [1, "asc"]
            ],
            "aoColumnDefs": [{
                    "bSearchable": false,
                    "bVisible": false,
                    "aTargets": [0]
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "bVisible": true,
                    "sClass": "center",
                    "aTargets": [1]
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "bVisible": true,
                    "sClass": "center",
                    "aTargets": [2]
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "bVisible": true,
                    "sClass": "center",
                    "aTargets": [3]
                },
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "bVisible": true,
                    "aTargets": [4]
                },
            ],

            "aoColumns": [
                null,
                {
                    "sWidth": "5%"
                },
                {
                    "sWidth": "15%"
                },
                {
                    "sWidth": "12%"
                },
                null,

            ],

            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        /* dID = '';
                        $(this).removeClass('row_selected'); */
                    } else {
                        var data = oTable3.fnGetData(this);
                        //dID = data[0];
                        glo_modules_btn_id = data[0];
                        //ket_btn = data[4];

                        oTable3.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                });

            },
            "bSort": true,
            "bInfo": false,
            "bProcessing": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>privileges/grid_btn_go/"
        });

        var tb3_array = [
            <?php if ($this->session->userdata('userid') == -1) { ?> '<div class="btn-group">',
                '	<button id="btn_tambah_dtl" class="btn btn-info" onclick="btn_tambah_subdtl()" type="button">Tambah</button>',
                '	<button id="btn_delete_dtl" class="btn btn-danger" type="button">Hapus</button>',
                '</div>',
            <?php } ?>
        ];
        var tb3 = tb3_array.join(' ');
        $("div.toolbar3").html(tb3);

        $('#btn_tambah').click(function() {

            // begin parameter  
            var app_id = $('#apps_id').val();
            var app_selected = $("#apps_id option:selected").text();

            window.location = '<?php echo active_module_url(); ?>privileges/add/' + $('#apps_id').val() + '/' + app_selected;

        });

        $('#btn_delete').click(function() {
            if (glo_modul_id) {
                var hapus = confirm('Hapus data ini?');
                if (hapus == true) {
                    window.location = '<?php echo active_module_url(); ?>privileges/delete/' + glo_modul_id;
                };
            } else {
                alert('Silahkan pilih data yang akan dihapus');
            }
        });

        $('#btn_go').click(function() {

            if (!glo_grup_id) {
                select_top_row();
            }

            dID = '';
            glo_modul_id = '';
            glo_modules_btn_id = "";
            //
            var app_id = $('#apps_id').val();
            var grup_id = glo_grup_id;
            var modul_id = glo_modul_id;
            var root_id = $('#root_id').val();
            var tp_modul = $('#tp_modul').val();

            var params = {
                app_id: app_id,
                grup_id: grup_id,
                modul_id: modul_id,
                tp_modul: tp_modul,
                root_id: root_id,
            };

            var data_params = decodeURIComponent($.param(params));
            oTable2.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
            oTable2.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_go/?' + data_params);

            oTable3.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
            oTable3.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_btn_go/?' + data_params);

        });

        $('#btn_refresh').click(function() {

            if (!glo_grup_id) select_top_row();

            dID = '';
            glo_modul_id = '';
            glo_modules_btn_id = "";

            $('#tp_modul').val("");
            $('#root_id').val("0");
            //
            var app_id = $('#apps_id').val();
            var grup_id = glo_grup_id;
            var modul_id = glo_modul_id;
            var root_id = '0';
            var tp_modul = "";

            var params = {
                app_id: app_id,
                grup_id: grup_id,
                modul_id: modul_id,
                tp_modul: tp_modul,
                root_id: root_id,
            };

            var data_params = decodeURIComponent($.param(params));

            oTable2.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
            oTable2.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_go/?' + data_params);

            oTable3.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
            oTable3.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_btn_go/?' + data_params);

        });

        $('#apps_id').change(function() {

            if (!glo_grup_id) select_top_row();

            dID = '';
            glo_modul_id = '';
            glo_modules_btn_id = "";
            //
            var app_id = $('#apps_id').val();
            var grup_id = glo_grup_id;
            var modul_id = glo_modul_id;
            var root_id = '0';
            var tp_modul = "";

            var params = {
                app_id: app_id,
                grup_id: grup_id,
                modul_id: modul_id,
                tp_modul: tp_modul,
                root_id: root_id,
            };
            var data_params = decodeURIComponent($.param(params));

            get_menu_utama(app_id);

            oTable.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
            oTable.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_grup_users/?' + data_params);

            oTable2.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
            oTable2.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_go/?' + data_params);
            //
            oTable3.fnPageChange('first', true); // agar saat di tarik selalu page pertama, karena konsep bukan serverside
            oTable3.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_btn_go/?' + data_params);

        });

        function select_top_row() {

            var nTop = $('#table1 tbody tr')[0];
            var iPos = oTable.fnGetPosition(nTop);

            /* Use iPos to select the row */
            var data = oTable.fnGetData(iPos);
            mID = data[0];
            glo_grup_id = data[0];

            $('#table1 tbody tr:eq(0)').addClass('row_selected');
        }

        $('#btn_dtl_simpan').click(function(e) {

            var dtl_nama = $('#dtl_nama').val();
            var dtl_kode = $('#dtl_kode').val();
            var dtl_btn_no = $('#dtl_btn_no').val(); // document.getElementById('dtl_btn_no').value ;

            if (dtl_kode == '') {
                alert("Kode Button harus di isi...!");
                return;
            }
            if (dtl_nama == '') {
                alert("Keterangan harus di isi...!");
                return;
            }
            if (dtl_btn_no == '') {
                alert("No. Button harus di isi...!");
                return;
            }
            if (dtl_btn_no == '0') {
                alert("No. Button harus di isi...!");
                return;
            }

            tambah_btn_detil();

            var app_id = $('#apps_id').val();
            var grup_id = glo_grup_id;
            var modul_id = glo_modul_id;

            var params = {
                app_id: app_id,
                grup_id: grup_id,
                modul_id: modul_id,
            };
            var data_params = decodeURIComponent($.param(params));
            oTable3.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_btn_go/?' + data_params);
        });

        $('#btn_delete_dtl').click(function(e) {

            if (glo_modules_btn_id && glo_modul_id) {
                var hapus = confirm('Hapus data ini?' + glo_modules_btn_id);
                if (hapus == true) {

                    delete_btn_detil(glo_modules_btn_id);

                    var app_id = $('#apps_id').val();
                    var grup_id = glo_grup_id;
                    var modul_id = glo_modul_id;

                    var params = {
                        app_id: app_id,
                        grup_id: grup_id,
                        modul_id: modul_id,
                    };
                    var data_params = decodeURIComponent($.param(params));
                    oTable3.fnReloadAjax('<?php echo active_module_url(); ?>privileges/grid_btn_go/?' + data_params);
                };
            } else {
                alert('Silahkan pilih data yang akan dihapus');
            }
        });

        $("#cuDialogButton").draggable({
            handle: ".modal-header"
        });

    });

    function update_stat(gid, grup_id, fld, a) {

        var val = Number(a);
        $.ajax({
            url: '<?php echo active_module_url() ?>privileges/update_stat/' + gid + '/' + grup_id + '/' + fld + '/' + val,
            success: function(data) {}
        });
    }

    function update_stat_role_btn(group_id, modules_id, modules_btn_id, flg) {

        var val = Number(flg);
        $.ajax({
            url: '<?php echo active_module_url() ?>privileges/upd_stat_role_btn/' + group_id + '/' + modules_id + '/' + modules_btn_id + '/' + val,
            success: function(data) {}
        });
    }

    function delete_btn_detil(modules_btn_id) {
        $.ajax({
            url: '<?php echo active_module_url() ?>privileges/hapus_btn_detil/' + modules_btn_id,
            success: function(data) {}
        });
    }
</script>
<?= $this->load->view('layouts/footer.php'); ?>