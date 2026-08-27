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
                        <h4 class="mb-0">Piutang</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Piutang</a>
                                </li>
                                <li class="breadcrumb-item active">Piutang</li>
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
                                        <span class="input-group-text rounded-end-0">Tahun SPPT</span>
                                    </div>
                                    <select class="form-control select" id="tahun" name="tahun" style="width:80px;">
                                        <?php
                                        $maxtahun = date('Y');
                                        $mintahun = mintahun_sppt2();
                                        $thncnt = $maxtahun - $mintahun;
                                        for ($i = $maxtahun; $i >= $maxtahun - $thncnt; $i--) {
                                            $selected = '';
                                            if ($i == $tahun) $selected = " selected";
                                            echo "<option value=\"$i\" $selected>$i</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-xs-1">
                                    <span>s.d</span>
                                </div>
                                <select class="form-control select" id="tahun2" name="tahunsd" style="width:80px;">
                                    <?php
                                    $maxtahun = date('Y');
                                    $mintahun = mintahun_sppt2();
                                    $thncnt = $maxtahun - $mintahun;
                                    for ($i = $maxtahun; $i >= $maxtahun - $thncnt; $i--) {
                                        $selected = '';
                                        if ($i == $tahun2) $selected = " selected";
                                        echo "<option value=\"$i\" $selected>$i</option>\n";
                                    }
                                    ?>
                                </select>
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
                                <button id="btnprint" name="btnprint" class="btn btn-success waves-effect waves-light" type="button">Print Format</button>
                            </div>
                            </form>
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Uraian</th>
                                        <th>SPPT</th>
                                        <th>Pokok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">TOTAL</td>
                                        <td><span id="sppt">&nbsp;</span></td>
                                        <td><span id="pokok">&nbsp;</span></td>
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
                    sWidth: '15%'
                },
                null,
                {
                    sWidth: '10%',
                    sClass: "right"
                },
                {
                    sWidth: '10%',
                    sClass: "right"
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
            "fnServerData": function(sSource, aoData, fnCallback) {
                $.getJSON(sSource, aoData, function(json) {
                    //Here you can do whatever you want with the additional data
                    // console.dir(json);
                    $('#sppt').html(json['sppt']);
                    $('#pokok').html(json['pokok']);

                    //Call the standard callback to redraw the table
                    fnCallback(json);
                });
            },
        });

        $("#kel_kd, #kec_kd, #tahun, #tahun2, #buku").change(function() {
            var tahun = $("#tahun").val();
            var tahun2 = $("#tahun2").val();
            if (tahun2 < tahun) {
                $("#tahun2").value = tahun;
                tahun2 = tahun;
            }
            var buku = $("#buku").val();
            var kec_kd = $("#kec_kd").val();

            var params = "?tahun=" + tahun + "&tahun2=" + tahun2 + "&buku=" + buku + "&kec_kd=" + kec_kd;
            if ($(this).attr('id') == 'kel_kd')
                var params = params + "&kel_kd=" + $(this).val();

            window.location = "<?php echo active_module_url() ?>piutang" + params;
        });

        $('#btnprint').click(function() {
            var tahun = $("#tahun").val();
            var tahun2 = $("#tahun2").val();
            if (tahun2 < tahun) {
                $("#tahun2").value = tahun;
                tahun2 = tahun;
            }
            var buku = $("#buku").val();

            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            // window.open("<?php echo active_module_url() . "real_rpt/utang" ?>?tahun="+tahun+"&tahun2="+tahun2+"&kec_kd=" + kec_kd +"&kel_kd=" + kel_kd+"&buku=" + buku ,target="laporan");

            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open("<?php echo active_module_url() . 'real_rpt/cetak/pdf/4' ?>/" + kec_kd + "/" + kel_kd + "/" + tahun + "/" + tahun2 + "/" + buku, 'Laporan', winparams);
        });

    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>