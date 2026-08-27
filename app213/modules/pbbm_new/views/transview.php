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
                        <h4 class="mb-0"><?php echo $this->uri->segment(3) == 2 ? 'Transaksi Pembayaran - Rekap Harian' : 'Transaksi Pembayaran – Rinci Harian'; ?></h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Transaksi</a>
                                </li>
                                <li class="breadcrumb-item active"><?php echo $this->uri->segment(3) == 2 ? 'Transaksi Pembayaran - Rekap Harian' : 'Transaksi Pembayaran – Rinci Harian'; ?></li>
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
                                        <span class="input-group-text rounded-end-0">Tanggal</span>
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
                                        <span class="input-group-text rounded-end-0">Thn SPPT</span>
                                    </div>
                                    <select class="form-control select" id="tahun_sppt1" name="tahun_sppt1" style="width:80px;">
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
                                <div class="col-xs-1">
                                    <span>s.d</span>
                                </div>
                                <select class="form-control select2" id="tahun_sppt2" name="tahun_sppt2" style="width:80px;">
                                    <?php
                                    $maxtahun = date('Y');
                                    $mintahun = mintahun_sppt2();
                                    $thncnt = $maxtahun - $mintahun;
                                    for ($i = $maxtahun; $i >= $maxtahun - $thncnt; $i--) {
                                        $selected = '';
                                        if ($i == $tahun_sppt2) $selected = " selected";
                                        echo "<option value=\"$i\" $selected>$i</option>\n";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
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
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">TP</span>
                                    </div>
                                    <select class="form-control select" id="tp_kd" name="tp_kd">
                                        <?php
                                        echo "<option value=\"\">Semua TP</option>\n";
                                        foreach ($tp as $row) {
                                            $selected = '';
                                            if ($row->kode == $tp_kd) $selected = " selected";
                                            echo "<option value=\"" . $row->kode . "\" $selected>" . $row->nm_tp . "</option>\n";
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
                                <button id="btnprint" name="btnprint" class="btn btn-success waves-effect waves-light" type="button">Print Format</button>
                            </div>
                            </form>
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <?php if ($this->uri->segment(3) == '1') : ?>
                                            <th>NOP</th>
                                        <?php else: ?>
                                            <th>Tanggal</th>
                                        <?php endif; ?>
                                        <th>Uraian</th>
                                        <th>Thn.SPPT</th>
                                        <th>Pokok</th>
                                        <th>Denda</th>
                                        <th>Bayar</th>
                                        <?php if ($this->uri->segment(3) == '1') : ?>
                                            <th>Tanggal</th>
                                            <th>Tempat Pembayaran</th>
                                        <?php endif; ?>
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
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">TOTAL</td>
                                        <td><span id="pokok">&nbsp;</span></td>
                                        <td><span id="denda">&nbsp;</span></td>
                                        <td><span id="total">&nbsp;</span></td>
                                        <?php if ($this->uri->segment(3) == '1') : ?>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        <?php endif; ?>
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
                    sWidth: '14%',
                    sClass: "center"
                },
                null,
                {
                    sWidth: '6%',
                    sClass: "center"
                },
                {
                    sWidth: '10%',
                    sClass: "right"
                },
                {
                    sWidth: '8%',
                    sClass: "right"
                },
                {
                    sWidth: '10%',
                    sClass: "right"
                },
                <?php if ($this->uri->segment(3) == '1') : ?> {
                        sWidth: '6%',
                        sClass: "center"
                    },
                    null,
                <?php endif; ?>
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
                    $('#pokok').html(json['pokok']);
                    $('#denda').html(json['denda']);
                    $('#total').html(json['total']);

                    //Call the standard callback to redraw the table
                    fnCallback(json);
                });
            },
        });

        $("#tglawal, #tglakhir").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $("#btngo").click(function() {
            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var tp = $("#tp_kd").val();
            window.location = "<?php echo active_module_url() . 'transaksi/' . $trantypes ?>/?tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&tahun_sppt1=" + tahun_sppt1 + "&tahun_sppt2=" + tahun_sppt2 + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd + "&buku=" + buku + "&tp_kd=" + tp;
        });

        $("#kec_kd, #kel_kd, #buku, #tahun_sppt1, #tahun_sppt2,#tp_kd").change(function() {
            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var tp = $("#tp_kd").val();

            var params = "?tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&tahun_sppt1=" + tahun_sppt1 + "&tahun_sppt2=" + tahun_sppt2 + "&kec_kd=" + kec_kd + "&buku=" + buku + "&tp_kd=" + tp;
            if ($(this).attr('id') == 'kel_kd')
                var params = params + "&kel_kd=" + $(this).val();

            window.location = "<?php echo active_module_url() . 'transaksi/' . $trantypes ?>" + params;
        });

        $('#btnprint').click(function() {
            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tp = $("#tp_kd").val();
            // window.open("<?php echo active_module_url() . "trans_rpt/trans$trantypes" ?>?tglawal="+ tglawal + "&tglakhir=" + tglakhir+"&tahun_sppt1="+ tahun_sppt1 +"&tahun_sppt2="+ tahun_sppt2+ "&kec_kd=" + kec_kd +"&kel_kd=" + kel_kd + "&buku=" + buku,target="laporan");
            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open("<?php echo active_module_url() . 'trans_rpt/cetak/pdf/' . $trantypes ?>/" + kec_kd + "/" + kel_kd + "/" + tahun_sppt1 + "/" + tahun_sppt2 + "/" + buku + "/" + tglawal + "/" + tglakhir + "/" + tp, 'Laporan', winparams);
        });

    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>