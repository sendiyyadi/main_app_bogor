<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Aplikasi</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Pengaturan</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= active_module_url('apps'); ?>">Aplikasi</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= ($dt['id'] == null) ? "Tambah Aplikasi" : "Edit Aplikasi"; ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (validation_errors()) {
                echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
                echo validation_errors('<small>', '</small>');
                echo '</blockquote>';
            } ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">
                                <?= ($dt['id'] == null) ? "Tambah Aplikasi" : "Edit Aplikasi"; ?>
                            </h4>
                            <?php echo form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="id" value="<?= $dt['id'] ?>" />
                            <div class="mb-3">
                                <label for="nama" class="form-label">Aplikasi</label>
                                <input class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" type="text" name="nama" id="nama" placeholder="Masukan nama aplikasi" value="<?= $dt['nama'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="app_path" class="form-label">Direktori</label>
                                <input class="form-control <?= form_error('app_path') ? 'is-invalid' : ''; ?>" type="text" name="app_path" id="app_path" placeholder="Masukan direktori" value="<?= $dt['app_path'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="disabled" class="form-label">Disabled</label>
                                <div class="form-check font-size-17">
                                    <input type="checkbox" name="disabled" class="form-check-input" id="disabled" <?= $dt['disabled'] ?>>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 float-end">
                                <button type="button" id="btn_cancel" class="btn btn-secondary waves-effect waves-light"><i class="uil uil-arrow-left me-2"></i> Kembali</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan <i class="uil uil-save ms-2"></i></button>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
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
            window.location = '<?php echo active_module_url('apps'); ?>';
        });
    });

    $("input").change(function() {
        $(this).removeClass('is-invalid');
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>