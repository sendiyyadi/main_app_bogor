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
                        <h4 class="mb-0">Ketetapan dan Realisasi PBB-P2</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Realisasi</a>
                                </li>
                                <li class="breadcrumb-item active">Semua</li>
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
                                        <span class="input-group-text rounded-end-0">Tgl Realisasi</span>
                                    </div>
                                    <input class="form-control input" style="width:120px;" id="tglawal" name="tglawal" width="5" type="text" value="<?php if (isset($tglawal)) echo $tglawal ?>" />
                                </div>
                                <div class="col-xs-1">
                                    <span>s.d</span>
                                </div>
                                <input class="form-control input" style="width:120px;" id="tglakhir" name="tglakhir" type="text" value="<?php if (isset($tglakhir)) echo $tglakhir ?>" />
                                <button id="btngo" name="btngo" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun SPPT</span>
                                    </div>
                                    <select class="form-control select" id="tahun" name="tahun" style="width:100px;">
                                        <?php
                                        echo "<option value=\"0000\">Semua</option>\n";

                                        $maxtahun = date('Y');
                                        for ($i = $maxtahun; $i > $maxtahun - 10; $i--) {
                                            $selected = '';
                                            if ($i == $tahun) $selected = " selected";
                                            echo "<option value=\"$i\" $selected>$i</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Buku</span>
                                    </div>
                                    <select class="form-control select" id="buku" name="buku" style="width:125px;">
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
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th rowspan="3" class="ui-state-default">Kode</th>
                                        <th rowspan="3" class="ui-state-default">Uraian</th>
                                        <th colspan="2" class="ui-state-default">Pokok</th>
                                        <th colspan="7" class="ui-state-default">Realisasi</th>
                                        <th colspan="3" class="ui-state-default">Sisa</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="ui-state-default">SPPT</th>
                                        <th rowspan="2" class="ui-state-default">Jumlah</th>
                                        <th colspan="2" class="ui-state-default">Lalu</th>
                                        <th colspan="2" class="ui-state-default">Kini</th>
                                        <th colspan="2" class="ui-state-default">Jumlah</th>
                                        <th rowspan="2" class="ui-state-default">%</th>
                                        <th rowspan="2" class="ui-state-default">SPPT</th>
                                        <th rowspan="2" class="ui-state-default">Jumlah</th>
                                        <th rowspan="2" class="ui-state-default">%</th>
                                    </tr>
                                    <tr>
                                        <th class="ui-state-default">SPPT</th>
                                        <th class="ui-state-default">Jumlah</th>
                                        <th class="ui-state-default">SPPT</th>
                                        <th class="ui-state-default">Jumlah</th>
                                        <th class="ui-state-default">SPPT</th>
                                        <th class="ui-state-default">Jumlah</th>
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
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">TOTAL</td>
                                        <td><span id="nsppt1"></span></td>
                                        <td><span id="amount1"></span></td>
                                        <td><span id="nsppt2"></span></td>
                                        <td><span id="amount2"></span></td>
                                        <td><span id="nsppt3"></span></td>
                                        <td><span id="amount3"></span></td>
                                        <td><span id="nsppt4"></span></td>
                                        <td><span id="amount4"></span></td>
                                        <td><span id="persen1"></span></td>
                                        <td><span id="nsppt5"></span></td>
                                        <td><span id="amount5"></span></td>
                                        <td><span id="persen2"></span></td>
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

<script>
    $(document).ready(function() {

        var oTable = $('#table1').dataTable({
            // "iDisplayLength": 100,
            // "sScrollY": "260px",
            // "bJQueryUI": true,
            // "bAutoWidth": true,
            "bScrollCollapse": false,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": true,
            "sPaginationType": "full_numbers",
            "bSort": false,
            "bInfo": true,
            "bServerSide": false,
            "bProcessing": true,
            "sAjaxSource": "<?php echo $data_source ?>",
            "sDom": '<"toolbar">fTl<"clear">rtip',
            "aoColumns": [{
                    "sWidth": '110pt'
                },
                null,
                {
                    "sWidth": '20pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '25pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '20pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '25pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '20pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '25pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '20pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '25pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '10pt',
                    "sClass": "center"
                },
                {
                    "sWidth": '20pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '25pt',
                    "sClass": "right"
                },
                {
                    "sWidth": '10pt',
                    "sClass": "center"
                },
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
            "fnInitComplete": function(oSettings, json) {
                $('#nsppt1').html(json['nsppt1']);
                $('#amount1').html(json['amount1']);
                $('#nsppt2').html(json['nsppt2']);
                $('#amount2').html(json['amount2']);
                $('#nsppt3').html(json['nsppt3']);
                $('#amount3').html(json['amount3']);
                $('#nsppt4').html(json['nsppt4']);
                $('#amount4').html(json['amount4']);
                $('#persen1').html(json['persen1']);
                $('#nsppt5').html(json['nsppt5']);
                $('#amount5').html(json['amount5']);
                $('#persen2').html(json['persen2']);
                oTable.fnAdjustColumnSizing();
            },
        });
        $("#tglawal, #tglakhir").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $("#btngo").click(function() {
            var tahun = $("#tahun").val();
            var buku = $("#buku").val();
            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            window.location = "<?php echo active_module_url() . 'realisasi' ?>/?tahun=" + tahun + "&buku=" + buku + "&tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;
        });

        $("#kec_kd, #kel_kd, #tahun, #buku").change(function() {
            var tahun = $("#tahun").val();
            var buku = $("#buku").val();
            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var kec_kd = $("#kec_kd").val();

            var params = "?tahun=" + tahun + "&buku=" + buku + "&tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&kec_kd=" + kec_kd;
            if ($(this).attr('id') == 'kel_kd')
                var params = params + "&kel_kd=" + $(this).val();

            window.location = "<?php echo active_module_url() . 'realisasi' ?>" + params;
        });

        $('#btnprint').click(function() {
            var tahun = $("#tahun").val();
            var buku = $("#buku").val();
            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            // window.open("<?php echo active_module_url() . "real_rpt/nb" ?>?tahun="+tahun+"&tglawal="+ tglawal + "&tglakhir=" + tglakhir+ "&kec_kd=" + kec_kd +"&kel_kd=" + kel_kd + "&buku=" + buku,target="laporan");

            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open("<?php echo active_module_url() . 'real_rpt/cetak/pdf/1' ?>/" + kec_kd + "/" + kel_kd + "/" + tahun + "/" + buku + "/" + tglawal + "/" + tglakhir, 'Laporan', winparams);
        });

    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>