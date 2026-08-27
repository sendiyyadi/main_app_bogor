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
    /* width: 53% !important; */
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
  margin: 0 0 0 0 !important;
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
/* END SPINNER */

<?php if ($this->uri->segment(3) == 'detail') : ?>
  .tmb_file {
    display: none;
  }
<?php endif; ?>

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">PERMOHONAN ONLINE</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Permohonan Online</li>
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

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="nop_re">NOP PBB</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="nop_re" name="nop_re" autocomplete="off" value="<?php echo $dt['nop_re']?>" readonly >
                                              <input class="form-control" type="hidden" id="id_reg_esppt" name="id_reg_esppt" autocomplete="off" value="<?php echo $dt['id_reg_esppt']?>" >
                                            </div>
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
                                              <label for="no_telp_re">NO TELP</label>
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
                                      <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                        <div class="well">
                                          <center><font style="font-size:13pt"><strong>LAMPIRAN FILE DATA REGISTRASI</strong></font></center>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-4">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_ktp_re">KTP</label>
                                            </div>
                                            <div class="col-md-7">
                                              <a target="_blank" href="<?php echo active_module_url().'monitoring_pelayanan/openblob_reg_esppt/IM_KTP_BLOB/'.$fnopnik; ?>" class="btn btn-primary " data-toggle="tooltip" title="File KTP"></i> Lihat File</a>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_sppt_re">SPPT</label>
                                            </div>
                                            <div class="col-md-7">
                                              <a target="_blank" href="<?php echo active_module_url().'monitoring_pelayanan/openblob_reg_esppt/IM_SPPT_BLOB/'.$fnopnik; ?>" class="btn btn-primary " data-toggle="tooltip" title="File SPPT"></i> Lihat File</a>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_stts_re">STTS</label>
                                            </div>
                                            <div class="col-md-7">
                                              <a target="_blank" href="<?php echo active_module_url().'monitoring_pelayanan/openblob_reg_esppt/IM_PBB_BLOB/'.$fnopnik; ?>" class="btn btn-primary " data-toggle="tooltip" title="File STTS"></i> Lihat File</a>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- END LAMPIRAN FILE DATA REGIS -->



                                      <!-- DATA PERMOHONAN ONLINE -->
                                      <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                        <div class="well">
                                          <center><font style="font-size:13pt"><strong>DATA PERMOHONAN ONLINE</strong></font></center>
                                        </div>
                                      </div>

                                      <!-- <form id="form_permo"> -->
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="nopel">NO PELAYANAN</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="nopel" name="nopel" autocomplete="off" value="<?php echo $dt['nopel']?>" readonly >
                                              <input class="form-control" type="hidden" id="id_ppo" name="id_ppo" autocomplete="off" value="<?php echo $dt['id_ppo']?>" readonly >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="jns_pelayanan">JENIS PELAYANAN</label>
                                            </div>
                                            <div class="col-md-7">
                                              <?php echo $select_jns_ply; ?>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="no_permohonan">NO PERMOHONAN</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="no_permohonan" name="no_permohonan" autocomplete="off" value="<?php echo $dt['no_permohonan']?>" readonly >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="thn_permohonan">THN PERMOHONAN</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="thn_permohonan" name="thn_permohonan" autocomplete="off" value="<?php echo $dt['thn_permohonan']?>" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="nop">NOP</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="nop" name="nop" autocomplete="off" value="<?php echo $dt['nop']?>" readonly >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="tgl_permohonan">TGL PERMOHONAN</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="tgl_permohonan" name="tgl_permohonan" autocomplete="off" value="<?php echo $dt['tgl_permohonan']?>" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="nama_pemohon">NAMA PEMOHON</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="nama_pemohon" name="nama_pemohon" autocomplete="off" value="<?php echo $dt['nama_pemohon']?>" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="alamat_pemohon">ALAMAT PEMOHON</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="alamat_pemohon" name="alamat_pemohon" autocomplete="off" value="<?php echo $dt['alamat_pemohon']?>" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="telp">NO TELP</label>
                                            </div>
                                            <div class="col-md-7">
                                              <input class="form-control" type="text" id="telp" name="telp" autocomplete="off" value="<?php echo $dt['telp']?>" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
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



                                      <!-- LAMPIRAN FILE -->
                                      <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                        <div class="well" >
                                          <center><font style="font-size:13pt"><strong>LAMPIRAN FILE</strong></font></center>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_spop">SPOP</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_SKKP_PBB'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SKKP_PBB1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                            <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_spop').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_spop" name="im_spop" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_lspop">LSPOP</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_SPMKP_PBB'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SPMKP_PBB1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_lspop').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_lspop" name="im_lspop" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_ktp">KTP</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_KTP_WP'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_KTP_WP1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_ktp').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_ktp" name="im_ktp" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_sertanah">BUKTI KEPEMILIKAN TANAH</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_SERTIFIKAT_TANAH'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SERTIFIKAT_TANAH1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif; ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_sertanah').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_sertanah" name="im_sertanah" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_imb">IMB</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_IMB'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_IMB1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_imb').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_imb" name="im_imb" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_foto_op">FOTO OBJEK PAJAK</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_AKTE_JUAL_BELI'] ==  1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_AKTE_JUAL_BELI1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif; ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_foto_op').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_foto_op" name="im_foto_op" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_valbphtb">VALIDASI BPHTB</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_SURAT_KUASA'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SURAT_KUASA1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_valbphtb').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_valbphtb" name="im_valbphtb" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_pengantar_desa">SURAT PENGANTAR DESA</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_PERMOHONAN'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_PERMOHONAN1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_pengantar_desa').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_pengantar_desa" name="im_pengantar_desa" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_nonsengketa">SURKET TIDAK SENGKETA</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_STTS'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_STTS1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_nonsengketa').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_nonsengketa" name="im_nonsengketa" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_riwyt_tanah">RIWAYAT TANAH</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_SK_KEBERATAN'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SK_KEBERATAN1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_riwyt_tanah').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_riwyt_tanah" name="im_riwyt_tanah" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_sppt">SPPT</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_SPPT'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SPPT1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_sppt').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_sppt" name="im_sppt" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_stts">BUKTI BAYAR ASLI / STTS</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_SPPT_STTS'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SPPT_STTS1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_stts').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_stts" name="im_stts" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_sk_pengurangan">SK PENGURANGAN</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_SK_PENGURANGAN'] == 1): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SK_PENGURANGAN1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_sk_pengurangan').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_sk_pengurangan" name="im_sk_pengurangan" >
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="row">
                                            <div class="col-md-4" style="padding-left:20px;">
                                              <label for="im_other">LAIN-LAIN</label>
                                            </div>
                                            <div class="col-md-3">
                                              <?php if ($da['L_LAIN_LAIN']): ?>
                                                <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_LAIN_LAIN1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                              <?php else: ?>
                                                <p class="teks_red">File Tidak Ada</p>
                                              <?php endif ?>
                                            </div>
                                            <div class="col-md-3">
                                              <input class="btn btn-warning tmb_file" type="button" value="Ubah File" onclick="document.getElementById('im_other').click();" />
                                              <input style="width:100%; height:100% !important; display: none;" type="file" id="im_other" name="im_other" >
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row" style="margin-top:40px">
                                        <div class="col-md-6">
                                          <?php if ($this->uri->segment(3) == 'edit') : ?>
                                            <button class="btn btn-success" type="submit">Simpan</button>
                                          <?php endif; ?>
                                          <button type="button" class="btn btn-primary" id="btn_back">Kembali</button>
                                        </div>
                                      </div>
                                      <!-- </form> -->


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


