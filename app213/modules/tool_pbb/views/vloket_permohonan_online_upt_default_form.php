<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>

.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
label {
  margin-top: 5px;
  margin-bottom: 0px;
}
input class="form-control" {
  width: 100%;
  border-radius: 6px !important;
}
.well {
  margin-top:20px;
  padding: 10px;
  min-height: 10px;
  background-color: #5D6385;
  color: #FFF;
  width: 100%;
  border-radius: 10px !important;
}

@media (min-width: 768px) and (max-width: 1366px) {
  .col-md-8 {
    opacity: 0.875;
    margin-left: 5px;
  }
}

.row {
  margin-top: 3px;
  margin-bottom: 3px;
}

.teks_red{
  color: red;
}
.geser_kanan{
  margin-left: 10px;
}


/* SPINNER */
#overlay{	
  position: fixed;
  top: 0;
  z-index: 100;
  width: 100%;
  height:100%;
  display: none;
  background: rgba(0,0,0,0.6);
}
.cv-spinner {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;  
}
.spinner {
  width: 40px;
  height: 40px;
  border: 4px #ddd solid;
  border-top: 4px #2e93e6 solid;
  border-radius: 50%;
  animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
  100% { 
    transform: rotate(360deg); 
  }
}
.is-hide{
  display:none;
}

