<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Tempat Pembayaran</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Users</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= active_module_url('tp_bayar'); ?>">Tempat Pembayaran</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= ($dt['id'] == null) ? "Tambah Tempat Pembayaran" : "Edit Tempat Pembayaran"; ?>
                                </li>
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
                    <input type="hidden" name="id" value="<?php echo $dt['id'] ?>" />
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <?php if (DEF_POS_TYPE == 1) { ?>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Kode Kanwil</label>
                                            <input class="form-control" type="text" name="kd_kanwil" value="<?= $dt['kd_kanwil'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Kode Kantor</label>
                                            <input class="form-control" type="text" name="kd_kantor" value="<?= $dt['kd_kantor'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Kode TP</label>
                                            <input class="form-control" type="text" name="kd_tp" value="<?= $dt['kd_tp'] ?>">
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Kode Bank Tunggal</label>
                                            <input class="form-control" type="text" name="kd_bank_tunggal" value="<?= $dt['kd_bank_tunggal'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Kode Bank Persepsi</label>
                                            <input class="form-control" type="text" name="kd_bank_persepsi" value="<?= $dt['kd_bank_persepsi'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Kode Kanwil</label>
                                            <input class="form-control" type="text" name="kd_kanwil" value="<?= $dt['kd_kanwil'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Kode Kantor</label>
                                            <input class="form-control" type="text" name="kd_kantor" value="<?= $dt['kd_kantor'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Kode TP</label>
                                            <input class="form-control" type="text" name="kd_tp" value="<?= $dt['kd_tp'] ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" name="nm_tp" value="<?= $dt['nm_tp'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <input class="form-control" type="text" name="alamat_tp" value="<?= $dt['alamat_tp'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Rekening</label>
                                        <input class="form-control" type="text" name="no_rek_tp" value="<?= $dt['no_rek_tp'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 float-end">
                                <button type="button" id="btn_cancel" class="btn btn-secondary waves-effect waves-light"><i class="uil uil-arrow-left me-2"></i> Kembali</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan <i class="uil uil-save ms-2"></i></button>
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
    $(document).ready(function() {
        $('#btn_cancel').click(function() {
            window.location = "<?php echo active_module_url('tp_bayar'); ?>";
        });
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>