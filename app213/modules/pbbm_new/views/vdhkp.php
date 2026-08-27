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
                        <h4 class="mb-0">DHKP</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">
                                    <a href="javascript: void(0);">DHKP</a>
                                </li>
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
                                        <span class="input-group-text rounded-end-0">Thn SPPT</span>
                                    </div>
                                    <select id="tahun_sppt1" name="tahun_sppt1" style="width:90px;" class="input form-control select2">
                                        <?php
                                        $maxtahun = date('Y');
                                        $mintahun = mintahun_sppt2();
                                        $thncnt = $maxtahun - $mintahun;
                                        for ($i = $maxtahun; $i >= $maxtahun - $thncnt; $i--) {
                                            $selected = '';
                                            if ($i == $tahun_sppt1) $selected = " selected";
                                            echo "<option value=\"$i\" $selected>$i</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Buku</span>
                                    </div>
                                    <select id="buku" name="buku" style="width:125px;" class="input form-control select2">
                                        <?php for ($i = 1; $i <= 5; $i++) {
                                            for ($j = $i; $j <= 5; $j++) {
                                                $r = "";
                                                for ($k = $i; $k <= $j; $k++) $r .= "$k,";
                                                $r = substr($r, 0, strlen($r) - 1);
                                                if ($buku == "$i$j") $selected = "selected";
                                                else $selected = "";
                                                echo "<option value=\"$i$j\" $selected>Buku $r</option>\n";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">TP</span>
                                    </div>
                                    <select id="tp_kd" name="tp_kd" class="input form-control select2">
                                        <?php
                                        echo "<option value=\"\">Semua TP</option>\n";
                                        foreach ($tp as $row) {
                                            $selected = '';
                                            if ($row->KODE == $tp_kd) $selected = " selected";
                                            echo "<option value=\"" . $row->KODE . "\" $selected>" . $row->NM_TP . "</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kecamatan</span>
                                    </div>
                                    <select id="kec_kd" name="kec_kd" class="input form-control select2" style="width:250px;"><?php echo $kecamatans; ?></select>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kelurahan</span>
                                    </div>
                                    <select id="kel_kd" name="kel_kd" class="input form-control select2" style="width:250px;"><?php echo $kelurahans; ?></select>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Range Blok</span>
                                    </div>
                                    <input class="input form-control" type="text" style="width: 100px;" id="blok1" value="<?php echo $blok1; ?>">
                                </div>
                                <div class="col-xs-1">
                                    <span>s.d</span>
                                </div>
                                <input class="input form-control" type="text" style="width: 100px;" id="blok2" value="<?php echo $blok2; ?>">
                                <button id="btngo" name="btngo" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <input class="input form-control" type="text" style="width: 200px;" id="nop" value="<?php echo $nop; ?>">
                                </div>
                            </div>
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NOP</th>
                                        <th>Wajib Pajak</th>
                                        <th>Alamat</th>
                                        <th>Terhutang</th>
                                        <th>Tgl. Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">TOTAL</td>
                                        <td><span id="total">&nbsp;</span></td>
                                        <td></td>
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
            "bServerSide": true, //set to true
            "bProcessing": true,
            "sAjaxSource": "<?php echo $data_source ?>",
            // "sDom":'<"toolbar">fTl<"clear">rtip',
            "sDom": '<"toolbar">frtip',
            "aoColumns": [{
                    sWidth: '12%',
                    sClass: "center"
                },
                {
                    sWidth: '25%',
                    sClass: ""
                },
                null,
                {
                    sWidth: '10%',
                    sClass: "right"
                },
                {
                    sWidth: '8%',
                    sClass: "right"
                },
            ],
            "aoColumnDefs": [{
                    "bSearchable": false,
                    "aTargets": [0],
                    "bSortable": true,
                    "aTargets": [0]
                },
                {
                    "bSearchable": false,
                    "aTargets": [1],
                    "bSortable": true,
                    "aTargets": [1]
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
                    $('#pokok').html(json['POKOK']);
                    $('#denda').html(json['DENDA']);
                    $('#total').html(json['TOTAL']);

                    //Call the standard callback to redraw the table
                    fnCallback(json);
                });
            },
        });

        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        var tb_array = [];
        //
        tb_array.push('<div class="d-flex align-items-center gap-2">');
        tb_array.push('<button class="btn btn-success waves-effect waves-light" id="btn_cetak1" type="button">Cetak Muka</button>');
        tb_array.push('<button class="btn btn-success waves-effect waves-light" id="btn_cetak2" type="button">Cetak Isi</button>');
        tb_array.push('<button class="btn btn-success waves-effect waves-light" id="btn_cetak3" type="button">Cetak Rekap</button>');
        tb_array.push('</div>');

        var tb = tb_array.join(' ');

        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        $('#btn_cetak1').click(function() {
            var rpt = 'dhkp_front';
            var rptparams = {
                rpt: rpt,
                blok1: $("#blok1").val(),
                blok2: $("#blok2").val(),
                tglawal: $("#tglawal").val(),
                tglakhir: $("#tglakhir").val(),
                tahun_sppt1: $("#tahun_sppt1").val(),
                tahun_sppt2: $("#tahun_sppt2").val(),
                kec_kd: $("#kec_kd").val(),
                kec: $("#kec_kd option:selected").text(),
                kel_kd: $("#kel_kd").val(),
                kel: $("#kel_kd option:selected").text(),
                buku: $("#buku").val(),
                tp_kd: $("#tp_kd").val(),
                tp: $("#tp_kd option:selected").text(),
            }
            var rptdata = decodeURIComponent($.param(rptparams));
            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open('<?php echo active_module_url($this->uri->segment(2)); ?>cetak/pdf/?' + rptdata, 'Laporan', winparams);
        });

        $('#btn_cetak2').click(function() {
            var rpt = 'dhkp';
            var rptparams = {
                rpt: rpt,
                blok1: $("#blok1").val(),
                blok2: $("#blok2").val(),
                tglawal: $("#tglawal").val(),
                tglakhir: $("#tglakhir").val(),
                tahun_sppt1: $("#tahun_sppt1").val(),
                tahun_sppt2: $("#tahun_sppt2").val(),
                kec_kd: $("#kec_kd").val(),
                kec: $("#kec_kd option:selected").text(),
                kel_kd: $("#kel_kd").val(),
                kel: $("#kel_kd option:selected").text(),
                buku: $("#buku").val(),
                tp_kd: $("#tp_kd").val(),
                tp: $("#tp_kd option:selected").text(),
                nop: $("#nop").val(),
            }
            var rptdata = decodeURIComponent($.param(rptparams));
            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open('<?php echo active_module_url($this->uri->segment(2)); ?>cetak/pdf/?' + rptdata, 'Laporan', winparams);
        });

        $('#btn_cetak3').click(function() {
            var rpt = 'dhkp_end';
            var rptparams = {
                rpt: rpt,
                blok1: $("#blok1").val(),
                blok2: $("#blok2").val(),
                tglawal: $("#tglawal").val(),
                tglakhir: $("#tglakhir").val(),
                tahun_sppt1: $("#tahun_sppt1").val(),
                tahun_sppt2: $("#tahun_sppt2").val(),
                kec_kd: $("#kec_kd").val(),
                kec: $("#kec_kd option:selected").text(),
                kel_kd: $("#kel_kd").val(),
                kel: $("#kel_kd option:selected").text(),
                buku: $("#buku").val(),
                tp_kd: $("#tp_kd").val(),
                tp: $("#tp_kd option:selected").text(),
                nop: $("#nop").val(),
            }
            var rptdata = decodeURIComponent($.param(rptparams));
            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open('<?php echo active_module_url($this->uri->segment(2)); ?>cetak/pdf/?' + rptdata, 'Laporan', winparams);
        });

        $("#tglawal, #tglakhir").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $("#btngo").click(function() {
            var blok1 = $("#blok1").val();
            var blok2 = $("#blok2").val();
            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tp = $("#tp_kd").val();
            var nop = $("#nop").val();
            window.location = "<?php echo active_module_url(); ?>dhkp?tahun_sppt1=" + tahun_sppt1 + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd + "&blok1=" + blok1 + "&blok2=" + blok2 + "&buku=" + buku + "&tp_kd=" + tp + "&nop=" + nop;
        });

        $("#tes").click(function() {
            var buku = $("#buku").val();
            alert(buku);
        });

        $("#kec_kd, #kel_kd, #buku, #tahun_sppt1, #tahun_sppt2,#tp_kd").change(function() {
            var blok1 = $("#blok1").val();
            var blok2 = $("#blok2").val();
            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var buku = $("#buku").val();
            var tp = $("#tp_kd").val();
            var kec_kd = $("#kec_kd").val();

            var params = "?tahun_sppt1=" + tahun_sppt1 + "&kec_kd=" + kec_kd + "&blok1=" + blok1 + "&blok2=" + blok2 + "&buku=" + buku + "&tp_kd=" + tp;
            if ($(this).attr('name') == 'kel_kd')
                params = params + "&kel_kd=" + $("#kel_kd").val();

            window.location = "<?php echo active_module_url(); ?>dhkp" + params;
        });

    });

    function closeDialog() {
        $('#printdialog').modal('hide');
    }
</script>

<?= $this->load->view('layouts/footer.php'); ?>