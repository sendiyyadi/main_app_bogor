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
                        <h4 class="mb-0">Rekam Bayar : <?= $nop ?> - <?= $tahun ?></h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Rekam Bayar SPPT</li>
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

            <?php
                $nop = $this->uri->segment(4);
                $tahun = $this->uri->segment(5);
                $nama = $this->uri->segment(6);
                $nama_input = str_replace('-', '/', $nama);
                $alamat = $this->uri->segment(7);
                $alamat_input = str_replace('-', '/', $alamat);
                $rt = $this->uri->segment(8);
                $rw = $this->uri->segment(9);
                $kelurahan = $this->uri->segment(10);
                $kota = $this->uri->segment(11);
                $npwp = $this->uri->segment(12);
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form method="post" action="<?php echo active_module_url('rekam_bayar_sppt/detail/'."$nop"."/"."$tahun"."/"."$nama"."/"."$alamat"."/"."$rt"."/"."$rw"."/"."$kelurahan"."/"."$kota"."/"."$npwp"); ?>" id="myform" >
                             
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
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama_input ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="alamat">Alamat Wajib Pajak</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $alamat_input ?>" readonly>
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
                                            <input type="text" class="form-control" id="kode_kanwil" name="kode_kanwil" maxlength="2" value="22" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="kode_kantor">Kode Kantor</label>
                                            <input type="text" class="form-control" id="kode_kantor" name="kode_kantor" maxlength="2" value="13" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="kode_tp">Kode TP</label>
                                            <input type="text" class="form-control" id="kode_tp" name="kode_tp" maxlength="2" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="denda_sppt">Denda SPPT</label>
                                            <input type="text" class="form-control" id="denda_sppt" name="denda_sppt">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="sppt_bayar">Jumlah SPPT yang dibayar</label>
                                            <input type="text" class="form-control" id="sppt_bayar" name="sppt_bayar" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="pembayaran">Pembayaran SPPT ke</label>
                                            <input type="text" class="form-control" id="pembayaran" name="pembayaran" maxlength="2" value="<?= $pembayaran ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="tanggal_bayar_sppt">Tanggal Bayar SPPT</label>
                                            <input type="date" class="form-control" id="tanggal_bayar_sppt" name="tanggal_bayar_sppt" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="tanggal_rekam_bayar">Tanggal Rekam Bayar</label>
                                            <input type="date" class="form-control" id="tanggal_rekam_bayar" name="tanggal_rekam_bayar" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="nip_bayar_sppt">NIP Bayar SPPT</label>
                                            <input type="text" class="form-control" id="nip_bayar_sppt" name="nip_bayar_sppt" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <a href="<?= base_url('/tool_pbb/rekam_bayar_sppt') ?>" id="btn_batal" class="btn btn-danger">Batal</a>
                                        <button type="submit" class="btn btn-primary" id="saveBtn">Simpan</button>
                                        <!-- <button class="btn btn-warning" id="tes">tes</button> -->
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <p style="color:red;">jika ada notif berarti berhasil, jika tidak berarti gagal</p>
                                </div>
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
