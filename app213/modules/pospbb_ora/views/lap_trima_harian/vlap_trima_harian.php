<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Laporan Harian</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Laporan</a>
                                </li>
                                <li class="breadcrumb-item active">Laporan Harian</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (validation_errors()) {
                echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
                echo validation_errors('<small style="color:red;">', '</small>');
                echo '</blockquote>';
            } ?>

            <?php echo msg_block(); ?>

            <div class="row">
                <div class="col-12">
                    <?= form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input class="form-control" type="text" id="tgl" name="tgl" value="<?= date('d-m-Y'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Buku</label>
                                        <?= $select_buku; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Urut</label>
                                        <?= $select_urut; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kelurahan</label>
                                        <?= $select_kelurahan; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">User Rekam</label>
                                        <?= $select_tp_users; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 float-end">
                                <button type="button" id="btn_cetak" class="btn btn-info waves-effect waves-light">Cetak (Draft)</button>
                                <button type="button" id="btn_csv" class="btn btn-primary waves-effect waves-light">Download (CSV)</button>
                            </div>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<script>
    $(function() {
        /*
        $( "#tgl" ).datepicker({
            dateFormat:'dd-mm-yy',
            changeMonth:true,
            changeYear:true
        });
        */
        var tgl_dtp = $('#tgl').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tgl_dtp.hide();
        }).data('datepicker');

    });

    $(document).ready(function() {

        $('#btn_cetak').click(function() {
            $.ajax({
                url: "<?php echo $faction; ?>",
                type: "POST",
                data: $('#myform').serialize(),
                success: function(msg) {
                    if (msg != 'No Data') {
                        var rpt = window.open("", "Cetak");
                        if (!rpt)
                            alert('You have a popup blocker enabled. Please allow popups for this site.');
                        else
                            $(rpt.document.body).html(msg);
                    } else alert(msg);
                }
            });
        });

        $('#btn_cetak2').click(function() {
            var data = $('#myform').serialize();
            window.open("<?php echo active_module_url('laporan/cetak_pdf') ?>?" + data, "Cetak PDF");
        });

        $('#btn_csv').click(function() {
            var url = '<?php echo active_module_url($this->uri->segment(2)); ?>csv_download';

            $('#myform').attr('action', url);
            $('#myform').submit();
            return false;
        });
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>