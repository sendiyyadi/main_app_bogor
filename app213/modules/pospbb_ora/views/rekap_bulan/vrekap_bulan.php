<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Transaksi Pembayaran - Rekap Bulanan</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Transaksi</a>
                                </li>
                                <li class="breadcrumb-item active">Transaksi Pembayaran - Rekap Bulanan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php echo form_open('#', array('id' => 'myform', 'class' => 'form-horizontal')); ?>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Thn Bayar</span>
                                    </div>
                                    <?= $select_thn_bayar; ?>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Thn SPPT</span>
                                    </div>
                                    <?= $select_thn_sppt1; ?>
                                </div>
                                <div class="col-xs-1">
                                    <span>s.d</span>
                                </div>
                                <?= $select_thn_sppt2; ?>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Buku</span>
                                    </div>
                                    <?= $select_buku; ?>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">TP Bayar</span>
                                    </div>
                                    <?= $select_tp_bayar; ?>
                                </div>
                                <button id="btngo" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kecamatan</span>
                                    </div>
                                    <?= $select_kecamatan; ?>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kelurahan</span>
                                    </div>
                                    <?= $select_kelurahan; ?>
                                </div>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="btnprint" name="btnprint"><i class="uil-print"></i> Print</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="btn_csv" name="btn_csv"><i class="uil-download-alt"></i> Download (CSV)</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="btn_xls" name="btn_xls"><i class="uil-download-alt"></i> Download (XLS)</button>
                            </div>
                            </form>
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Uraian</th>
                                        <th>Thn SPPT</th>
                                        <th>Pokok</th>
                                        <th>Denda</th>
                                        <th>Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">TOTAL</td>
                                        <td><span id="pokok">&nbsp;</span></td>
                                        <td><span id="denda">&nbsp;</span></td>
                                        <td><span id="total">&nbsp;</span></td>
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
        var header1 = ['Bulan', 'Uraian', 'Thn.SPPT', 'Pokok', 'Denda', 'Bayar', ];
        var header2 = [{
                title: "Tanggal",
                dataKey: "tanggal"
            },
            {
                title: "Uraian",
                dataKey: "uraian"
            },
            {
                title: "Thn.SPPT",
                dataKey: "thn_sppt"
            },
            {
                title: "Pokok",
                dataKey: "pokok"
            },
            {
                title: "Denda",
                dataKey: "denda"
            },
            {
                title: "Bayar",
                dataKey: "bayar"
            }
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
        var table = $('#datatable').DataTable();
        // var get_data = table.fnGetData();
        var get_data = table.data().toArray();
        // var get_data = oTable.fnGetData();     
        var jason = JSON.stringify(get_data);
        var get_dtl = JSON.parse(jason);
        var dt_detil = [];
        var sum_pokok = 0;
        var sum_denda = 0;
        var sum_bayar = 0;
        var data = [];

        var rp_pokok = $('#pokok').html();
        var rp_denda = $('#denda').html();
        var rp_bayar = $('#total').html();
        var tambahan = ["TOTAL", "", "", rp_pokok, rp_denda, rp_bayar];
        get_dtl.push(tambahan);

        if (param == 3) {
            for (var a = 0; a < get_dtl.length; a++) {
                data.push({
                    tanggal: get_dtl[a][0],
                    uraian: get_dtl[a][1],
                    thn_sppt: get_dtl[a][2],
                    pokok: get_dtl[a][3],
                    denda: get_dtl[a][4],
                    bayar: get_dtl[a][5]
                });
            }
            return data;
        } else {
            for (var i = 0; i < get_dtl.length; i++) {
                var pokok = get_dtl[i][3].replace(/[,.]/gi, '');
                var denda = get_dtl[i][4].replace(/[,.]/gi, '');
                var bayar = get_dtl[i][5].replace(/[,.]/gi, '');
                dt_detil.push([get_dtl[i][0],
                    get_dtl[i][1],
                    get_dtl[i][2],
                    parseFloat(pokok),
                    parseFloat(denda),
                    parseFloat(bayar)
                ]);
            }
            return dt_detil;
        }

    }


    function generat_pdf() {
        var doc = new jsPDF('p', 'pt');
        var judul = get_judul(3);
        var data = get_data(3);
        // for(var c = 0; c < data.length; c++)
        var t_row = data.length - 1;
        doc.text("Transaksi Pembayaran - Rekap Bulanan", 160, 50);
        // var res = doc.autoTableHtmlToJson(document.getElementById("datatable"));
        // console.log(data.length);
        doc.autoTable(judul, data, {
            startY: 60,
            margin: {
                horizontal: 5
            },
            styles: {
                overflow: 'linebreak'
            },
            bodyStyles: {
                valign: 'top',
                fontSize: 9
            },
            columnStyles: {
                fontSize: 9
            },
            createdCell: function(cell, data) {
                if (data.column.dataKey === 'pokok') {
                    cell.styles.halign = 'right';
                }
                if (data.column.dataKey === 'denda') {
                    cell.styles.halign = 'right';
                }
                if (data.column.dataKey === 'bayar') {
                    cell.styles.halign = 'right';
                }
            }

        });
        // return doc;
        doc.save("Rekap_bulanan.pdf");
    }

    function fn_new_api(format) {

        var file_nm = "Rekap_bulanan";
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
            "bScrollCollapse": true,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": true,
            "sPaginationType": "full_numbers",
            "bSort": false,
            "bInfo": true,
            "bServerSide": false,
            "bProcessing": true,
            "sAjaxSource": "<?php echo $data_source ?>",
            // "sDom":'<"toolbar">fTl<"clear">rtip',
            "sDom": '<"toolbar">frtip',
            // "sDom": '<"H"lfr>t<"F"ip>T',
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
            "fnInitComplete": function(oSettings, json) {
                $('#pokok').html(json['pokok']);
                $('#denda').html(json['denda']);
                $('#total').html(json['total']);
                oTable.fnAdjustColumnSizing();
            },
        });

        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        var tb_array = [];
        // var param = "return fn_new_api('xls');";
        // excel = '<div class="pull-left">';
        // excel = excel + '<a href="#" id="anchor_new_api-xls" onclick="' + param + '" class="btn pull-left" type="button">';
        // excel = excel + 'xls</a></div>';
        // tb_array.push(excel);

        // var param = "return fn_new_api('csv');";
        // excel = '<div class="pull-left">';
        // excel = excel + '<a href="#" id="anchor_new_api-csv" onclick="' + param + '" class="btn pull-left" type="button">';
        // excel = excel + 'csv</a></div>';
        // tb_array.push(excel);

        // pdf = '<div class=" pull-left">';
        // pdf = pdf + '<button id="btn_pdf" onclick="generat_pdf()" class="btn pull-left" type="button">';
        // pdf = pdf + 'pdf</button></div>';
        // tb_array.push(pdf);
        // var tb = ''; tb_array.join(' ');

        //
        var param1 = "return fn_new_api('xls');";
        var param2 = "return fn_new_api('csv');";
        tb_array.push('<div class="d-flex align-items-center gap-2">');
        tb_array.push('<a class="btn btn-primary waves-effect waves-light" href="#" id="anchor_new_api-xls" onclick="' + param1 + '" type="button">xls</a>');
        tb_array.push('<a class="btn btn-primary waves-effect waves-light" href="#" id="anchor_new_api-csv" onclick="' + param2 + '" type="button">csv</a>');
        tb_array.push('<button class="btn btn-primary waves-effect waves-light" id="btn_pdf" onclick="generat_pdf()" type="button">pdf</button>');
        tb_array.push('</div>');

        var tb = tb_array.join(' ');

        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        $("#tahunx, #kec_kdx, #kel_kdx, #bukux, #tahun_sppt1x, #tahun_sppt2x, #tp_kdx").change(function() {

            var tahun = $("#tahun").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();

            if ($(this).attr('name') == 'kec_kd') {
                $("#kel_kd").val('000');
            }

            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tp = $("#tp_kd").val();
            window.location = "<?php echo active_module_url() . 'rekap_bulan/grid/' ?>?tahun=" + tahun + "&tahun_sppt1=" + tahun_sppt1 + "&tahun_sppt2=" + tahun_sppt2 + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd + "&buku=" + buku + "&tp_kd=" + tp;

        });

        $("#kec_kd, #kel_kd").change(function() {

            var tahun = $("#tahun").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();

            if ($(this).attr('name') == 'kec_kd') {
                $("#kel_kd").val('000');
            }
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tp = $("#tp_kd").val();

            var params = "?tahun=" + tahun + "&tahun_sppt1=" + tahun_sppt1 + "&tahun_sppt2=" + tahun_sppt2 + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;
            params = params + "&buku=" + buku + "&tp_kd=" + tp;
            window.location = "<?php echo active_module_url() . 'rekap_bulan' ?>" + params;

        });

        $('#btngo').click(function() {

            var tahun = $("#tahun").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tp = $("#tp_kd").val();

            var params = "?tahun=" + tahun + "&tahun_sppt1=" + tahun_sppt1 + "&tahun_sppt2=" + tahun_sppt2 + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;
            params = params + "&buku=" + buku + "&tp_kd=" + tp;
            window.location = "<?php echo active_module_url() . 'rekap_bulan' ?>" + params;

        });

        $('#btnprint').click(function() {
            var tahun = $("#tahun").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tp = $("#tp_kd").val();

            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open("<?php echo active_module_url() . 'trans_rpt/cetak/pdf/' ?>3/" + kec_kd + "/" + kel_kd + "/" + tahun_sppt1 + "/" + tahun_sppt2 + "/" + buku + "/" + tahun + "/" + tp, 'Laporan', winparams);
            return false;
        });

        $('#btn_csv').click(function() {
            var url = '<?php echo active_module_url('trans_rpt/csv_rekap_bulanan'); ?>';

            $('#myform').attr('action', url);
            $('#myform').submit();
            return false;
        });

        $('#btn_xls').click(function(){
        var rptparams;
        var kec_kd   = $("#kec_kd").val();
        var kel_kd   = $("#kel_kd").val();
        var buku = $("#buku").val();
        var tahun = $("#tahun").val();
        var tahun_sppt1 = $("#tahun_sppt1").val();
        var tahun_sppt2 = $("#tahun_sppt2").val();
        var tp = $("#tp_kd").val();
        rptparams = {
            tahun:tahun,
                    tahun:tahun,
                    tahun_sppt1: tahun_sppt1,
                    tahun_sppt2: tahun_sppt2,
                    buku: buku,
                    kec_kd: kec_kd,
                    kel_kd: kel_kd,
                    tp_kd: tp
                }

        var data = decodeURIComponent($.param(rptparams));
        window.open("<?php echo active_module_url().'trans_rpt/xls_rekap_bulanan'?>/?"+data);
     });

    });

    function closeDialog() {
        $('#printdialog').modal('hide');
    }
</script>

<?= $this->load->view('layouts/footer.php'); ?>