.form-control {
  text-transform:uppercase;
}
/* END SPINNER */

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">PERMOHONAN ONLINE UPT - <?= $nm_jns_pelayanan; ?></h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Permohonan Online UPT - <?= $nm_jns_pelayanan; ?></li>
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

            <?php echo msg_block();?>
        
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <?php echo form_open($faction, array('id'=>'myform', 'enctype'=>'multipart/form-data'));?>

                              <!-- SUBJEK / WAJIB PAJAK -->
                              <!-- SUBJEK / WAJIB PAJAK -->
                              <div class="panel">

                                  <div class="row" style="margin-right:0px; margin-left:0px; background-image:url(<?php echo site_url('assets/img/stadion_pakansari.jpg'); ?>);
                                    background-repeat:no-repeat; background-size:cover; ">
                                    <!-- <div class="col-md-2" style=""></div> -->
                                    <div class="col-md-12 ">

                                        <!-- DATA REGISTRASI -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well">
                                            <center><font style="font-size:13pt"><strong>DATA REGISTRASI</strong></font></center>
                                          </div>
                                        </div>

                                        <!-- <form id="form_reg_esppt" class="form_reg_esppt" enctype="multipart/form-data" method="post"> -->
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="nop_re">NOP PBB</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="nop_re" name="nop_re" autocomplete="off" value="<?php echo $dt['nop_re']?>" >
                                                <input class="form-control" type="hidden" id="id_reg_esppt" name="id_reg_esppt" autocomplete="off" value="<?php echo $dt['id_reg_esppt']?>" >
                                                <input class="form-control" type="hidden" id="id_ppo" name="id_ppo" autocomplete="off" value="<?php echo $dt['id_ppo']?>" >
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6 hidden">
                                            <div class="row">
                                              <button class="btn btn-danger" id="btn_cari_nop" type="button">Cari NOP</button>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="nama_wp_re">NAMA WAJIB PAJAK</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="nama_wp_re" name="nama_wp_re" autocomplete="off" value="<?php echo $dt['nama_wp_re']?>" readonly >
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="alamat_op_re">ALAMAT OBJEK PAJAK</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="alamat_op_re" name="alamat_op_re" autocomplete="off" value="<?php echo $dt['alamat_op_re']?>" readonly >
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="nik_re">NIK</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="nik_re" name="nik_re" autocomplete="off" value="<?php echo $dt['nik_re']?>" readonly >
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="no_telp_re">NO TELP / WA</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="no_telp_re" name="no_telp_re" autocomplete="off" value="<?php echo $dt['no_telp_re']?>" readonly >
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="nama_re">NAMA LENGKAP</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="nama_re" name="nama_re" autocomplete="off" value="<?php echo $dt['nama_re']?>" readonly >
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="email_re">ALAMAT EMAIL</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="email_re" name="email_re" autocomplete="off" value="<?php echo $dt['email_re']?>" readonly >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END DATA REGISTRASI -->

                                        
                                        <!-- LAMPIRAN FILE DATA REGIS -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px; display:none;">
                                          <div class="well">
                                            <center><font style="font-size:13pt"><strong>LAMPIRAN FILE DATA REGISTRASI</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row" style="display:none;">
                                          <div class="col-md-4">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="im_ktp_re">KTP</label>
                                              </div>
                                              <div class="col-md-7">
                                                <div id="r_ktp_re_1" >  
                                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_KTP_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File KTP"></i> Lihat File</a>
                                                  <!-- 
                                                  <label style="width:80px; display:inline-table; margin-top:0px;" class="btn btn-warning btn-block" style="cursor:pointer;">
                                                    Ubah
                                                    <input type="file" id="im_ktp_re" name="im_ktp_re" style="display:none;" >
                                                  </label> 
                                                  -->
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="im_sppt_re">SPPT</label>
                                              </div>
                                              <div class="col-md-7">
                                                <div id="r_sppt_re_1" >  
                                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_SPPT_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File SPPT"></i> Lihat File</a>
                                                  <!-- 
                                                  <label style="width:80px; display:inline-table; margin-top:0px;" class="btn btn-warning btn-block" style="cursor:pointer;">
                                                    Ubah
                                                    <input type="file" id="im_sppt_re" name="im_sppt_re" style="display:none;">
                                                  </label>
                                                  -->
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="row">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="im_stts_re">STTS</label>
                                              </div>
                                              <div class="col-md-7">
                                                <div id="r_stts_re_1" >  
                                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_PBB_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File STTS"></i> Lihat File</a>
                                                  <!-- 
                                                  <label style="width:80px; display:inline-table; margin-top:0px;" class="btn btn-warning btn-block" style="cursor:pointer;">
                                                    Ubah
                                                    <input type="file" id="im_stts_re" name="im_stts_re" style="display:none;" >
                                                  </label>
                                                  -->
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END LAMPIRAN FILE DATA REGIS -->

                                      <div id="row_bawah" class="">
                                        <!-- DATA PERMOHONAN ONLINE -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well">
                                            <center><font style="font-size:13pt"><strong>DATA PERMOHONAN ONLINE</strong></font></center>
                                          </div>
                                        </div>

                                        <!-- <form id="form_permo"> -->
                                        <div class="row">
                                          <!-- row kiri -->
                                          <div class="col-md-6" style="align-self:start;">
                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="nopel">NO PELAYANAN</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="nopel" name="nopel" autocomplete="off" value="<?php echo $dt['nopel']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="no_permohonan">NO PERMOHONAN</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="no_permohonan" name="no_permohonan" autocomplete="off" value="<?php echo $dt['no_permohonan']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="nop">NOP</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="nop" name="nop" autocomplete="off" value="<?php echo $dt['nop']?>" readonly>
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="nama_pemohon">NAMA PEMOHON</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="nama_pemohon" name="nama_pemohon" autocomplete="off" value="<?php echo $dt['nama_pemohon']?>" >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="telp">NO TELP</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="telp" name="telp" autocomplete="off" value="<?php echo $dt['telp']?>" >
                                              </div>
                                            </div>
                                          </div>

                                          <!-- row kanan -->
                                          <div class="col-md-6" style="align-self:start;">
                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="jns_pelayanan">JENIS PELAYANAN</label>
                                              </div>
                                              <div class="col-md-7">
                                                <?php echo $select_jns_ply; ?>
                                              </div>
                                            </div>

                                            <div class="row mt-2 <?php echo $dt['kd_jns_ply'] == '03' ? '' : 'hidden'; ?>">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="jns_pelayanan">SUB JENIS PELAYANAN</label>
                                              </div>
                                              <div class="col-md-7">
                                                <?php echo $select_sub_jns_ply; ?>
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="thn_permohonan">THN PERMOHONAN</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="thn_permohonan" name="thn_permohonan" autocomplete="off" value="<?php echo $dt['thn_permohonan']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="tgl_permohonan">TGL PERMOHONAN</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="tgl_permohonan" name="tgl_permohonan" autocomplete="off" value="<?php echo $dt['tgl_permohonan']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="alamat_pemohon">ALAMAT PEMOHON</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="alamat_pemohon" name="alamat_pemohon" autocomplete="off" value="<?php echo $dt['alamat_pemohon']?>" >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="keterangan">KETERANGAN</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="keterangan" name="keterangan" autocomplete="off" value="<?php echo $dt['keterangan']?>" >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END DATA PERMOHONAN ONLINE -->

                                        <!-- DATA SUBJEK PAJAK -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>DATA OBJEK PAJAK</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <!-- row kiri -->
                                          <div class="col-md-6" style="align-self:start;">
                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="subjek_pajak_id">NIK</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="subjek_pajak_id" name="subjek_pajak_id" autocomplete="off" value="<?php echo $dt['subjek_pajak_id']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="alamat_op_sppt">ALAMAT OP</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="alamat_op_sppt" name="alamat_op_sppt" autocomplete="off" value="<?php echo $dt['alamat_op_sppt']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="blok_op">BLOK/KAV/NO</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="blok_op" name="blok_op" autocomplete="off" value="<?php echo $dt['blok_op']?>" readonly>
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="luas_bangunan">LUAS BANGUNAN</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="luas_bangunan" name="luas_bangunan" autocomplete="off" value="<?php echo $dt['luas_bangunan']?>" readonly >
                                              </div>
                                            </div>
                                          </div>

                                          <!-- row kanan -->
                                          <div class="col-md-6" style="align-self:start;">

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="nama_wp_sppt">NAMA WP</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="nama_wp_sppt" name="nama_wp_sppt" autocomplete="off" value="<?php echo $dt['nama_wp_sppt']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="rt_op">RT</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="rt_op" name="rt_op" autocomplete="off" value="<?php echo $dt['rt_op']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="rw_op">RW</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="rw_op" name="rw_op" autocomplete="off" value="<?php echo $dt['rw_op']?>" readonly >
                                              </div>
                                            </div>

                                            <div class="row mt-2">
                                              <div class="col-md-4" style="padding-left:20px;">
                                                <label for="luas_bumi">LUAS BUMI</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="luas_bumi" name="luas_bumi" autocomplete="off" value="<?php echo $dt['luas_bumi']?>" readonly >
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END DATA OBJEK PAJAK -->

                                        <!-- 
                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="nama_wp_sppt">NAMA WP</label><br>
                                            <input class="form-control" type="text" id="nama_wp_sppt" name="nama_wp_sppt" autocomplete="off" value="<?php echo $dt['nama_wp_sppt']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="alamat_op_sppt">ALAMAT OBJEK PAJAK</label><br>
                                            <input class="form-control"  type="text" id="alamat_op_sppt" name="alamat_op_sppt" autocomplete="off" value="<?php echo $dt['alamat_op_sppt']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="pbb_yg_harus_dibayar">KETETAPAN PBB</label><br>
                                            <input class="form-control" type="text" id="pbb_yg_harus_dibayar" name="pbb_yg_harus_dibayar" maxlength="30" autocomplete="off" value="<?php echo $dt['pbb_yg_harus_dibayar']?>" readonly >
                                          </div>
                                        </div>
                                        -->
                                        


                                        <!-- LAMPIRAN FILE -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>LAMPIRAN FILE</strong></font></center>
                                          </div>
                                        </div>

                                        <div id="div_lampiran"></div>

                                        <div class="row" style="margin-top:40px">
                                          <div class="col-md-6">
                                            <label for="ket_pst">Keterangan</label><br>
                                            <input class="form-control" type="text" id="ket_pst" name="ket_pst" autocomplete="off" value="<?php echo $dt['ket_pst']?>" >
                                          </div>
                                        </div>

                                        <div class="row" style="margin-top:40px">
                                          <div class="col-md-6">
                                            <?php if ($this->uri->segment(3) == 'edit') { ?>
                                            <button class="btn btn-success" id="btn_approve" type="button">Approve</button>
                                            <button class="btn btn-warning" id="btn_tolak" type="button">Tolak</button>
                                            <?php } ?>
                                            <button class="btn btn-info" id="btn_back" type="button">Kembali</button>
                                          </div>
                                        </div>
                                        <!-- </form> -->

                                      </div>

                                    </div>
                                  </div>

                              </div>

                            </form>

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

