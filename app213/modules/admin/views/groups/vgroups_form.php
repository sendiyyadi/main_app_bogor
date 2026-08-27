<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Groups</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">User & Privileges</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= active_module_url('groups'); ?>">Groups</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= ($dt['id'] == null) ? "Tambah Group" : "Edit Group"; ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block(); ?>
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
                                <?= ($dt['id'] == null) ? "Tambah Groups" : "Edit Groups"; ?>
                            </h4>
                            <?php echo form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="id" id="id" value="<?= $dt['id'] ?>" />
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode</label>
                                <input class="form-control <?= form_error('kode') ? 'is-invalid' : ''; ?>" type="text" name="kode" id="kode" placeholder="Masukan Kode Group" value="<?= $dt['kode'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" type="text" name="nama" id="nama" placeholder="Masukan Nama Group" value="<?= $dt['nama'] ?>">
                            </div>
                            <div class="d-flex flex-wrap gap-2 float-end">
                                <button type="button" id="btn_cancel" class="btn btn-secondary waves-effect waves-light"><i class="uil uil-arrow-left me-2"></i> Kembali</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan <i class="uil uil-save ms-2"></i></button>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>

<?= $this->load->view('layouts/scripts.php'); ?>

<script>
    $(document).ready(function() {
        $('#btn_cancel').click(function() {
            window.location = '<?php echo active_module_url(); ?>groups';
        });
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>