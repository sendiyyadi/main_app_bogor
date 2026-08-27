<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>

.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Detail: <?= $nop ?> - <?= $tahun ?></h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Detail SPPT</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                if (validation_errors()) {
                    echo '<blockquote><strong>Harap sesuaikan data berikut :</strong>';
                    echo validation_errors('<small>', '</small>');
                    echo '</blockquote>';
                }
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <?php
                                $nop = $this->uri->segment(4);
                                $tahun = $this->uri->segment(5);
                                $nama = $this->uri->segment(6);
                                $nama_new = str_replace('^', '/', $nama);
                                $alamat = $this->uri->segment(7);
                                $alamat_new = str_replace('^', '/', $alamat);
                                $rt = $this->uri->segment(8);
                                $rw = $this->uri->segment(9);
                                $kelurahan = $this->uri->segment(10);
                                $kota = $this->uri->segment(11);
                                $npwp = $this->uri->segment(12);
                                $pembayaran = $this->uri->segment(13);
                            ?>

                             <form method="post" action="<?php echo active_module_url('edit_bayar_sppt/detail/'."$nop"."/"."$tahun"."/"."$nama"."/"."$alamat"."/"."$rt"."/"."$rw"."/"."$kelurahan"."/"."$kota"."/"."$pembayaran"); ?>" id="myform" >
                             
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="nop">Nomor Objek Pajak</label>
                                            <input type="text" class="form-control" id="nop" name="nop" value="<?= $nop ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="tahun">Tahun</label>
                                            <input type="text" class="form-control" id="tahun" name="tahun" value="<?= $tahun ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="nama">Nama Wajib Pajak</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama_new ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="alamat">Alamat Wajib Pajak</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $alamat_new ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="rt">RT</label>
                                            <input type="text" class="form-control" id="rt" name="rt" value="<?= $rt ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="rw">RW</label>
                                            <input type="text" class="form-control" id="rw" name="rw" value="<?= $rw ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="kelurahan">Kelurahan</label>
                                            <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="<?= $kelurahan ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="kota">Kota</label>
                                            <input type="text" class="form-control" id="kota" name="kota" value="<?= $kota ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="npwp">NPWP</label>
                                            <input type="text" class="form-control" id="npwp" name="npwp" value="<?= $npwp ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="kode_kanwil">Kode Kanwil</label>
                                            <input type="text" class="form-control" id="kode_kanwil" name="kode_kanwil" maxlength="2" value="<?= $kd_kanwil ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="kode_kantor">Kode Kantor</label>
                                            <input type="text" class="form-control" id="kode_kantor" name="kode_kantor" value="<?= $kd_kantor ?>" maxlength="2" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="kode_tp">Kode TP</label>
                                            <input type="text" class="form-control" id="kode_tp" name="kode_tp" maxlength="2" value="<?= $kode_tp ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="denda_sppt">Denda SPPT</label>
                                            <input type="text" class="form-control" id="denda_sppt" name="denda_sppt" value="<?= $denda_sppt ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="sppt_bayar">SPPT yang dibayar</label>
                                            <input type="text" class="form-control" id="sppt_bayar" name="sppt_bayar" value="<?= $sppt_bayar ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="pembayaran">Pembayaran SPPT ke</label>
                                            <input type="text" class="form-control" id="pembayaran" name="pembayaran" maxlength="2" value="<?= $pembayaran ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="tanggal_bayar_sppt">Tanggal Bayar SPPT (m-d-Y)</label>
                                            <input type="date" class="form-control" id="tanggal_bayar_sppt" name="tanggal_bayar_sppt" value="<?= $tanggal_bayar_sppt ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="tanggal_rekam_bayar">Tanggal Rekam Bayar (m-d-Y)</label>
                                            <input type="date" class="form-control" id="tanggal_rekam_bayar" name="tanggal_rekam_bayar" value="<?= $tanggal_rekam_bayar ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="nip_bayar_sppt">NIP Bayar SPPT</label>
                                            <input type="text" class="form-control" id="nip_bayar_sppt" name="nip_bayar_sppt" value="<?= $nip_bayar_sppt ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <a href="<?= base_url('/tool_pbb/edit_bayar_sppt') ?>" id="btn_batal" class="btn btn-danger">Batal</a>
                                        <button type="submit" class="btn btn-primary" id="saveBtn">Simpan</button>
                                        <!-- <button type="button" class="btn btn-warning" id="test">test</button> -->
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <p>jika ada notif berarti berhasil, jika tidak berarti gagal</p>
                                </div> -->
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>


            <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>

<?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>


<script>
    $(document).on('click', '#test', function() {
        var denda_sppt = $('#denda_sppt').val();
        var sppt_bayar = $('#sppt_bayar').val();

        alert('denda_sppt: '+denda_sppt+', sppt_bayar: '+sppt_bayar);
    });

</script>
