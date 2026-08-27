<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">User</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">User & Privileges</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= active_module_url('users'); ?>">User</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= ($dt['id'] == null) ? "Tambah User" : "Edit User"; ?>
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
                                <?= ($dt['id'] == null) ? "Tambah User" : "Edit User"; ?>
                            </h4>

                            <?= form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="id" value="<?= $dt['id'] ?>" />

                            <div class="mb-3">
                                <label for="userid" class="form-label">User ID</label>
                                <input class="form-control <?= form_error('userid') ? 'is-invalid' : ''; ?>" type="text" name="userid" id="userid" placeholder="Masukan User ID" value="<?= $dt['userid'] ?>" <?= $model != 'add' ? 'readonly' : ''; ?>>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" type="text" name="nama" id="nama" placeholder="Masukan nama" value="<?= $dt['nama'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="handphone" class="form-label">Handphone</label>
                                <input class="form-control <?= form_error('handphone') ? 'is-invalid' : ''; ?>" type="text" name="handphone" id="handphone" placeholder="Masukan nomor handphone" value="<?= $dt['handphone'] ?>">
                            </div>
                            <input type="text" id="hiddenID" style="display: none;" />
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="passwd" class="form-label">Password</label>
                                        <input class="form-control <?= form_error('passwd') ? 'is-invalid' : ''; ?>" type="password" name="passwd" id="passwd" placeholder="<?php echo $model == 'add' ? 'Masukan password' : 'Kosongkan jika tdk berubah'; ?>" value="<?= $dt['passwd'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="passconf" class="form-label">Password Confirm</label>
                                        <input class="form-control <?= form_error('passconf') ? 'is-invalid' : ''; ?>" type="password" name="passconf" id="passconf" placeholder="<?php echo $model == 'add' ? 'Masukan password' : 'Kosongkan jika tdk berubah'; ?>" value="<?= $dt['passconf'] ?>">
                                    </div>
                                </div>
                                <script>
                                    /** blok drop down password  ini ok  */
                                    window.jQuery('form input[type="password"]').on('focus input click', function(e) {
                                        var self = $(this);
                                        self.prop('readonly', true);
                                        setTimeout(function() {
                                            self.prop('readonly', false);
                                        }, 50);
                                    });
                                </script>
                            </div>
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <?= $select_nip ?>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input class="form-control <?= form_error('jabatan') ? 'is-invalid' : ''; ?>" type="text" name="jabatan" id="jabatan" placeholder="Masukan jabatan" value="<?= $dt['jabatan'] ?>">
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
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?php if (validation_errors()) { ?>
    <script>
        let errors = <?= json_encode($this->form_validation->error_array()); ?>;
        for (error in errors) {
            let msg_err = errors[error];
            toastr.options = {
                "preventDuplicates": true
            }
            toastr.warning(msg_err);
            break;
        }
    </script>
<?php } ?>

<script>
    function updatePW() {
        $("#pwchar").html($('#passport').val().replace(/./g, "*"));
    }

    function xupdatePW() {
        $("#pwchar").html($('#passport').val().replace(/./g, "*"));
    }

    $(document).ready(function() {
        $('#btn_cancel').click(function() {
            window.location = "<?php echo active_module_url('users'); ?>";
        });
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>