var oTable;
var oTable2;

function padZero(input, length = 3) {
    // hapus karakter non angka
    let val = input.value.replace(/\D/g, '');

    if (val !== '') {
        input.value = val.padStart(length, '0');
    }
}

function get_rt_wp(rt){
  if(rt.length == 3){
    var ret = rt;
  } else if(rt.length == 2){
    var ret = '0'+rt;
  } else if(rt.length == 1){
    var ret = '00'+rt;
  }
  $('#rt_wp').val(ret);
}

function get_rw_wp(rw){
  if(rw.length == 2){
    var ret = rw;
  } else if(rw.length == 1){
    var ret = '0'+rw;
  }
  $('#rw_wp').val(ret);
}

function get_rt_op(rt){
  if(rt.length == 3){
    var ret = rt;
  } else if(rt.length == 2){
    var ret = '0'+rt;
  } else if(rt.length == 1){
    var ret = '00'+rt;
  }
  $('#rt_op').val(ret);
}

function get_rw_op(rw){
  if(rw.length == 2){
    var ret = rw;
  } else if(rw.length == 1){
    var ret = '0'+rw;
  }
  $('#rw_op').val(ret);
}

function hanyaAngka(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
}

function buildLampiran(list) {
    $("#div_lampiran").empty(); // hapus lama

    let html = `<div class="row">`;
    list.forEach(function(item) {
        html += `
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-4" style="padding-left:20px;">
                    <label for="${item.NM_FIELD}">${item.NM_LAMPIRAN}</label>
                  </div>
                  <div class="col-md-7">
                    <a target="_blank" href="<?php echo active_module_url().'monitoring_permo_upt/openblob_permo/${item.NM_FIELD}/'.$dt['id_ppo']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File ${item.NM_LAMPIRAN}"></i> Lihat File</a>
                  </div>
                </div>
              </div>
        `;
    });
    html += `</div>`;

    // <label style="width:80px; display:inline-table; margin-top:0px;" class="btn btn-warning btn-block" style="cursor:pointer;">
    //                         Ubah
    //                   <input type="file" id="${item.NM_FIELD}" name="${item.NM_FIELD}" style="display:none;">
    //                 </label>

    $("#div_lampiran").html(html);
}