<!-- Begin Modal Dialog entry Detail -->
<div id="cuDialogDetail" class="modal" style="width:600px" tabindex="-1" role="dialog" aria-labelledby="cuDialogDetailLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h3 id="cuDialogDetailLabel">Proses Kirim Pelayanan</h3>
          </div>
          <div class="modal-body">
              <div class="form-horizontal">

                  <div class="row">
                    <div class="col-md-3">
                      NOP
                    </div>
                    <div class="col-md-7">
                      <input class="form-control" type="text" name="dtl_nop_tx" id="dtl_nop_tx" readonly />
                      <input class="form-control" type="hidden" name="dtl_nop" id="dtl_nop" readonly />
                      <input class="form-control" type="hidden" name="dtl_thn_ply" id="dtl_thn_ply" readonly />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      Jenis Pelayanan
                    </div>
                    <div class="col-md-7">
                      <input class="form-control" type="text" name="dtl_ply_tx" id="dtl_ply_tx" readonly />
                      <input class="form-control" type="hidden" name="dtl_ply" id="dtl_ply" readonly />
                    </div>
                  </div>

              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_dtl_simpan">Simpan</button>
          </div>
      </div>
  </div>
</div>
<!-- end Modal Dialog entry Detail -->

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>

<script>

function f_chg_div_lamp_regesppt(nop, nik) {
  // //// hapus dulu semua elemen
  // var el1 = document.getElementById("r_ktp_re_1");
  // el1.removeChild();
  // var el2 = document.getElementById("r_sppt_re_1");
  // el2.removeChild();
  // var el3 = document.getElementById("r_stts_re_1");
  // el3.removeChild();

  // im_ktp
  var div_ktp = document.createElement('div');

  div_ktp.className = 'row';
  div_ktp.innerHTML = '<a target="_blank" href="<?php echo active_module_url().'monitoring_pelayanan/openblob_reg_esppt/IM_KTP_BLOB/'; ?>'+nop+'/'+nik+'" class="btn btn-primary " data-toggle="tooltip" title="File KTP"></i> Lihat File</a>';
  document.getElementById('r_ktp_re_1').appendChild(div_ktp);

  var element_ktp = document.getElementById("input_ktp_re_2");
  element_ktp.remove();

  // im_sppt
  var div_sppt = document.createElement('div');

  div_sppt.className = 'row';
  div_sppt.innerHTML = '<a target="_blank" href="<?php echo active_module_url().'monitoring_pelayanan/openblob_reg_esppt/IM_SPPT_BLOB/'; ?>'+nop+'/'+nik+'" class="btn btn-primary " data-toggle="tooltip" title="File SPPT"></i> Lihat File</a>';
  document.getElementById('r_sppt_re_1').appendChild(div_sppt);

  var element_sppt = document.getElementById("input_sppt_re_2");
  element_sppt.remove();

  // im_stts
  var div_stts = document.createElement('div');

  div_stts.className = 'row';
  div_stts.innerHTML = '<a target="_blank" href="<?php echo active_module_url().'monitoring_pelayanan/openblob_reg_esppt/IM_PBB_BLOB/'; ?>'+nop+'/'+nik+'" class="btn btn-primary " data-toggle="tooltip" title="File STTS"></i> Lihat File</a>';
  document.getElementById('r_stts_re_1').appendChild(div_stts);

  var element_stts = document.getElementById("input_stts_re_2");
  element_stts.remove();

}

