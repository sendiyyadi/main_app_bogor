<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/sidebar'); ?>

<style>
    .right {
        text-align: right;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Piutang NOP</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Piutang</a>
                                </li>
                                <li class="breadcrumb-item active">Piutang NOP</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Nama WP</span>
                                    </div>
                                    <input class="form-control input" style="width:250px;" id="nama_wp" name="nama_wp" width="50" type="text" placeholder="min 5 digit" value="<?php if (isset($nama_wp)) echo $nama_wp ?>" />
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Alamat OP</span>
                                    </div>
                                    <input class="form-control input" style="width:250px;" id="alamat_op" name="alamat_op" width="50" type="text" placeholder="min 5 digit" value="<?php if (isset($alamat_op)) echo $alamat_op ?>" />
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <input class="form-control input" style="width:250px;" id="nop_pbb" name="nop_pbb" width="50" type="text" value="<?php if (isset($nop_pbb)) echo $nop_pbb ?>" placeholder="00.00.000.000.000.0000.0" />
                                </div>
                                <button id="btngo" name="btngo" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kecamatan</span>
                                    </div>
                                    <?php echo $select_kec; ?>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kelurahan</span>
                                    </div>
                                    <?php echo $select_kel; ?>
                                </div>
                            </div>
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NOP</th>
                                        <th>Nama WP</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Alamat OP</th>
                                        <th>Thn.SPPT</th>
                                        <th>Ketetapan</th>
                                        <th>Pokok</th>
                                        <th>Pengurangan</th>
                                        <th>Denda</th>
                                        <th>Bayar</th>
                                        <th>Sisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">TOTAL (max data : 20.000)</td>
                                        <td><span id="tetapan">&nbsp;</span></td>
                                        <td><span id="pokok">&nbsp;</span></td>
                                        <td><span id="kurang">&nbsp;</span></td>
                                        <td><span id="denda">&nbsp;</span></td>
                                        <td><span id="bayar">&nbsp;</span></td>
                                        <td><span id="sisa_ar">&nbsp;</span></td>
                                    </tr>
                                </tfoot>
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

<script src="<?php echo base_url() ?>assets/js_xls/excellentexport.js"></script>
<script src="<?php echo base_url() ?>assets/js_pdf/jspdf.min.js"></script>
<script src="<?php echo base_url() ?>assets/js_pdf/jspdf.plugin.autotable.src.js"></script>
<script>
    var oTable;

    function get_judul(param) {
        // judul xls /csv
        var header1 = ['NOP', 'Nama WP', 'Kecamatan', 'Kelurahan', 'Alamat OP', 'Thn.SPPT', 'Ketetapan', 'Pokok', 'Pengurangan', 'Denda', 'Bayar', 'Sisa', ];
        // judul pdf
        var header2 = [{
                title: "NOP",
                dataKey: "nop"
            },
            {
                title: "Nama WP",
                dataKey: "nm_wp"
            },
            {
                title: "Kecamatan",
                dataKey: "nm_kec_op"
            },
            {
                title: "Kelurahan",
                dataKey: "nm_kel_op"
            },
            {
                title: "Alamat OP",
                dataKey: "alamat_op"
            },
            {
                title: "Thn.SPPT",
                dataKey: "thn_pajak_sppt"
            },
            {
                title: "Ketetapan",
                dataKey: "ketetapan"
            },
            {
                title: "Pokok",
                dataKey: "pokok"
            },
            {
                title: "Pengurangan",
                dataKey: "pengurangan"
            },
            {
                title: "Denda",
                dataKey: "denda"
            },
            {
                title: "Bayar",
                dataKey: "bayar"
            },
            {
                title: "Sisa",
                dataKey: "sisa_ar"
            },
        ];
        if (param == 3) {
            return header2;
        } else {
            return header1;
        }
    }

    function formatRupiah(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }

    function get_data(param) {

        //var tabel_id = 'datatable';
        var table = $('#table1').DataTable();
        var get_data = table.fnGetData();
        //var get_data = oTable.fnGetData();     
        var jason = JSON.stringify(get_data);
        var get_dtl = JSON.parse(jason);
        var dt_detil = [];

        var sum_tetap = 0;
        var sum_kurang = 0;
        var sum_pokok = 0;
        var sum_denda = 0;
        var sum_bayar = 0;
        var sum_sisa = 0;
        var data = [];

        var rp_tetap = $('#tetapan').html();
        var rp_kurang = $('#kurang').html();
        var rp_pokok = $('#pokok').html();
        var rp_denda = $('#denda').html();
        var rp_bayar = $('#bayar').html();
        var rp_sisa = $('#sisa_ar').html();

        var tambahan = ["TOTAL", "", "", "", "", "", rp_tetap, rp_pokok, rp_kurang, rp_denda, rp_bayar, rp_sisa];
        get_dtl.push(tambahan);

        if (param == 3) {
            for (var a = 0; a < get_dtl.length; a++) {
                data.push({
                    nop: get_dtl[a][0],
                    nm_wp: get_dtl[a][1],
                    nm_kec_op: get_dtl[a][2],
                    nm_kel_op: get_dtl[a][3],
                    alamat_op: get_dtl[a][4],
                    thn_pajak_sppt: get_dtl[a][5],
                    ketetapan: get_dtl[a][6],
                    pokok: get_dtl[a][7],
                    pengurangan: get_dtl[a][8],
                    denda: get_dtl[a][9],
                    bayar: get_dtl[a][10],
                    sisa_ar: get_dtl[a][11]
                });
            }
            return data;
        } else {
            for (var i = 0; i < get_dtl.length; i++) {

                var ketetapan = get_dtl[i][6].replace(/[,.]/gi, '');
                var pokok = get_dtl[i][7].replace(/[,.]/gi, '');
                var pengurangan = get_dtl[i][8].replace(/[,.]/gi, '');
                var denda = get_dtl[i][9].replace(/[,.]/gi, '');
                var bayar = get_dtl[i][10].replace(/[,.]/gi, '');
                var sisa_ar = get_dtl[i][11].replace(/[,.]/gi, '');

                dt_detil.push([
                    get_dtl[i][0],
                    get_dtl[i][1],
                    get_dtl[i][2],
                    get_dtl[i][3],
                    get_dtl[i][4],
                    get_dtl[i][5],
                    parseFloat(ketetapan),
                    parseFloat(pokok),
                    parseFloat(pengurangan),
                    parseFloat(denda),
                    parseFloat(bayar),
                    parseFloat(sisa_ar)

                ]);
            }
            return dt_detil;
        }

    }

    function generat_pdflll() {

        //var doc = new jsPDF('p', 'pt');  p=potrait , l=landscape
        //var doc = new jsPDF('p', 'pt', 'legal');
        //var doc = new jsPDF('l', 'pt');
        //var doc = jsPDF("p", "pt","a4");
        var doc = new jsPDF('l', 'mm', [412, 792]); // letter [612,   792]
        var judul = get_judul(3);
        var data = get_data(3);
        // for(var c = 0; c < data.length; c++)
        var t_row = data.length - 1;
        doc.text("Piutang By NOP", 160, 50);
        // var res = doc.autoTableHtmlToJson(document.getElementById("datatable"));

        doc.autoTable({
            startY: 30,
            styles: {
                fontSize: 8,
                cellWidth: 'auto',
                halign: 'justify'
            },
            columnStyles: {
                4: {
                    cellWidth: 'wrap'
                },
                5: {
                    cellWidth: 'wrap'
                },
                6: {
                    cellWidth: 'wrap'
                }
            },
            rowPageBreak: 'avoid',
        });


        // return doc;
        doc.save("piutang_by_nop.pdf");
    }

    function generat_pdf() {

        var doc = new jsPDF('l', 'mm', [412, 792]); // letter [612,   792]
        var judul = get_judul(3);
        var data = get_data(3);
        // for(var c = 0; c < data.length; c++)
        var t_row = data.length - 1;
        doc.text("Piutang By NOP", 160, 10);
        // var res = doc.autoTableHtmlToJson(document.getElementById("datatable"));
        // console.log(data.length);


        doc.autoTable(judul, data, {

            //startY: false,
            startY: 20,
            theme: 'grid',
            tableWidth: 'auto',
            columnWidth: 'wrap',
            showHeader: 'everyPage',
            tableLineColor: 200,
            tableLineWidth: 0,

            margin: {
                horizontal: 12
            },

            columnStyles: {
                nop: {
                    columnWidth: 55
                },
                nm_wp: {
                    columnWidth: 'auto'
                },
                nm_kec_op: {
                    columnWidth: 'auto'
                },
                nm_kel_op: {
                    columnWidth: 'auto'
                },
                alamat_op: {
                    columnWidth: 'auto'
                },
                thn_pajak_sppt: {
                    columnWidth: 30
                },
                ketetapan: {
                    columnWidth: 40,
                    halign: 'right'
                },
                pokok: {
                    columnWidth: 40,
                    halign: 'right'
                },
                pengurangan: {
                    columnWidth: 40,
                    halign: 'right'
                },
                denda: {
                    columnWidth: 40,
                    halign: 'right'
                },
                bayar: {
                    columnWidth: 40,
                    halign: 'right'
                },
                sisa_ar: {
                    columnWidth: 40,
                    halign: 'right'
                }
            },

            styles: {
                overflow: 'linebreak',
                columnWidth: 'wrap',
                font: 'arial',
                fontSize: 12,
                cellPadding: 2,
                columnHeight: 'auto',
                halign: 'wrap',
                overflowColumns: 'linebreak'
            },

            drawRow: function(row, data) {

                row.height = 12;
                if (data.table.rows[data.row.index].cells['nm_wp'].text == 'xxxxxxx') {
                    // jika tinggi baris mau di ajust sesuai banyak text manipluasi disini , blm buat formulanya arig 2021-05-28
                    row.height = 34;
                }

            },

            rowPageBreak: 'avoid',

        });
        // return doc;
        doc.save("piutang_by_nop.pdf");
    }

    function generat_pdf_TES01() {

        //var doc = new jsPDF('p', 'pt');  p=potrait , l=landscape
        //var doc = new jsPDF('p', 'pt', 'legal');
        //var doc = new jsPDF('l', 'pt');
        //var doc = jsPDF("p", "pt","a4");
        var doc = new jsPDF('l', 'mm', [412, 792]); // letter [612,   792]
        var judul = get_judul(3);
        var data = get_data(3);
        // for(var c = 0; c < data.length; c++)
        var t_row = data.length - 1;
        doc.text("Piutang By NOP", 160, 50);
        // var res = doc.autoTableHtmlToJson(document.getElementById("datatable"));
        // console.log(data.length);
        doc.autoTable(judul, data, {

            startY: false,
            theme: 'grid',
            tableWidth: 'auto',
            columnWidth: 'wrap',
            showHeader: 'everyPage',
            tableLineColor: 200,
            tableLineWidth: 0,

            startY: 60,
            margin: {
                horizontal: 12
            },
            styles: {
                overflow: 'linebreak'
            },
            bodyStyles: {
                valign: 'top',
                fontSize: 11
            },
            columnWidth: 'wrap',

            columnStyles: {
                nop: {
                    columnWidth: 55
                },
                nm_wp: {
                    columnWidth: 'auto'
                },
                nm_kec_op: {
                    columnWidth: 'auto'
                },
                nm_kel_op: {
                    columnWidth: 'auto'
                },
                alamat_op: {
                    columnWidth: 'auto'
                },
                thn_pajak_sppt: {
                    columnWidth: 30
                },
                ketetapan: {
                    columnWidth: 50,
                    halign: 'right'
                },
                pokok: {
                    columnWidth: 50,
                    halign: 'right'
                },
                pengurangan: {
                    columnWidth: 50,
                    halign: 'right'
                },
                denda: {
                    columnWidth: 50,
                    halign: 'right'
                },
                bayar: {
                    columnWidth: 50,
                    halign: 'right'
                },
                sisa_ar: {
                    columnWidth: 50,
                    halign: 'right'
                }
            },

            headerStyles: {
                theme: 'grid'
            },
            styles: {
                overflow: 'linebreak',
                columnWidth: 'wrap',
                font: 'arial',
                fontSize: 10,
                cellPadding: 2,
                columnHeight: 'auto',
                halign: 'justify',
                overflowColumns: 'linebreak'
            },


            drawRow: function(row, data) {
                row.height = 12;
            },
            rowPageBreak: 'avoid',

        });
        // return doc;
        doc.save("piutang_by_nop.pdf");
    }

    function generat_pdf_ORI() {

        //var doc = new jsPDF('p', 'pt');  p=potrait , l=landscape
        //var doc = new jsPDF('p', 'pt', 'legal');
        //var doc = new jsPDF('l', 'pt');
        //var doc = jsPDF("p", "pt","a4");
        var doc = new jsPDF('l', 'mm', [412, 792]); // letter [612,   792]


        var judul = get_judul(3);
        var data = get_data(3);
        // for(var c = 0; c < data.length; c++)
        var t_row = data.length - 1;
        doc.text("Piutang By NOP", 160, 50);
        // var res = doc.autoTableHtmlToJson(document.getElementById("datatable"));
        // console.log(data.length);
        doc.autoTable(judul, data, {
            startY: 60,
            margin: {
                horizontal: 12
            },
            styles: {
                overflow: 'linebreak'
            },
            bodyStyles: {
                valign: 'top',
                fontSize: 11
            },
            columnWidth: 'wrap',
            columnStyles: {
                nop: {
                    columnWidth: 70
                },
                nm_wp: {
                    columnWidth: 'auto'
                },
                nm_kec_op: {
                    columnWidth: 'auto'
                },
                nm_kel_op: {
                    columnWidth: 'auto'
                },
                alamat_op: {
                    columnWidth: 'auto'
                },
                thn_pajak_sppt: {
                    columnWidth: 30
                },
                ketetapan: {
                    columnWidth: 50
                },
                pokok: {
                    columnWidth: 50
                },
                pengurangan: {
                    columnWidth: 50
                },
                denda: {
                    columnWidth: 50
                },
                bayar: {
                    columnWidth: 50
                },
                sisa_ar: {
                    columnWidth: 50
                }
            },
            drawRow: function(row, data) {
                row.height = 11;
            },
            createdCell: function(cell, data) {

                if (data.column.dataKey === 'ketetapan') {
                    cell.styles.halign = 'right';
                }
                if (data.column.dataKey === 'pokok') {
                    cell.styles.halign = 'right';
                }
                if (data.column.dataKey === 'pengurangan') {
                    cell.styles.halign = 'right';
                }
                if (data.column.dataKey === 'denda') {
                    cell.styles.halign = 'right';
                }
                if (data.column.dataKey === 'bayar') {
                    cell.styles.halign = 'right';
                }
                if (data.column.dataKey === 'sisa_ar') {
                    cell.styles.halign = 'right';
                }
            }

        });
        // return doc;
        doc.save("piutang_by_nop.pdf");
    }

    function fn_new_api(format) {

        var file_nm = "piutang_by_nop";
        var header = get_judul(1);
        var dt_main = [header];
        var data = get_data(1); //[];
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

    $(document).ready(function() {

        oTable = $('#table1').dataTable({
            // "iDisplayLength": 100,
            // "sScrollY": "270px",
            // "bJQueryUI": true,
            // "bAutoWidth": true,
            "bScrollCollapse": false,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": true,
            "sPaginationType": "full_numbers",
            "bSort": false,
            "bInfo": true,
            "bServerSide": false, //set to true
            "bProcessing": true,
            "sAjaxSource": "<?php echo $data_source ?>",
            // "sDom":'<"toolbar">fTl<"clear">rtip',
            "sDom": '<"toolbar">frtip',
            "aoColumns": [
                null,
                null,
                null,
                null,
                null,
                {
                    sWidth: '4%',
                    sClass: "center"
                },
                {
                    sWidth: '7%',
                    sClass: "right"
                },
                {
                    sWidth: '7%',
                    sClass: "right"
                },
                {
                    sWidth: '7%',
                    sClass: "right"
                },
                {
                    sWidth: '7%',
                    sClass: "right"
                },
                {
                    sWidth: '7%',
                    sClass: "right"
                },
                {
                    sWidth: '7%',
                    sClass: "right"
                }
            ],
            "aoColumnDefs": [{
                    "bSearchable": false,
                    "aTargets": [6],
                    "bSortable": true,
                    "aTargets": [6]
                },
                {
                    "bSearchable": false,
                    "aTargets": [7],
                    "bSortable": true,
                    "aTargets": [7]
                },
                {
                    "bSearchable": false,
                    "aTargets": [8],
                    "bSortable": true,
                    "aTargets": [8]
                },
                {
                    "bSearchable": false,
                    "aTargets": [9],
                    "bSortable": true,
                    "aTargets": [9]
                },
                {
                    "bSearchable": false,
                    "aTargets": [10],
                    "bSortable": true,
                    "aTargets": [10]
                },
                {
                    "bSearchable": false,
                    "aTargets": [11],
                    "bSortable": true,
                    "aTargets": [11]
                }
            ],
            "oTableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
            },
            "oLanguage": {
                "sProcessing": "<img border='0' src='<?php echo base_url('assets/img/ajax-loader-big-circle-ball.gif') ?>' />",
                "sLengthMenu": "Tampilkan _MENU_",
                // "sZeroRecords":  "Tidak ada data",
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
            "fnServerData": function(sSource, aoData, fnCallback) {
                $.getJSON(sSource, aoData, function(json) {
                    //Here you can do whatever you want with the additional data
                    // console.dir(json);
                    $('#tetapan').html(json['tetapan']);
                    $('#kurang').html(json['kurang']);
                    $('#pokok').html(json['pokok']);
                    $('#denda').html(json['denda']);
                    $('#bayar').html(json['bayar']);
                    $('#sisa_ar').html(json['sisa_ar']);

                    //Call the standard callback to redraw the table
                    fnCallback(json);
                });
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
        });

        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        var tb_array = [];
        //
        var param1 = "return fn_new_api('xls');";
        var param2 = "return fn_new_api('csv');";
        tb_array.push('<div class="d-flex align-items-center gap-2">');
        tb_array.push('<a class="btn btn-primary waves-effect waves-light" href="#" id="anchor_new_api-xls" onclick="' + param1 + '" type="button">xls</a>');
        tb_array.push('<a class="btn btn-primary waves-effect waves-light" href="#" id="anchor_new_api-csv" onclick="' + param2 + '" type="button">csv</a>');
        tb_array.push('<button class="btn btn-primary waves-effect waves-light" id="btn_pdf" type="button">pdf</button>');
        tb_array.push('</div>');

        var tb = tb_array.join(' ');

        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        $("#btngo").click(function() {
            var nama_wp = $("#nama_wp").val();
            var alamat_op = $("#alamat_op").val();
            var nop_pbb = $("#nop_pbb").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var params = "nama_wp=" + nama_wp + "&alamat_op=" + alamat_op + "&nop_pbb=" + nop_pbb + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;

            window.location = "<?php echo active_module_url(); ?>piutang_nop?" + params;

        });

        $("#kec_kd").change(function() {

            var nama_wp = $("#nama_wp").val();
            var alamat_op = $("#alamat_op").val();
            var nop_pbb = $("#nop_pbb").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = "000";

            var params = "nama_wp=" + nama_wp + "&alamat_op=" + alamat_op + "&nop_pbb=" + nop_pbb + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;
            window.location = "<?php echo active_module_url(); ?>piutang_nop?" + params;

        });

        $("#kel_kd").change(function() {

            var nama_wp = $("#nama_wp").val();
            var alamat_op = $("#alamat_op").val();
            var nop_pbb = $("#nop_pbb").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();

            var params = "nama_wp=" + nama_wp + "&alamat_op=" + alamat_op + "&nop_pbb=" + nop_pbb + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;
            window.location = "<?php echo active_module_url(); ?>piutang_nop?" + params;
        });

    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>