function f_chg_lamp(id_lamp, id_sub_lamp) {
    $.ajax({
        url: "<?= active_module_url('permohonan_online_upt/get_lampiran_by_pelayanan_and_sub'); ?>",
        type: "POST",
        data: { jns_ply: id_lamp, sub_jns_ply: id_sub_lamp },
        dataType: "json",
        success: function(res) {
            if (res.result == "200") {
                buildLampiran(res.lampiran);
            } else {
                $("#div_lampiran").html("<p>Silakan Pilih Jenis Pelayanan.</p>");
            }
        }
    });
}


$(document).ready(function() {

  //// init
  var id_lamp = $('#jns_ply').val();
  f_chg_lamp(id_lamp, '999999');

  $('#nop_re').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });

  $('#nop').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });
  
  $('#btn_back').on('click', function() {
    window.location = '<?php echo active_module_url("loket_permohonan_online_upt"); ?>';
  }); 
  
  $('#btn_approve').on('click', function(e) {
    e.preventDefault();
    Swal.fire({
        icon: "info",
        title: "Peringatan",
        text: 'Approve Data Permohonan Ini?',
        confirmButtonText: "Approve",
        cancelButtonText: "Batal",
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            $('#myform').attr('action', "<?php echo active_module_url('loket_permohonan_online_upt/approve') ?>").submit();
        }
    });
    
  });

  $('#btn_tolak').on('click', function(e) {
    e.preventDefault();
    var ket = $('#ket_pst').val();
    if (!ket || ket.trim() === '') {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: 'Keterangan wajib diisi',
        })
    } else {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: 'Tolak Data Permohonan Ini?',
            confirmButtonText: "Tolak",
            cancelButtonText: "Batal",
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#myform').attr('action', "<?php echo active_module_url('loket_permohonan_online_upt/tolak') ?>").submit();
            }
        });
    }
    
  });

  $('#pbb_yg_harus_dibayar').autoNumeric('init', {
      aSep: '.', aDec: ',', vMax: '999999999999999',  mDec: '0'
  });

  $('#nominal_1, #nominal_2, #nominal_3, #nominal_4').autoNumeric('init', {
      aSep: '.', aDec: ',', vMax: '999999999999999',  mDec: '0'
  });
  

  // // OVERLAY SPINNER 
  $(document).on({
      ajaxStart: function(){
          $("#overlay").fadeIn(300);　
      },
      ajaxStop: function(){ 
          $("#overlay").fadeOut(300);　
      }    
  });



});

</script>