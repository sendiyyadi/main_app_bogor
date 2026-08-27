<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Transaksi Pembayaran - Rincian Harian</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Transaksi</a>
                                </li>
                                <li class="breadcrumb-item active">Transaksi Pembayaran - Rincian Harian</li>
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
                                    <input class="form-control" style="width:120px;" id="tglawal" name="tglawal" width="5" type="text" value="<?php if (isset($tglawal)) echo $tglawal ?>" />
                                </div>
                                <div class="col-xs-1">
                                    <span>s.d</span>
                                </div>
                                <input class="form-control" style="width:120px;" id="tglakhir" name="tglakhir" type="text" value="<?php if (isset($tglakhir)) echo $tglakhir ?>" />
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
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
                                        <th>Tanggal</th>
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

<script>
    $(document).ready(function() {

        var oTable = $('#table1').dataTable({
            // "iDisplayLength": 100,
            // "sScrollY": "260px",
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
            "sDom": '<"toolbar">fTl<"clear">rtip',
            // "sDom": '<"H"lfr>t<"F"ip>T',
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

        var tb_array = [
            '<div class="btn-group pull-left">',
            '   <button class="btn btn-success" id="btnprint">Print Format</button>',
            '</div>',
        ];
        var tb = ''; //tb_array.join(' ');
        $("div.toolbar").html(tb);

        /*
        $( "#tglawal, #tglakhir" ).datepicker({
            dateFormat:'dd-mm-yy', 
            changeMonth:true, 
            changeYear:true
        });
        */

        var tglawal_dtp = $('#tglawal').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tglawal_dtp.hide();
        }).data('datepicker');

        var tglakhir_dtp = $('#tglakhir').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tglakhir_dtp.hide();
        }).data('datepicker');

        $("#btngo").click(function() {

            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var tp = $("#tp_kd").val();

            var params = "?tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&tahun_sppt1=" + tahun_sppt1 + "&tahun_sppt2=" + tahun_sppt2 + "&kec_kd=" + kec_kd;
            params = params + "&kel_kd=" + kel_kd + "&buku=" + buku + "&tp_kd=" + tp;
            window.location = "<?php echo active_module_url() . 'rincian_harian' ?>" + params;

        });

        $("#kec_kd, #kel_kd").change(function() {

            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();

            if ($(this).attr('name') == 'kec_kd') {
                $("#kel_kd").val('000');
            }

            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var tp = $("#tp_kd").val();

            var params = "?tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&tahun_sppt1=" + tahun_sppt1 + "&tahun_sppt2=" + tahun_sppt2 + "&kec_kd=" + kec_kd;
            params = params + "&kel_kd=" + kel_kd + "&buku=" + buku + "&tp_kd=" + tp;
            window.location = "<?php echo active_module_url() . 'rincian_harian' ?>" + params;

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

            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open("<?php echo active_module_url() . 'trans_rpt/cetak/pdf/1' ?>/" + kec_kd + "/" + kel_kd + "/" + tahun_sppt1 + "/" + tahun_sppt2 + "/" + buku + "/" + tglawal + "/" + tglakhir + "/" + tp, 'Laporan', winparams);

        });

        $('#btn_csv').click(function() {
            var rpt_type = <?php echo $trantypes; ?>;
            var url = '<?php echo active_module_url('trans_rpt/csv_rincian_harian'); ?>';

            $('#myform').attr('action', url);
            $('#myform').submit();
            return false;
        });

        $('#btn_xls').click(function(){

            var rptparams;
            var tglawal  = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var kec_kd   = $("#kec_kd").val();
            var kel_kd   = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var tp = $("#tp_kd").val();
            rptparams = {
                        tglawal: tglawal,
                        tglakhir: tglakhir,
                        tahun_sppt1: tahun_sppt1,
                        tahun_sppt2: tahun_sppt2,
                        buku: buku,
                        kec_kd: kec_kd,
                        kel_kd: kel_kd,
                        tp_kd: tp
                    }

            var data = decodeURIComponent($.param(rptparams));        
            window.open("<?php echo active_module_url().'trans_rpt/xls_rincian_harian'?>/?"+data);
        
         });

    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>