function f_btn_cari_nop(nop){
  $.ajax({
      url: "<?php echo active_module_url() ?>monitoring_pelayanan/get_nop_reg_esppt/" + nop,
      async: true,
      success: function(j) {
        // setTimeout(function(){
        //   $("#overlay").fadeOut(100);
        // },500);

        var data = $.parseJSON(j);
        if (data['result'] == '400') {
          alert(data['msg']);
          $("#id_reg_esppt").val('');
          $("#nama_wp_re").val('');
          $("#alamat_op_re").val('');
          $("#nik_re").val('');
          $("#no_telp_re").val('');
          $("#nama_re").val('');
          $("#email_re").val('');
          return false;
        } else if (data['result'] == '201') {
          alert(data['msg']);
          $('#btn_cari_nop').addClass('hidden');
          $("#id_reg_esppt").val(data['id_re']);
          $("#nama_wp_re").val(data['nama_wp_re']);
          $("#alamat_op_re").val(data['alamat_wp_re']);
          $("#nik_re").val(data['nik_re']);
          $("#no_telp_re").val(data['no_telp_re']);
          $("#nama_re").val(data['nama_re']);
          $("#email_re").val(data['email_re']);
          // var xnop = nop.replace('-','').replace('.','');
          // alert(xnop);
          f_chg_div_lamp_regesppt(data['nop'], data['nik_re']);

          $('#row_re_2').addClass('hidden');
          $('#row_re_1').removeClass('hidden');
          

        } else if (data['result'] == '202') {
          alert(data['msg']);
          $('#btn_cari_nop').addClass('hidden');
          $("#id_reg_esppt").val(data['id_re']);
          $("#nama_wp_re").val(data['nama_wp_re']);
          $("#alamat_op_re").val(data['alamat_wp_re']);
          $("#nik_re").val(data['nik_re']);
          $("#no_telp_re").val(data['no_telp_re']);
          $("#nama_re").val(data['nama_re']);
          $("#email_re").val(data['email_re']);

          $('#row_re_1').addClass('hidden');
          $('#row_re_2').removeClass('hidden');
          document.getElementById('nama_wp_re').readOnly = false;
          document.getElementById('alamat_op_re').readOnly = false;
          document.getElementById('nik_re').readOnly = false;
          document.getElementById('no_telp_re').readOnly = false;
          document.getElementById('nama_re').readOnly = false;
          document.getElementById('email_re').readOnly = false;
        }
        else {
          $("#id_reg_esppt").val('');
          $("#nama_wp_re").val('');
          $("#alamat_op_re").val('');
          $("#nik_re").val('');
          $("#no_telp_re").val('');
          $("#nama_re").val('');
          $("#email_re").val('');
          alert('Data tidak ditemukan.. silakan refresh halaman..'); return false;
        }
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });
}

$(document).ready(function() {
  $('#nop_re').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });

  $('#nop').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });

  $("#btn_cari_nop").click(function () {//The load button
      var nop = $('#nop_re').val();
      $("#overlay").fadeIn(300);
      
      $.ajax({
        url: "<?php echo active_module_url() ?>monitoring_pelayanan/get_nop_reg_esppt/" + nop,
        type: 'POST',
        success: function(j) {
          var data = $.parseJSON(j);
          if (data['result'] == '400') {
            alert(data['msg']);
            $("#id_reg_esppt").val('');
            $("#nama_wp_re").val('');
            $("#alamat_op_re").val('');
            $("#nik_re").val('');
            $("#no_telp_re").val('');
            $("#nama_re").val('');
            $("#email_re").val('');
            return false;
          } else if (data['result'] == '201') {
            alert(data['msg']);
            $('#btn_cari_nop').addClass('hidden');
            $("#id_reg_esppt").val(data['id_re']);
            $("#nama_wp_re").val(data['nama_wp_re']);
            $("#alamat_op_re").val(data['alamat_wp_re']);
            $("#nik_re").val(data['nik_re']);
            $("#no_telp_re").val(data['no_telp_re']);
            $("#nama_re").val(data['nama_re']);
            $("#email_re").val(data['email_re']);
            // var xnop = nop.replace('-','').replace('.','');
            // alert(xnop);
            f_chg_div_lamp_regesppt(data['nop'], data['nik_re']);

            $('#row_re_2').addClass('hidden');
            $('#row_re_1').removeClass('hidden');

          } else if (data['result'] == '202') {
            alert(data['msg']);
            $('#btn_cari_nop').addClass('hidden');
            $("#id_reg_esppt").val(data['id_re']);
            $("#nama_wp_re").val(data['nama_wp_re']);
            $("#alamat_op_re").val(data['alamat_wp_re']);
            $("#nik_re").val(data['nik_re']);
            $("#no_telp_re").val(data['no_telp_re']);
            $("#nama_re").val(data['nama_re']);
            $("#email_re").val(data['email_re']);

            $('#row_re_1').addClass('hidden');
            $('#row_re_2').removeClass('hidden');
            document.getElementById('nama_wp_re').readOnly = false;
            document.getElementById('alamat_op_re').readOnly = false;
            document.getElementById('nik_re').readOnly = false;
            document.getElementById('no_telp_re').readOnly = false;
            document.getElementById('nama_re').readOnly = false;
            document.getElementById('email_re').readOnly = false;
          }
          else {
            $("#id_reg_esppt").val('');
            $("#nama_wp_re").val('');
            $("#alamat_op_re").val('');
            $("#nik_re").val('');
            $("#no_telp_re").val('');
            $("#nama_re").val('');
            $("#email_re").val('');
            alert('Data tidak ditemukan.. silakan refresh halaman..'); return false;
          }
        },
        complete: function () {
            $("#overlay").fadeOut(300);
        },
        error: function(xhr, desc, er) {
          alert(er);
        }
      });
  });


  $("#btn_send_re").click(function () {//The load button
      var nopnik = $('#id_reg_esppt').val();
      $("#overlay").fadeIn(300);
      $.ajax({
        url: "<?php echo active_module_url() ?>monitoring_pelayanan/send_mail_reg_esppt/" + nopnik,
        success: function(j) {
          var data = $.parseJSON(j);
          alert(data['msg']);
        },
        complete: function () {
            $("#overlay").fadeOut(300);
        },
        error: function(xhr, desc, er) {
          alert(er);
        }
      });
      
  });

  $('#btn_save_re').on('click', function() {
    var data = new FormData(document.getElementById("myform"));

    $("#overlay").fadeIn(300);

    var nop = $('#nop_re').val();
    var nik = $('#nik_re').val();
    var no_telp = $('#no_telp_re').val();
    var email = $('#email_re').val();
    if (no_telp == '' || email == ''){
      alert('Lengkapi data registrasi dengan benar...');
      return false;
    }

    $.ajax({
      url: "<?php echo active_module_url() ?>monitoring_pelayanan/save_reg_esppt/",
      type: 'POST',
      data: data,
      processData: false,
      contentType: false,
      success: function(j) {
        var data = $.parseJSON(j);
        alert(data['msg']);
      },
      complete: function () {
          $("#overlay").fadeOut(300);
          $('#row_re_2').addClass('hidden');
          $('#row_re_1').removeClass('hidden');
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });

  });


  
  $('#btn_send_permo').on('click', function() {
    var data = new FormData(document.getElementById("myform"));

    $("#overlay").fadeIn(300);

    var nop = $('#nop').val();
    var nama = $('#nama_pemohon').val();
    var telp = $('#telp').val();
    var thn_permo = $('#thn_permohonan').val();
    var alamat = $('#alamat_pemohon').val();
    var ket = $('#keterangan_pemohon').val();
    if (nop == '' || nama == '' || telp == '' || thn_permo == '' || alamat == '' || ket == ''){
      alert('Lengkapi data Permohonan Online dengan benar...');
      return false;
    }

    $.ajax({
      url: "<?php echo active_module_url() ?>monitoring_pelayanan/save_permo/",
      type: 'POST',
      data: data,
      processData: false,
      contentType: false,
      success: function(j) {
        var data = $.parseJSON(j);
        if(data['result'] == 400){
          alert(data['msg']); return false;
        } else {
          alert(data['msg']);
          $("#cuDialogDetail").modal("show");
          $('#dtl_nop').val(data['dtl_nop']);
          $('#dtl_nop_tx').val(data['dtl_nop_tx']);
          $('#dtl_ply').val(data['dtl_ply']);
          $('#dtl_ply_tx').val(data['dtl_ply_tx']);
          $('#dtl_thn_ply').val(data['dtl_thn_ply']);
        }

      },
      complete: function () {
          $("#overlay").fadeOut(300);
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });

  });


  $('#btn_dtl_simpan').on('click', function() {
    
    $("#overlay").fadeIn(300);

    var nop = $('#dtl_nop').val();
    var kd_ply = $('#dtl_ply').val();
    var thn_ply = $('#dtl_thn_ply').val();

    $.ajax({
      url: "<?php echo active_module_url() ?>monitoring_pelayanan/appr_permo/"+nop+"/"+thn_ply+"/"+kd_ply,
      type: 'POST',
      success: function(j) {
        var data = $.parseJSON(j);
        alert(data['msg']);
        $("#cuDialogDetail").modal("hide");
      },
      complete: function () {
          $("#overlay").fadeOut(300);
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });

  });


  $("#cuDialogDetail").draggable({
      handle: ".modal-header"
  });

  
  $('#btn_back').click(function() {
    window.location.href = '<?php echo active_module_url('monitoring_pelayanan/'); ?>';
  });
  

  // $('#btn_save_re').click(function() {
  //   var nop = $('#nop_re').val();
  //   $.ajax({
  //     url: "<?php //echo active_module_url() ?>monitoring_pelayanan/save_reg_esppt/" + nop,
  //     async: false,
  //     success: function(j) {
  //       var data = $.parseJSON(j);
       
  //         alert(data['msg']);
  //         $("#nama_wp_re").val(data['nama_wp_re']);
  //         $("#alamat_op_re").val(data['alamat_wp_re']);
  //         $("#nik_re").val(data['nik_re']);
  //         $("#no_telp_re").val(data['no_telp_re']);
  //         $("#nama_re").val(data['nama_re']);
  //         $("#email_re").val(data['email_re']);
  //         // var xnop = nop.replace('-','').replace('.','');
  //         // alert(xnop);
          

  //         $('#row_re_2').addClass('hidden');
  //         $('#row_re_1').removeClass('hidden');
          

  //     },
  //     error: function(xhr, desc, er) {
  //       alert(er);
  //     }
  //   });
  // });

 

  // // OVERLAY SPINNER 
  $(document).on({
      ajaxStart: function(){
          $("#overlay").fadeIn(300);　
      },
      ajaxStop: function(){ 
          $("#overlay").fadeOut(300);　
      }    
  });

  // $(document).ajaxSend(function() {
  //   $("#overlay").fadeIn(300);　
  // });

  // $('#btn_tes').click(function(){
  //   $.ajax({
  //     type: 'GET',
  //     success: function(data){
  //       console.log(data);
  //     }
  //   }).done(function() {
  //     setTimeout(function(){
  //       $("#overlay").fadeOut(300);
  //     },500);
  //   });
  // });  
  // // END OVERLAY SPINNER

  


});

</script>