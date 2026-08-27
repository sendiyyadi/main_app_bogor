<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">POSPBB Users</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Users</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= active_module_url('pos_user'); ?>">POSPBB Users</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= ($dt['id'] == null) ? "Tambah POSPBB Users" : "Edit POSPBB Users"; ?>
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
                    <input type="hidden" name="id" value="<?= $dt['id'] ?>" />
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">User ID</label>
                                        <input class="form-control" type="text" name="userid" value="<?= $dt['userid'] ?>" <?= ($dt['id'] == null) ? "" : "readonly"; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input class="form-control" type="text" name="nama" value="<?= $dt['nama'] ?>" <?= ($dt['id'] == null) ? "" : "readonly"; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jabatan</label>
                                        <input class="form-control" type="text" name="jabatan" value="<?= $dt['jabatan'] ?>" <?= ($dt['id'] == null) ? "" : "readonly"; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">NIP</label>
                                        <input class="form-control" type="text" name="nip" value="<?= $dt['nip'] ?>" <?= ($dt['id'] == null) ? "" : "readonly"; ?> placeholder="Isi sesuai NIP sismiop">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tempat Pembayaran</label>
                                        <?= $select_grp_tp_bayar; ?>
                                    </div>
                                </div>
                                <?php //if ($dt['id'] == null) {
                                ?>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control" type="password" name="passwd" value="<?= $dt['passwd'] ?>" <?= ($dt['id'] == null) ? "" : "readonly"; ?>>
                                    </div>
                                </div>
                                <?php //} 
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <?php //if ($dt['id'] == null) { 
                                    ?>
                                    <div class="mb-3">
                                        <label for="disabled" class="form-label">Disabled</label>
                                        <div class="form-check font-size-17">
                                            <input type="checkbox" class="form-check-input" name="disabled" id="disabled" <?= $dt['disabled'] ?>>
                                        </div>
                                    </div>
                                    <?php //} 
                                    ?>
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
            window.location = "<?php echo active_module_url('pos_user'); ?>";
        });
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>