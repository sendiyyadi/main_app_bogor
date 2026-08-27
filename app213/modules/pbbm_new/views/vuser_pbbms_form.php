<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">User Area</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Settings</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= active_module_url('user_pbbms'); ?>">User Area</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <?= ($dt['id'] == null) ? "Tambah User Area" : "Edit User Area"; ?>
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
                                <?= ($dt['id'] == null) ? "Tambah User Area" : "Edit User Area"; ?>
                            </h4>
                            <?php echo form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="id" value="<?= $dt['id'] ?>" />
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User PBBM</label>
                                <div>
                                    <select id="user_id" name="user_id" class="form-control select2" <?php echo $this->uri->segment(3) == 'edit' ? 'readonly' : ''; ?>>
                                        <?php
                                        foreach ($users as $r) {
                                            $selected = '';
                                            if ($r->ID == $dt['user_id']) $selected = " selected";
                                            echo "<option value=\"" . $r->ID . "\" $selected>" . $r->NAMA . "</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="kd_kecamatan" class="form-label">Kecamatan</label>
                                <div class="controls">
                                    <select id="kd_kecamatan" name="kd_kecamatan" class="form-control select2">
                                        <?php
                                        echo "<option value=\"000\">SEMUA KECAMATAN</option>\n";
                                        foreach ($kecamatan as $kec) {
                                            $selected = '';
                                            if ($kec->KD_KECAMATAN == $dt['kd_kecamatan']) $selected = " selected";
                                            echo "<option value=\"" . $kec->KD_KECAMATAN . "\" $selected>" . $kec->NM_KECAMATAN . "</option>\n";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="kd_kelurahan" class="form-label">Kelurahan</label>
                                <div>
                                    <select id="kd_kelurahan" name="kd_kelurahan" class="form-control select2">
                                        <?php
                                        echo "<option value=\"000\">SEMUA KELURAHAN</option>\n";
                                        foreach ($kelurahan as $kel) {
                                            $selected = '';
                                            if ($kel->KD_KELURAHAN == $dt['kd_kelurahan']) $selected = " selected";
                                            echo "<option value=\"" . $kel->KD_KELURAHAN . "\" $selected>" . $kel->NM_KELURAHAN . "</option>\n";
                                        }
                                        ?>
                                    </select>
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
    $(document).ready(function() {
        $('#btn_cancel').click(function() {
            window.location = "<?php echo $this->uri->segment(2) == 'users2' ? active_module_url() : active_module_url('user_pbbms'); ?>";
        });

        $("#kd_kecamatan").change(function() {
            var kec_kd = $("#kd_kecamatan").val();
            $.ajax({
                url: "<?php echo active_module_url() . 'user_pbbms/get_lurah/' ?>" + kec_kd,
                dataType: "json",
                success: function(data) {
                    var kelurahans = data.kelurahans,
                        sKelurahan = '<option value="000">SEMUA KELURAHAN</option>';;
                    for (var idx = 0; idx < kelurahans.length; ++idx) {
                        sKelurahan += '<option value="' + kelurahans[idx].kd_kelurahan + '">' + kelurahans[idx].nm_kelurahan + '</option>';

                    }
                    $('#kd_kelurahan').empty().append(sKelurahan);
                }
            });
        });

        $("#kd_kecamatan").trigger('change');
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>