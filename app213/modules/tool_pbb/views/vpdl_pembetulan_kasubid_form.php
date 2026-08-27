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

@media (min-width: 768px) {
    .row_ba {
        padding-left: 25px;
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
                        <h4 class="mb-0">KASUBID PENDANIL PEMBETULAN</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Kasubid Pendanil Pembetulan</li>
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
                                                <input class="form-control" type="text" id="nop_re" name="nop_re" autocomplete="off" value="<?php echo $dt['nop_re']?>" readonly >
                                                <input class="form-control" type="hidden" id="nop_t" name="nop_t" autocomplete="off" value="<?php echo $dt['nop_t']?>" readonly >
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
                                                <label for="no_telp_re">NO TELP</label>
                                              </div>
                                              <div class="col-md-7">
                                                <input class="form-control" type="text" id="no_telp_re" name="no_telp_re" autocomplete="off" value="<?php echo $dt['no_telp_re']?>" readonly>
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
                                                <div id="r_ktp_re_1" >  
                                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_KTP_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File KTP"></i> Lihat File</a>
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
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- END LAMPIRAN FILE DATA REGIS -->

                                        <!-- LAMPIRAN FILE -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>LAMPIRAN FILE PERMOHONAN</strong></font></center>
                                          </div>
                                        </div>

                                        <div id="div_lampiran"></div>

                                        <!-- END LAMPIRAN FILE PERMOHONAN -->

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
                                                <input class="form-control" type="text" id="telp" name="telp" autocomplete="off" value="<?php echo $dt['telp']?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" >
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
                                            <center><font style="font-size:13pt"><strong>DATA WAJIB PAJAK / SUBJEK PAJAK</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="nik_wp_sppt">NIK</label><br>
                                            <input class="form-control" type="text" id="nik_wp_sppt" name="nik_wp_sppt" maxlength="16" autocomplete="off" value="<?php echo $dt['nik_wp_sppt']?>" >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="nm_wp_sppt">NAMA LENGKAP</label><br>
                                            <input class="form-control" type="text" id="nm_wp_sppt" name="nm_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['nm_wp_sppt']?>" >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-9">
                                            <label for="jln_wp_sppt">ALAMAT LENGKAP</label><br>
                                            <input class="form-control"  type="text" id="jln_wp_sppt" name="jln_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['jln_wp_sppt']?>" >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="blok_kav_no_wp_sppt">BLOK / NO</label><br>
                                            <input class="form-control"  type="text" id="blok_kav_no_wp_sppt" name="blok_kav_no_wp_sppt" maxlength="15" autocomplete="off" value="<?php echo $dt['blok_kav_no_wp_sppt']?>" >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-3">
                                            <label for="rt_wp_sppt">RT</label><br>
                                            <input class="form-control" type="text" id="rt_wp_sppt" name="rt_wp_sppt" autocomplete="off" maxlength="3" value="<?php echo $dt['rt_wp_sppt']?>" >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="rw_wp_sppt">RW</label><br>
                                            <input class="form-control" type="text" id="rw_wp_sppt" name="rw_wp_sppt" autocomplete="off" maxlength="2" value="<?php echo $dt['rw_wp_sppt']?>" >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="kelurahan_wp_sppt">KELURAHAN</label><br>
                                            <input class="form-control" type="text" id="kelurahan_wp_sppt" name="kelurahan_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['kelurahan_wp_sppt']?>" >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="kota_wp_sppt">KABUPATEN / KOTA</label><br>
                                            <input class="form-control" type="text" id="kota_wp_sppt" name="kota_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['kota_wp_sppt']?>" >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="kd_pos_wp_sppt">KODE POS</label><br>
                                            <input class="form-control" type="text" id="kd_pos_wp_sppt" name="kd_pos_wp_sppt" maxlength="5" autocomplete="off" value="<?php echo $dt['kd_pos_wp_sppt']?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="nohp">NO HP (AKTIF)</label><br>
                                            <input class="form-control" type="text" id="nohp" name="nohp" maxlength="15" autocomplete="off" value="<?php echo $dt['nohp']?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="email_wp_sppt">ALAMAT EMAIL</label><br>
                                            <input class="form-control" type="text" id="email_wp_sppt" name="email_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['email_wp_sppt']?>" >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="">STATUS OBJEK PAJAK</label><br>
                                            <?php echo $select_sts_op; ?>
                                            <!-- <input class="form-control" type="text" id="sts_objek_pajak" name="sts_objek_pajak" maxlength="15" autocomplete="off" value="<?php //echo $dt['sts_objek_pajak']?>" > -->
                                          </div>
                                          <div class="col-md-6">
                                            <label for="">PEKERJAAN</label><br>
                                            <?php echo $select_pekerjaan_wp; ?>
                                            <!-- <input class="form-control" type="text" id="pekerjaan_wp" name="pekerjaan_wp" maxlength="30" autocomplete="off" value="<?php //echo $dt['pekerjaan_wp']?>" > -->
                                          </div>
                                        </div>

                                        <?php if ($this->uri->segment(3) != 'detail') { ?>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <button class="btn btn-warning" type="button" id="btn_save_dsp">SIMPAN DATA SUBJEK PAJAK</button>
                                          </div>
                                        </div>
                                        <?php } ?>

                                        <!-- OBJEK PAJAK -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>DATA OBJEK PAJAK</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="nops">NOP</label><br>
                                            <input class="form-control" type="text" id="nops" name="nops" autocomplete="off" value="<?php echo $dt['nops']?>" readonly >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="">Luas Tanah</label><br>
                                            <input class="form-control" type="text" id="luas_tanah" name="luas_tanah" autocomplete="off" value="<?php echo $dt['luas_tanah']?>" >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="">KD ZNT</label><br>
                                            <?php echo $select_kd_znt; ?>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-9">
                                            <label for="jln_op_sppt">ALAMAT LENGKAP</label><br>
                                            <input class="form-control" type="text" id="jln_op_sppt" name="jln_op_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['jln_op_sppt']?>" >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="blok_kav_no_op_sppt">BLOK / NO</label><br>
                                            <input class="form-control" type="text" id="blok_kav_no_op_sppt" name="blok_kav_no_op_sppt" maxlength="15" autocomplete="off" value="<?php echo $dt['blok_kav_no_op_sppt']?>" >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-3">
                                            <label for="rt_op_sppt">RT</label><br>
                                            <input class="form-control" type="text" id="rt_op_sppt" name="rt_op_sppt" maxlength="3" autocomplete="off" value="<?php echo $dt['rt_op_sppt']?>" >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="rw_op_sppt">RW</label><br>
                                            <input class="form-control" type="text" id="rw_op_sppt" name="rw_op_sppt" maxlength="2" autocomplete="off" value="<?php echo $dt['rw_op_sppt']?>" >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="alamat_op_1">Jenis Tanah</label><br>
                                            <?php echo $select_jns_tanah; ?>
                                            <!-- <input class="form-control" type="text" id="" name="" value="<?php //echo $dt['jns_tanah']?>" > -->
                                          </div>
                                        </div>

                                        <!-- <div class="row">
                                          <div class="col-md-6">
                                            <label for="nop_ttg_1">NOP TETANGGA 1</label><br>
                                            <input class="form-control" type="text" id="nop_ttg_1" name="nop_ttg_1" autocomplete="off" value="<?php //echo $dt['nop_ttg_1']?>" readonly >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="alamat_op_2">NAMA WP TETANGGA 1</label><br>
                                            <input class="form-control" type="text"  id="nama_wp_1" name="nama_wp_1" autocomplete="off" value="<?php //echo $dt['nama_wp_1']?>" readonly >
                                          </div>
                                        </div> -->

                                        <?php if ($this->uri->segment(3) != 'detail') { ?>
                                        <div class="row">
                                          <div class="col-md-6">
                                            <button class="btn btn-warning" type="button" id="btn_save_dop">SIMPAN DATA OBJEK PAJAK</button>
                                          </div>
                                        </div>
                                        <?php } ?>

                                        <!-- Close Objek pajak -->

                                        <!-- DATA BANGUNAN -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>DATA BANGUNAN</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <?php if ($this->uri->segment(3) != 'detail') { ?>
                                            <button class="btn btn-success" id="btn_tambah_detail" type="button">Tambah Bangunan</button>
                                            <?php } ?>
                                            <table class="table" id="tableKD">
                                                <thead>
                                                    <tr>
                                                        <th>dtl_id</th>
                                                        <th>dtl_model</th>
                                                        <th>No Bangunan</th>
                                                        <th>Jns Penggunaan</th>
                                                        <th>Luas Bangunan</th>
                                                        <th>kd_jpb</th>
                                                        <th>Ubah</th>
                                                        <th>Hapus</th>
                                                        <th>Fasilitas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                          </div>
                                          
                                        </div>
                                        <!-- END DATA BANGUNAN -->

                                        <?php if ($this->uri->segment(3) != 'detail') { ?>
                                        <div class="row mt-4">
                                          <div class="col-md-6">
                                            <a class="btn btn-danger" id="btn_hitung_njop_bumi" type="button" style="color:white">HITUNG NJOP BUMI</a>
                                          </div>
                                        </div>
                                        <?php } ?>

                                        <div class="row">
                                          <div class="col-md-3">
                                            <label for="tahun_awal">NJOP BUMI PER M2</label><br>
                                            <input class="form-control" type="text" id="njop_bumi_perm_op" name="njop_bumi_perm_op" autocomplete="off" value="<?php echo $dt['njop_bumi_perm_op']; ?>" readonly  >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="tahun_awal">NJOP BUMI</label><br>
                                            <input class="form-control" type="text" id="njop_bumi_op" name="njop_bumi_op" autocomplete="off" value="<?php echo $dt['njop_bumi_op']; ?>" readonly  >
                                          </div>
                                        </div>

                                        <?php if ($this->uri->segment(3) != 'detail') { ?>
                                        <div class="row mt-4">
                                          <div class="col-md-6">
                                            <a class="btn btn-danger" id="btn_hitung_njop_bng" type="button" style="color:white">HITUNG NJOP BANGUNAN</a>
                                          </div>
                                        </div>
                                        <?php } ?>

                                        <div class="row">
                                          <div class="col-md-3">
                                            <label for="tahun_awal">NJOP BANGUNAN PER M2</label><br>
                                            <input class="form-control" type="text" id="njop_bng_perm_op" name="njop_bng_perm_op" autocomplete="off" value="<?php echo $dt['njop_bng_perm_op']; ?>" readonly  >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="tahun_awal">NJOP BANGUNAN</label><br>
                                            <input class="form-control" type="text" id="njop_bng_op" name="njop_bng_op" autocomplete="off" value="<?php echo $dt['njop_bng_op']; ?>" readonly  >
                                          </div>
                                        </div>

                                        <div class="row mt-4">
                                          <div class="col-md-3">
                                            <label for="tahun_awal">TAHUN AWAL PEMBETULAN</label><br>
                                            <input class="form-control" type="number" id="tahun_awal" name="tahun_awal" maxlength="4" autocomplete="off" value="<?php echo $dt['tahun_awal']?>" >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="tahun_akhir">TAHUN AKHIR PEMBETULAN</label><br>
                                            <input class="form-control" type="number" id="tahun_akhir" name="tahun_akhir" maxlength="4" autocomplete="off" value="<?php echo $dt['tahun_akhir']?>" >
                                          </div>
                                        </div>

                                        <hr>
                                        <table style="width:100%; border-collapse:collapse;">
                                            <thead>
                                                <tr>
                                                    <th align="left">PERSYARATAN PENELITI</th>
                                                    <th>YA</th>
                                                    <th>TIDAK</th>
                                                    <th>KETERANGAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($syarat as $i => $row): ?>
                                                <tr>
                                                    <td>
                                                        <?= ($i+1).'. '.$row->KET ?>
                                                    </td>

                                                    <input type="hidden" name="id_ref[]" value="<?= $row->ID ?>">

                                                    <!-- YA -->
                                                    <td align="center">
                                                        <input type="radio"
                                                               name="status[<?= $row->ID ?>]"
                                                               value="Y"
                                                               <?= ($row->STATUS === 'Y') ? 'checked' : '' ?>
                                                               <?= ($mode === 'view') ? 'disabled' : '' ?> >
                                                    </td>

                                                    <!-- TIDAK -->
                                                    <td align="center">
                                                        <input type="radio"
                                                               name="status[<?= $row->ID ?>]"
                                                               value="T"
                                                               <?= ($row->STATUS === 'T') ? 'checked' : '' ?>
                                                               <?= ($mode === 'view') ? 'disabled' : '' ?> >
                                                    </td>

                                                    <!-- KETERANGAN -->
                                                    <td>
                                                        <input type="text" class="form-control"
                                                               name="ket[<?= $row->ID ?>]"
                                                               style="width:100%;"
                                                               value="<?= htmlspecialchars($row->KETERANGAN ?? '') ?>"
                                                               <?= ($mode === 'view') ? 'readonly' : '' ?>>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <hr>

                                        <div class="row" >
                                          <div class="col-md-2" >
                                            <label for="ket_verlap">KETERANGAN BERKAS PENELITI</label>
                                          </div>
                                          <div class="col-md-4">
                                              <input class="form-control" type="text" id="ket_verlap" name="ket_verlap" autocomplete="off" value="<?php echo $dt['ket_verlap']?>" style="text-transform: uppercase;" >
                                          </div>
                                          <div class="col-md-1" >
                                              <label>LAMPIRAN 1</label>
                                          </div>
                                          <div class="col-md-4">
                                              <?php if ($mode === 'view') { ?> 
                                                <?php if ($dl['L_VERLAP1'] == 1) : ?>
                                                  <?php echo $dl['L_VERLAP11']; ?>
                                                <?php else : echo '<font style="color:red;">File tidak ada</font>'; endif ?>
                                              <?php } else { ?>
                                              <input type="file" id="im_l_verlap1" style="display: inline;" name="im_l_verlap1" accept=".pdf,.jpg, .png, .jpeg">
                                              <span id="span_im_l_verlap1"></span>
                                              <?php } ?>
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-2" >
                                            <label for="rekom_verlap">REKOMENDASI PENELITI</label>
                                          </div>
                                          <div class="col-md-4">
                                              <input class="form-control" type="text" id="rekom_verlap" name="rekom_verlap" autocomplete="off" value="<?php echo $dt['rekom_verlap']?>" style="text-transform: uppercase;" >
                                          </div>
                                          <div class="col-md-1" >
                                              <label>LAMPIRAN 2</label>
                                          </div>
                                          <div class="col-md-4">
                                              <?php if ($mode === 'view') { ?>
                                                <?php if ($dl['L_VERLAP2'] == 1) : ?>
                                                  <?php echo $dl['L_VERLAP21']; ?>
                                                <?php else : echo '<font style="color:red;">File tidak ada</font>'; endif ?>
                                              <?php } else { ?>
                                              <input type="file" id="im_l_verlap2" style="display: inline;" name="im_l_verlap2" accept=".pdf,.jpg, .png, .jpeg">
                                              <span id="span_im_l_verlap2"></span>
                                              <?php } ?>
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-2" >
                                            <label for="penggunaan_bng_pdl">Penggunaan Bangunan</label>
                                          </div>
                                          <div class="col-md-10">
                                              <input class="form-control" type="text" id="penggunaan_bng_pdl" name="penggunaan_bng_pdl" autocomplete="off" value="<?php echo $dt['penggunaan_bng_pdl']?>" style="text-transform: uppercase;" readonly >
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-2" >
                                            <label for="objek_bng_pdl">Objek Bangunan</label>
                                          </div>
                                          <div class="col-md-10">
                                              <input class="form-control" type="text" id="objek_bng_pdl" name="objek_bng_pdl" autocomplete="off" value="<?php echo $dt['objek_bng_pdl']?>" style="text-transform: uppercase;" readonly >
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-2" >
                                            <label for="dasar_penilaian">Dasar Penilaian</label>
                                          </div>
                                          <div class="col-md-10">
                                              <input class="form-control" type="text" id="dasar_penilaian" name="dasar_penilaian" autocomplete="off" value="<?php echo $dt['dasar_penilaian']?>" style="text-transform: uppercase;" readonly >
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-2" >
                                            <label for="ket_bumi_pdl">Keterangan Bumi</label>
                                          </div>
                                          <div class="col-md-10">
                                              <input class="form-control" type="text" id="ket_bumi_pdl" name="ket_bumi_pdl" autocomplete="off" value="<?php echo $dt['ket_bumi_pdl']?>" style="text-transform: uppercase;" readonly>
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-2" >
                                            <label for="ket_bng_pdl">Keterangan Bangunan</label>
                                          </div>
                                          <div class="col-md-10">
                                              <input class="form-control" type="text" id="ket_bng_pdl" name="ket_bng_pdl" autocomplete="off" value="<?php echo $dt['ket_bng_pdl']?>" style="text-transform: uppercase;" readonly >
                                          </div>
                                        </div>

                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>BERITA ACARA HASIL PENELITIAN</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>BERITA ACARA HASIL PENELITIAN</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-12">
                                            <strong>HASIL PENELITIAN</strong>
                                          </div>
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-12">
                                            1.  PENELITIAN KANTOR
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-2 row_ba" >
                                            <label for="proses_pk">PROSES</label>
                                          </div>
                                          <div class="col-md-4">
                                              <input class="form-control" type="text" id="proses_pk" name="proses_pk" autocomplete="off" value="<?php echo $dt['proses_pk']?>" style="text-transform:uppercase;" >
                                          </div>
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-2 row_ba" >
                                            <label for="analisa_pk">ANALISA</label>
                                          </div>
                                          <div class="col-md-4">
                                              <input class="form-control" type="text" id="analisa_pk" name="analisa_pk" autocomplete="off" value="<?php echo $dt['analisa_pk']?>" style="text-transform: uppercase;" >
                                          </div>
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-2 row_ba" >
                                            <label for="keterangan_pk">KETERANGAN</label>
                                          </div>
                                          <div class="col-md-4">
                                              <input class="form-control" type="text" id="keterangan_pk" name="keterangan_pk" autocomplete="off" value="<?php echo $dt['keterangan_pk']?>" style="text-transform: uppercase;" >
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-12">
                                            2. PENELITIAN LAPANGAN
                                          </div>
                                        </div>

                                        <div class="row" >
                                          <div class="col-md-2 row_ba" >
                                            <label for="proses_pl">PROSES</label>
                                          </div>
                                          <div class="col-md-4">
                                              <input class="form-control" type="text" id="proses_pl" name="proses_pl" autocomplete="off" value="<?php echo $dt['proses_pl']?>" style="text-transform:uppercase;" >
                                          </div>
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-2 row_ba" >
                                            <label for="analisa_pl">ANALISA</label>
                                          </div>
                                          <div class="col-md-4">
                                              <input class="form-control" type="text" id="analisa_pl" name="analisa_pl" autocomplete="off" value="<?php echo $dt['analisa_pl']?>" style="text-transform: uppercase;" >
                                          </div>
                                        </div>
                                        <div class="row" >
                                          <div class="col-md-2 row_ba" >
                                            <label for="keterangan_pl">KETERANGAN</label>
                                          </div>
                                          <div class="col-md-4">
                                              <input class="form-control" type="text" id="keterangan_pl" name="keterangan_pl" autocomplete="off" value="<?php echo $dt['keterangan_pl']?>" style="text-transform: uppercase;" >
                                          </div>
                                        </div>

                                        <?php if ($dt['kd_jns_ply'] == '03' && ($dt['kd_sub_jns_ply'] == '01' || $dt['kd_sub_jns_ply'] == '02')) { ?>
                                        <!-- TITIK KOORDINAT -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>TITIK KOORDINAT</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row" style="margin-bottom:10px;">
                                            <label class="col-md-2 col-form-label">LATITUDE</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" oninput="validKoordinat(this)"
                                                       id="latitude" name="latitude" value="<?php echo @$dt['latitude']; ?>" required>
                                            </div>

                                            <label class="col-md-2 col-form-label">LONGITUDE</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" oninput="validKoordinat(this)"
                                                       id="longitude" name="longitude" value="<?php echo @$dt['longitude']; ?>" required>
                                            </div>

                                            <div class="col-md-2" >
                                                <button type="button" class="btn btn-primary" id="btnPeta">
                                                    <i class="fa fa-map-marker"></i> Lihat Peta
                                                </button>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <div class="row" style="margin-top:40px">
                                          <div class="col-md-12">
                                            <?php if ($this->uri->segment(3) != 'detail') { ?>
                                            <button class="btn btn-success" id="btn_batal" type="submit" disabled>APPROVE KASUBID PENDANIL</button>
                                            <button class="btn btn-danger" id="btn_tolak" type="button" >TOLAK PENDANIL</button>
                                            <button class="btn btn-warning" id="btn_tolak_ply" type="button" >PENELITIAN ULANG</button>
                                            <?php } ?>
                                            <button class="btn btn-info" id="btn_back" type="button">KEMBALI</button>
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

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<!-- MODAL PETA (OpenStreeMaps aja yang gratis wkwkwkk) -->
<div class="modal fade" id="modalPeta" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Pilih Titik Koordinat</h4>
            </div>
            <div class="modal-body">
                <div id="map" style="height:500px;width:100%;"></div>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL PETA -->

<?= $this->load->view('layouts/footer.php'); ?>

<!-- Begin Modal Dialog entry Detail -->
<div id="cuDialogDet" class="modal" style="width:600px" tabindex="-1" role="dialog" aria-labelledby="cuDialogDetLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h3 id="cuDialogDetLabel">Proses Kirim Pelayanan</h3>
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
                      <input class="form-control" type="hidden" name="dtl_id_ppo" id="dtl_id_ppo" readonly />
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
              <button type="button" class="btn btn-primary" id="btn_dtl_simpan">Kirim Data</button>
          </div>
      </div>
  </div>
</div>
<!-- end Modal Dialog entry Detail -->

<!-- MODAL -->
  <div class="modal fade" id="cuDialogDetail" tabindex="-1" role="dialog" aria-labelledby="cuDialogDetailLabel" aria-hidden="true" style="width:900px; left:250px; overflow-y:hidden;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="cuDialogDetailLabel">DATA BANGUNAN</h3>
        </div>
        <div class="modal-body" style="overflow-y: scroll; height: 450px;">
          <div class="row" style="margin-right:0px; margin-left:0px">
            <div class="well" style="padding:10px;min-height:10px; background-color:#5D6385; color:#FFF;">
              <center>
                <font style="font-size:13pt"><strong>DETAIL DATA BANGUNAN</strong></font>
              </center>
            </div> 
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">NO BANGUNAN</label>
              <input class="form-control" type="text" id="dtl_no_bng" name="dtl_no_bng" readonly value="">
              <input class="form-control" type="hidden" id="dtl_model" name="dtl_model">
              <input class="form-control" type="hidden" id="dtl_id" name="dtl_id">
            </div>
            <div class="col-md-6">
              <label for="">JENIS KONSTRUKSI</label>
              <?php echo $select_konstr_bng; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">TAHUN BANGUNAN</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtl_thn_bng" name="dtl_thn_bng" value="">
            </div>
            <div class="col-md-6">
              <label for="">JENIS ATAP</label>
              <?php echo $select_atap_bng; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">TAHUN RENOVASI</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtl_thn_renov" name="dtl_thn_renov" value="">
            </div>
            <div class="col-md-6">
              <label for="">JENIS DINDING</label>
              <?php echo $select_dinding_bng; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">LUAS BANGUNAN</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtl_luas_bng" name="dtl_luas_bng" value="">
            </div>
            <div class="col-md-6">
              <label for="">JENIS LANTAI</label>
              <?php echo $select_jns_lantai; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">JUMLAH LANTAI</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtl_jml_lantai" name="dtl_jml_lantai" value="">
            </div>
            <div class="col-md-6">
              <label for="">JENIS LANGIT-LANGIT</label>
              <?php echo $select_langit; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">KONDISI BANGUNAN</label>
              <?php echo $select_kondisi_bng; ?>
            </div>
            <div class="col-md-6">
              <label for="">PENGGUNAAN BANGUNAN</label>
              <?php echo $select_guna_bng; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-2">
              <label for="">NILAI INDIVIDU BANGUNAN</label>
            </div>
            <div class="col-md-4">
            <input class="form-control" style="height:100% !important;" onkeypress="return hanyaAngka(event)" type="text" id="dtl_nil_individu" name="dtl_nil_individu" value="">
            </div>
          </div>

          <div class="row" id="div_tambahan" style="margin-right:0px; margin-left:0px; display:none">
            <div class="well" style="padding:10px;min-height:10px; background-color:#5D6385; color:#FFF;">
              <center>
                <font style="font-size:13pt"><strong>DATA BANGUNAN TAMBAHAN</strong></font>
              </center>
            </div>
          </div>

          <div class="row" id="div_jpb02" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(PERKANTORAN SWASTA)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb02_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb03" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(PABRIK)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">TINGGI KOLOM (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_tinggi" name="jpb03_tinggi" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DAYA DUKUNG LANTAI Kg/M2</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_daya" name="jpb03_daya" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LEBAR BENTANG (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_lebar" name="jpb03_lebar" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELILING DINDING (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_keliling" name="jpb03_keliling" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">   
              <div class="col-md-6">
                <label for="">LUAS MEZZANINE (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_luas" name="jpb03_luas" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">TIPE KONSTRUKSI</label>
                <?php echo $select_jpb03_kons; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb04" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(TOKO/APOTIK/PASAR/RUKO)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb04_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb05" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(RUMAH SAKIT/KLINIK)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb05_kls_bng; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS KAMAR DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb05_ruang_ac" name="jpb05_ruang_ac" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS RUANG LAIN DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb05_ruang_lain" name="jpb05_ruang_lain" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb06" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(OLAH RAGA/REKREASI)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb06_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb07" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(HOTEL/WISMA)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">JENIS HOTEL</label>
                <?php echo $select_jpb07_jns_hotel; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">JUMLAH BINTANG</label>
                <?php echo $select_jpb07_bintang; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">JUMLAH KAMAR</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb07_jml_kamar" name="jpb07_jml_kamar" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS KAMAR DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb07_ruang_ac" name="jpb07_ruang_ac" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS RUANG LAIN DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb07_ruang_lain" name="jpb07_ruang_lain" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb08" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(BENGKEL/GUDANG/PERTANIAN)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">TINGGI KOLOM (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_tinggi" name="jpb08_tinggi" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DAYA DUKUNG LANTAI (Kg/M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_daya" name="jpb08_daya" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LEBAR BENTANG (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_lebar" name="jpb08_lebar" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELILING DINDING (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_keliling" name="jpb08_keliling" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS MEZZANINE (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_luas" name="jpb08_luas" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">TIPE KONSTRUKSI</label>
                <?php echo $select_jpb08_kons; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb09" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(GEDUNG PEMERINTAH)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb09_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb12" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(BANGUNAN PARKIR)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb12_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb13" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(APARTEMEN)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb13_kls_bng; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">JUMLAH APARTEMEN</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb13_jml_apart" name="jpb13_jml_apart" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS KAMAR DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb13_ruang_ac" name="jpb13_ruang_ac" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS RUANG LAIN DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb13_ruang_lain" name="jpb13_ruang_lain" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb14" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(POMPA BENSIN)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS KANOPI (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb14_luas" name="jpb14_luas" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb15" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(TANGKI MINYAK)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LETAK TANGKI</label>
                <?php echo $select_jpb15_letak_tangki; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KAPASITAS TANGKI</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb15_kapasitas" name="jpb15_kapasitas" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb16" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(GEDUNG SEKOLAH)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb16_kls_bng; ?>
              </div>
            </div>
          </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <?php if ($this->uri->segment(3) == 'edit') : ?>
            <button type="button" class="btn btn-primary" id="btn_save_dtl">Simpan</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- END MODAL -->


  <!-- MODAL FASILITAS -->
  <div class="modal fade" id="cuDialogDetailFas" tabindex="-1" role="dialog" aria-labelledby="cuDialogDetailFasLabel" aria-hidden="true" style="width:900px; left:250px;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="cuDialogDetailLabel">DATA FASILITAS BANGUNAN</h3>
        </div>

        <div class="modal-body">
          <div class="row" style="margin-right:0px; margin-left:0px">
            <div class="well" style="padding:10px;min-height:10px; background-color:#5D6385; color:#FFF;">
              <center>
                <font style="font-size:13pt"><strong>DETAIL DATA FASILITAS BANGUNAN</strong></font>
              </center>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="">
              <table class="table" id="tableKDFas">
                  <thead>
                      <tr>
                          <th>dtl_id</th>
                          <th>dtl_model</th>
                          <th>Nama Fasilitas</th>
                          <th>Jumlah Satuan</th>
                          <th>kd_fas</th>
                          <th>Hapus</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>
          </div>
          <?php if ($this->uri->segment(3) == 'edit') { ?>
          <div class="row" style="margin-right:0px; margin-left:0px">
            <div class="well" style="padding:10px;min-height:10px; background-color:#5D6385; color:#FFF;">
              <center>
                <font style="font-size:13pt"><strong>TAMBAH DATA FASILITAS BANGUNAN</strong></font>
              </center>
            </div>
          </div>

          <div class="row hide" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <input class="form-control" type="hidden" id="dtlfas_id_head" name="dtlfas_id_head">
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-4">
              <label for="">FASILITAS</label>
              <?php echo $select_dtl_fas; ?>
            </div>
            <div class="col-md-4">
              <label for="">SATUAN</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtlfas_satuan" name="dtlfas_satuan" value="">
            </div>
            <div class="col-md-4">
                <label for="">&nbsp;</label>
                <button type="button" class="btn btn-primary" id="btn_save_dtl_fas">Simpan Fasilitas</button>
            </div>
          </div>
          
          <?php } ?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        </div>
      </div>
    </div>
  </div>

  <!-- END MODAL FASILITAS -->

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>


<script>

var oTable;
var oTable2;
let njopBumiClicked = false;
let njopBangunanClicked = false;

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

function reload_grid_detail() {
  oTable.fnReloadAjax("<?php echo active_module_url('permohonan_online_upt/grid_dtl_bng_ol').$dt['rowid'].'?iDisplayLength=50'; ?>");
}

function reload_grid_detail_fasilitas(id_head) {
  oTable2.fnReloadAjax("<?php echo active_module_url('permohonan_online_upt/grid_dtl_fas_ol'); ?>" + id_head);
}

function hanyaAngka(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
}


function f_guna_bng(id){
  var jdl = document.getElementById("div_tambahan");
  var d02 = document.getElementById("div_jpb02");
  var d03 = document.getElementById("div_jpb03");
  var d04 = document.getElementById("div_jpb04");
  var d05 = document.getElementById("div_jpb05");
  var d06 = document.getElementById("div_jpb06");
  var d07 = document.getElementById("div_jpb07");
  var d08 = document.getElementById("div_jpb08");
  var d09 = document.getElementById("div_jpb09");
  var d12 = document.getElementById("div_jpb12");
  var d13 = document.getElementById("div_jpb13");
  var d14 = document.getElementById("div_jpb14");
  var d15 = document.getElementById("div_jpb15");
  var d16 = document.getElementById("div_jpb16");
  if (id == '01' || id == '10' || id == '11' || id == '') {
    jdl.style.display = "none"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '02') {
    jdl.style.display = "block"; d02.style.display = "block"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '03') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "block"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '04') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "block"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '05') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "block"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '06') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "block"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '07') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "block"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '08') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "block"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '09') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "block"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '12') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "block"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '13') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "block"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '14') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "block"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '15') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "block"; d16.style.display = "none";
  } else if (id == '16') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "block";
  }

}

function f_view_detail(id_dob) {
    $.ajax({
      url: '<?php echo active_module_url('permohonan_online_upt'); ?>/get_dtl_bng/' + id_dob,
      async: false,
      success: function (j) {
        var data = $.parseJSON(j);
        // alert(data['NO_BNG']);
        // $("#hit_total_nilai").autoNumeric('set',data['total_nilai']);
        $('#dtl_id').val(id_dob);
        $('#dtl_model').val('edit');
        $('#dtl_no_bng').val(data['NO_BNG']);
        $('#dtl_luas_bng').val(data['LUAS_BNG']);
        $('#dtl_guna_bng').val(data['KD_JPB']);
        $('#dtl_thn_bng').val(data['THN_DIBANGUN_BNG']);
        $('#dtl_thn_renov').val(data['THN_RENOVASI_BNG']);
        $('#dtl_jml_lantai').val(data['JML_LANTAI_BNG']);
        $('#dtl_kondisi_bng').val(data['KONDISI_BNG']);
        $('#dtl_jns_konstr').val(data['JNS_KONSTRUKSI_BNG']);
        $('#dtl_jns_atap').val(data['JNS_ATAP_BNG']);
        $('#dtl_jns_dinding').val(data['KD_DINDING']);
        $('#dtl_jns_lantai').val(data['KD_LANTAI']);
        $('#dtl_jns_langit').val(data['KD_LANGIT_LANGIT']);

        //// CHANGE JPB JPB
        f_guna_bng(data['KD_JPB']);
        
        //// DTL JPB JPB
        $('#jpb02_kls_bng').val(data['KLS_JPB02']);
        $('#jpb03_tinggi').val(data['TING_KOLOM_JPB3']);
        $('#jpb03_daya').val(data['DAYA_DUKUNG_LANTAI_JPB3']);
        $('#jpb03_lebar').val(data['LBR_BENT_JPB3']);
        $('#jpb03_keliling').val(data['KELILING_DINDING_JPB3']);
        $('#jpb03_luas').val(data['LUAS_MEZZANINE_JPB3']);
        $('#jpb03_konstruksi').val(data['TYPE_KONSTRUKSI_JPB3']);
        
        $('#jpb04_kls_bng').val(data['KLS_JPB4']);
        $('#jpb05_kls_bng').val(data['KLS_JPB05']);
        $('#jpb05_ruang_ac').val(data['LUAS_KMR_JPB05_DGN_AC_SENT']);
        $('#jpb05_ruang_lain').val(data['LUAS_RNG_LAIN_JPB5_DGN_AC_SENT']);
        $('#jpb06_kls_bng').val(data['KLS_JPB06']);
        $('#jpb07_jns_hotel').val(data['JNS_JPB7']);
        $('#jpb07_bintang').val(data['BINTANG_JPB7']);
        $('#jpb07_jml_kamar').val(data['JML_KMR_JPB7']);
        $('#jpb07_ruang_ac').val(data['LUAS_KMR_JPB7_DGN_AC_SENT']);
        $('#jpb07_ruang_lain').val(data['LUAS_KMR_LAIN_JPB7_DGN_AC_SENT']);
        
        $('#jpb08_tinggi').val(data['TING_KOLOM_JPB8']);
        $('#jpb08_daya').val(data['DAYA_DUKUNG_LANTAI_JPB8']);
        $('#jpb08_lebar').val(data['LBR_BENT_JPB8']);
        $('#jpb08_keliling').val(data['KELILING_DINDING_JPB8']);
        $('#jpb08_luas').val(data['LUAS_MEZZANINE_JPB8']);
        $('#jpb08_konstruksi').val(data['TYPE_KONSTRUKSI_JPB8']);

        $('#jpb09_kls_bng').val(data['KLS_JPB09']);
        $('#jpb12_kls_bng').val(data['TYPE_JPB12']);
        $('#jpb13_kls_bng').val(data['KLS_JPB13']);
        $('#jpb13_jml_apart').val(data['JML_JPB13']);
        $('#jpb13_ruang_ac').val(data['LUAS_JPB13_DGN_AC_SENT']);
        $('#jpb13_ruang_lain').val(data['LUAS_JPB13_LAIN_DGN_AC_SENT']);
        $('#jpb14_luas').val(data['LUAS_KANOPI_JPB14']);
        $('#jpb15_letak_tangki').val(data['LETAK_TANGKI_JPB15']);
        $('#jpb15_kapasitas').val(data['KAPASITAS_TANGKI_JPB15']);
        $('#jpb16_kls_bng').val(data['KLS_JPB16']);
        

      },
      error: function (xhr, desc, er) {
        alert(er);
      }
    });

    // Buat Judul Entry
    document.getElementById('cuDialogDetailLabel').innerHTML = 'DETAIL DATA BANGUNAN';
    $('#cuDialogDetail').modal('show');
}

function f_edit_detail(id_dob) {
    $.ajax({
      url: '<?php echo active_module_url('permohonan_online_upt'); ?>/get_dtl_bng/' + id_dob,
      async: false,
      success: function (j) {
        var data = $.parseJSON(j);
        // alert(data['NO_BNG']);
        // $("#hit_total_nilai").autoNumeric('set',data['total_nilai']);
        $('#dtl_id').val(id_dob);
        $('#dtl_model').val('edit');
        $('#dtl_no_bng').val(data['NO_BNG']);
        $('#dtl_luas_bng').val(data['LUAS_BNG']);
        $('#dtl_guna_bng').val(data['KD_JPB']);
        $('#dtl_thn_bng').val(data['THN_DIBANGUN_BNG']);
        $('#dtl_thn_renov').val(data['THN_RENOVASI_BNG']);
        $('#dtl_jml_lantai').val(data['JML_LANTAI_BNG']);
        $('#dtl_kondisi_bng').val(data['KONDISI_BNG']);
        $('#dtl_jns_konstr').val(data['JNS_KONSTRUKSI_BNG']);
        $('#dtl_jns_atap').val(data['JNS_ATAP_BNG']);
        $('#dtl_jns_dinding').val(data['KD_DINDING']);
        $('#dtl_jns_lantai').val(data['KD_LANTAI']);
        $('#dtl_jns_langit').val(data['KD_LANGIT_LANGIT']);
        $('#dtl_nil_individu').autoNumeric('set', data['NILAI_INDIVIDU']);

        //// CHANGE JPB JPB
        f_guna_bng(data['KD_JPB']);
        
        //// DTL JPB JPB
        $('#jpb02_kls_bng').val(data['KLS_JPB02']);
        $('#jpb03_tinggi').val(data['TING_KOLOM_JPB3']);
        $('#jpb03_daya').val(data['DAYA_DUKUNG_LANTAI_JPB3']);
        $('#jpb03_lebar').val(data['LBR_BENT_JPB3']);
        $('#jpb03_keliling').val(data['KELILING_DINDING_JPB3']);
        $('#jpb03_luas').val(data['LUAS_MEZZANINE_JPB3']);
        $('#jpb03_konstruksi').val(data['TYPE_KONSTRUKSI_JPB3']);
        
        $('#jpb04_kls_bng').val(data['KLS_JPB4']);
        $('#jpb05_kls_bng').val(data['KLS_JPB05']);
        $('#jpb05_ruang_ac').val(data['LUAS_KMR_JPB05_DGN_AC_SENT']);
        $('#jpb05_ruang_lain').val(data['LUAS_RNG_LAIN_JPB5_DGN_AC_SENT']);
        $('#jpb06_kls_bng').val(data['KLS_JPB06']);
        $('#jpb07_jns_hotel').val(data['JNS_JPB7']);
        $('#jpb07_bintang').val(data['BINTANG_JPB7']);
        $('#jpb07_jml_kamar').val(data['JML_KMR_JPB7']);
        $('#jpb07_ruang_ac').val(data['LUAS_KMR_JPB7_DGN_AC_SENT']);
        $('#jpb07_ruang_lain').val(data['LUAS_KMR_LAIN_JPB7_DGN_AC_SENT']);
        
        $('#jpb08_tinggi').val(data['TING_KOLOM_JPB8']);
        $('#jpb08_daya').val(data['DAYA_DUKUNG_LANTAI_JPB8']);
        $('#jpb08_lebar').val(data['LBR_BENT_JPB8']);
        $('#jpb08_keliling').val(data['KELILING_DINDING_JPB8']);
        $('#jpb08_luas').val(data['LUAS_MEZZANINE_JPB8']);
        $('#jpb08_konstruksi').val(data['TYPE_KONSTRUKSI_JPB8']);

        $('#jpb09_kls_bng').val(data['KLS_JPB09']);
        $('#jpb12_kls_bng').val(data['TYPE_JPB12']);
        $('#jpb13_kls_bng').val(data['KLS_JPB13']);
        $('#jpb13_jml_apart').val(data['JML_JPB13']);
        $('#jpb13_ruang_ac').val(data['LUAS_JPB13_DGN_AC_SENT']);
        $('#jpb13_ruang_lain').val(data['LUAS_JPB13_LAIN_DGN_AC_SENT']);
        $('#jpb14_luas').val(data['LUAS_KANOPI_JPB14']);
        $('#jpb15_letak_tangki').val(data['LETAK_TANGKI_JPB15']);
        $('#jpb15_kapasitas').val(data['KAPASITAS_TANGKI_JPB15']);
        $('#jpb16_kls_bng').val(data['KLS_JPB16']);
        

      },
      error: function (xhr, desc, er) {
        alert(er);
      }
    });

    // Buat Judul Entry
    document.getElementById('cuDialogDetailLabel').innerHTML = 'EDIT DATA BANGUNAN';
    $('#cuDialogDetail').modal('show');
}

function f_hapus_detail(id_dob) {
    var hapus = confirm('Hapus data detail bangunan ini?');
    if (hapus == true) {
        $.ajax({
          url: '<?php echo active_module_url('pdl_pembetulan_kasubid'); ?>delete_dtl_bng/' + id_dob,
          async: false,
          success: function (j) {
            // var data = $.parseJSON(j);
            alert(j);
            reload_grid_detail();
          },
          error: function (xhr, desc, er) {
            alert(er);
          }
        });
    }
}

function f_hapus_detail_fas(id_fas) {
    var hapus = confirm('Hapus data detail fasilitas bangunan ini?');
    if (hapus == true) {
        $.ajax({
          url: '<?php echo active_module_url('pdl_pembetulan_kasubid'); ?>delete_dtl_fas_bng/' + id_fas,
          async: false,
          success: function (j) {
            // var data = $.parseJSON(j);
            alert(j);
            var id_dob = $('#dtlfas_id_head').val();
            reload_grid_detail_fasilitas(id_dob);
          },
          error: function (xhr, desc, er) {
            alert(er);
          }
        });
    }
}


function f_fas_detail(id_dob) {
    $('#cuDialogDetailFas').modal('show');
    $('#dtlfas_id_head').val(id_dob);
    reload_grid_detail_fasilitas(id_dob);
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

  ///// DETAIL UNTUK NOP
  /***begin group detil **********************************************************************************/

  oTable = $('#tableKD').dataTable({
    "iDisplayLength": 9,
    "bJQueryUI": true,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"toolbar">frtip',
    "aaSorting": [[ 0, "asc" ]],
    "aoColumnDefs": [
        { "aTargets": [0], "bSearchable": false, "bVisible": false },
        { "aTargets": [1], "bSearchable": false, "bVisible": false },
        { "aTargets": [2], "bSearchable": true,  "bVisible": true, "sWidth": "50px" },
        { "aTargets": [3], "bSearchable": true,  "bVisible": true, "sWidth": "350px", "sClass": "" },
        { "aTargets": [4], "bSearchable": true,  "bVisible": true, "sWidth": "100px", "sClass": "right" },
        { "aTargets": [5], "bSearchable": false,  "bVisible": false, "sWidth": "100px", "sClass": "right" },
        { "aTargets": [6], "bSearchable": true,  "bVisible": true, "sWidth": "100px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                <?php if($this->uri->segment(3) == 'edit') { ?>
                  return '<button class="btn btn-success" type="button" onclick="f_edit_detail('+val[0]+')" >Ubah</button>';
                <?php } else { ?>
                  return '<button class="btn btn-success" type="button" onclick="f_view_detail('+val[0]+')" >Detail</button>';
                <?php } ?>
            }
        },
        { "aTargets": [7], "bSearchable": true,  "bVisible": <?php echo $this->uri->segment(3) == 'edit' ? 'true' : 'false' ; ?>, "sWidth": "100px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                <?php if($this->uri->segment(3) == 'edit') { ?>
                  return '<button class="btn btn-danger" type="button" onclick="f_hapus_detail('+val[0]+')" >Hapus</button>';
                <?php } else { ?> 
                  return '';
                <?php } ?>
            }
        },
        { "aTargets": [8], "bSearchable": true,  "bVisible": true, "sWidth": "180px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                return '<button class="btn btn-warning" type="button" onclick="f_fas_detail('+val[0]+')" >Detail Fasilitas</button>';
            }
        },
    ],
    "sAjaxSource": "<?php echo active_module_url('permohonan_online_upt/grid_dtl_bng_ol').$dt['rowid'].'?iDisplayLength=50';?>"
  });

  $('#btn_tambah_detail').click(function() {
      // Buat Judul Entry
      document.getElementById('cuDialogDetailLabel').innerHTML ='TAMBAH DATA BANGUNAN';
      //
      // jenis_bayar = jns_byr;
      mode_input_detail = "add";
      // initial data awal blank
      var random_id = Date.now();
      $('#dtl_id').val('');
      $('#dtl_model').val('add');
      $('#dtl_no_bng').val('');
      $('#dtl_luas_bng').val('');
      $('#dtl_guna_bng').val('');
      $('#dtl_thn_bng').val('');
      $('#dtl_thn_renov').val('');
      $('#dtl_jml_lantai').val('');
      $('#dtl_kondisi_bng').val('');
      $('#dtl_jns_konstr').val('');
      $('#dtl_jns_atap').val('');
      $('#dtl_jns_dinding').val('');
      $('#dtl_jns_lantai').val('');
      $('#dtl_jns_langit').val('');
      $('#dtl_nil_individu').val('');

      f_guna_bng('');

      //// dtl jpb
      $('#jpb02_kls_bng').val('');
      $('#jpb03_tinggi').val('');
      $('#jpb03_daya').val('');
      $('#jpb03_lebar').val('');
      $('#jpb03_keliling').val('');
      $('#jpb03_luas').val('');
      $('#jpb03_konstruksi').val('');
      $('#jpb04_kls_bng').val('');
      $('#jpb05_kls_bng').val('');
      $('#jpb05_ruang_ac').val('');
      $('#jpb05_ruang_lain').val('');
      $('#jpb06_kls_bng').val('');
      $('#jpb07_jns_hotel').val('');
      $('#jpb07_bintang').val('');
      $('#jpb07_jml_kamar').val('');
      $('#jpb07_ruang_ac').val('');
      $('#jpb07_ruang_lain').val('');
      $('#jpb08_tinggi').val('');
      $('#jpb08_daya').val('');
      $('#jpb08_lebar').val('');
      $('#jpb08_keliling').val('');
      $('#jpb08_luas').val('');
      $('#jpb08_konstruksi').val('');
      $('#jpb09_kls_bng').val('');
      $('#jpb12_kls_bng').val('');
      $('#jpb13_kls_bng').val('');
      $('#jpb13_jml_apart').val('');
      $('#jpb13_ruang_ac').val('');
      $('#jpb13_ruang_lain').val('');
      $('#jpb14_luas').val('');
      $('#jpb15_letak_tangki').val('');
      $('#jpb15_kapasitas').val('');
      $('#jpb16_kls_bng').val('');


      //document.getElementById('satuan').innerHTML='';
      $('#cuDialogDetail').modal('show');
  });


  $('#btn_save_dtl').click(function(e) {
    e.preventDefault();
    var id_ppo            = $('#id_ppo').val();
    var id_dop            = $('#id_mut_dop').val();
    var urut_mutasi       = $('#urut_mutasi').val();
    var paramm            = $('#paramm').val();
    var dtl_id            = $('#dtl_id').val();

    var dtl_model         = $('#dtl_model').val();
    var dtl_no_bng        = $('#dtl_no_bng').val();
    var dtl_luas_bng      = $('#dtl_luas_bng').val();
    var dtl_guna_bng      = $('#dtl_guna_bng').val();
    var dtl_thn_bng       = $('#dtl_thn_bng').val();
    var dtl_thn_renov     = $('#dtl_thn_renov').val();
    var dtl_jml_lantai    = $('#dtl_jml_lantai').val();
    var dtl_kondisi_bng   = $('#dtl_kondisi_bng').val();
    var dtl_jns_konstr    = $('#dtl_jns_konstr').val();
    var dtl_jns_atap      = $('#dtl_jns_atap').val();
    var dtl_jns_dinding   = $('#dtl_jns_dinding').val();
    var dtl_jns_lantai    = $('#dtl_jns_lantai').val();
    var dtl_jns_langit    = $('#dtl_jns_langit').val();
    var dtl_nil_individu  = $('#dtl_nil_individu').val();

    //// dtl jpb
    var jpb02_kls_bng     = $('#jpb02_kls_bng').val();
    var jpb03_tinggi      = $('#jpb03_tinggi').val();
    var jpb03_daya        = $('#jpb03_daya').val();
    var jpb03_lebar       = $('#jpb03_lebar').val();
    var jpb03_keliling    = $('#jpb03_keliling').val();
    var jpb03_luas        = $('#jpb03_luas').val();
    var jpb03_konstruksi  = $('#jpb03_konstruksi').val();
    var jpb04_kls_bng     = $('#jpb04_kls_bng').val();
    var jpb05_kls_bng     = $('#jpb05_kls_bng').val();
    var jpb05_ruang_ac    = $('#jpb05_ruang_ac').val();
    var jpb05_ruang_lain  = $('#jpb05_ruang_lain').val();
    var jpb06_kls_bng     = $('#jpb06_kls_bng').val();
    var jpb07_jns_hotel   = $('#jpb07_jns_hotel').val();
    var jpb07_bintang     = $('#jpb07_bintang').val();
    var jpb07_jml_kamar   = $('#jpb07_jml_kamar').val();
    var jpb07_ruang_ac    = $('#jpb07_ruang_ac').val();
    var jpb07_ruang_lain  = $('#jpb07_ruang_lain').val();
    var jpb08_tinggi      = $('#jpb08_tinggi').val();
    var jpb08_daya        = $('#jpb08_daya').val();
    var jpb08_lebar       = $('#jpb08_lebar').val();
    var jpb08_keliling    = $('#jpb08_keliling').val();
    var jpb08_luas        = $('#jpb08_luas').val();
    var jpb08_konstruksi  = $('#jpb08_konstruksi').val();
    var jpb09_kls_bng     = $('#jpb09_kls_bng').val();
    var jpb12_kls_bng     = $('#jpb12_kls_bng').val();
    var jpb13_kls_bng     = $('#jpb13_kls_bng').val();
    var jpb13_jml_apart   = $('#jpb13_jml_apart').val();
    var jpb13_ruang_ac    = $('#jpb13_ruang_ac').val();
    var jpb13_ruang_lain  = $('#jpb13_ruang_lain').val();
    var jpb14_luas        = $('#jpb14_luas').val();
    var jpb15_letak_tangki= $('#jpb15_letak_tangki').val();
    var jpb15_kapasitas   = $('#jpb15_kapasitas').val();
    var jpb16_kls_bng     = $('#jpb16_kls_bng').val();

    if(dtl_thn_bng == ''){
      alert('Tahun Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == ''){
      alert('Penggunaan Bangunan Harap diisi...'); return false;
    }
    if(dtl_kondisi_bng == ''){
      alert('Kondisi Bangunan Harap diisi...'); return false;
    }

    if(dtl_luas_bng == '' || dtl_jml_lantai == '' || dtl_jns_konstr == '' || dtl_jns_atap == '' || dtl_jns_dinding == '' 
    || dtl_jns_lantai == '' || dtl_jns_langit == '' ){
      alert('Harap isi semua data dengan benar...'); return false;
    }

    if(dtl_guna_bng == '03' && (jpb03_lebar == '' || jpb03_tinggi == '' || jpb03_daya == '')){
      alert('JPB03 - Tinggi Lebar dan Daya Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '04' && jpb04_kls_bng == ''){
      alert('JPB04 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '05' && jpb05_kls_bng == ''){
      alert('JPB05 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '06' && jpb06_kls_bng == ''){
      alert('JPB06 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '07' && (jpb07_jns_hotel == '' || jpb07_bintang == '' || jpb07_jml_kamar == '')){
      alert('JPB07 - Jenis Hotel, Bintang dan Jumlah Kamar Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '08' && (jpb08_lebar == '' || jpb08_tinggi == '' || jpb08_daya == '')){
      alert('JPB08 - Tinggi Lebar dan Daya Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '09' && jpb09_kls_bng == ''){
      alert('JPB09 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '12' && jpb12_kls_bng == ''){
      alert('JPB12 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '13' && jpb13_kls_bng == ''){
      alert('JPB13 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '14' && jpb14_luas == ''){
      alert('JPB14 - Luas Kanopi Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '15' && (jpb15_letak_tangki == '' || jpb15_kapasitas == '')){
      alert('JPB15 - Letak dan Kapasitas Tangki Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '16' && jpb16_kls_bng == ''){
      alert('JPB16 - Kelas Bangunan Harap diisi...'); return false;
    }

    $.ajax({
        url: '<?php echo active_module_url('permohonan_online_upt'); ?>/save_dtl_bangunan/',
        type: "POST",    
        data: {
          id_ppo: id_ppo,
          id_dop: id_dop,
          urut_mutasi: urut_mutasi,
          paramm: paramm,
          dtl_id: dtl_id,
          dtl_model: dtl_model,
          dtl_no_bng: dtl_no_bng,
          dtl_luas_bng: dtl_luas_bng,
          dtl_guna_bng: dtl_guna_bng,
          dtl_thn_bng: dtl_thn_bng,
          dtl_thn_renov: dtl_thn_renov,
          dtl_jml_lantai: dtl_jml_lantai,
          dtl_kondisi_bng: dtl_kondisi_bng,
          dtl_jns_konstr: dtl_jns_konstr,
          dtl_jns_atap: dtl_jns_atap,
          dtl_jns_dinding: dtl_jns_dinding,
          dtl_jns_lantai: dtl_jns_lantai,
          dtl_jns_langit: dtl_jns_langit,
          dtl_nil_individu: dtl_nil_individu,
          jpb02_kls_bng: jpb02_kls_bng,
          jpb03_tinggi: jpb03_tinggi,
          jpb03_daya: jpb03_daya,
          jpb03_lebar: jpb03_lebar,
          jpb03_keliling: jpb03_keliling,
          jpb03_luas: jpb03_luas,
          jpb03_konstruksi: jpb03_konstruksi,
          jpb04_kls_bng: jpb04_kls_bng,
          jpb05_kls_bng: jpb05_kls_bng,
          jpb05_ruang_ac: jpb05_ruang_ac,
          jpb05_ruang_lain: jpb05_ruang_lain,
          jpb06_kls_bng: jpb06_kls_bng,
          jpb07_jns_hotel: jpb07_jns_hotel,
          jpb07_bintang: jpb07_bintang,
          jpb07_jml_kamar: jpb07_jml_kamar,
          jpb07_ruang_ac: jpb07_ruang_ac,
          jpb07_ruang_lain: jpb07_ruang_lain,
          jpb08_tinggi: jpb08_tinggi,
          jpb08_daya: jpb08_daya,
          jpb08_lebar: jpb08_lebar,
          jpb08_keliling: jpb08_keliling,
          jpb08_luas: jpb08_luas,
          jpb08_konstruksi: jpb08_konstruksi,
          jpb09_kls_bng: jpb09_kls_bng,
          jpb12_kls_bng: jpb12_kls_bng,
          jpb13_kls_bng: jpb13_kls_bng,
          jpb13_jml_apart: jpb13_jml_apart,
          jpb13_ruang_ac: jpb13_ruang_ac,
          jpb13_ruang_lain: jpb13_ruang_lain,
          jpb14_luas: jpb14_luas,
          jpb15_letak_tangki: jpb15_letak_tangki,
          jpb15_kapasitas: jpb15_kapasitas,
          jpb16_kls_bng: jpb16_kls_bng,
        },
        success: function(response) {
            alert(response);
            $('#cuDialogDetail').modal('hide');
            reload_grid_detail();

        },
        error: function() {
            alert("error");
        }    
    });    
  });

  /////// dtl table fasilitas
  oTable2 = $('#tableKDFas').dataTable({
    "iDisplayLength": 9,
    "bJQueryUI": true,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"toolbar">frtip',
    "aaSorting": [[ 0, "asc" ]],
    "aoColumnDefs": [
        { "aTargets": [0], "bSearchable": false, "bVisible": false },
        { "aTargets": [1], "bSearchable": false, "bVisible": false },
        { "aTargets": [2], "bSearchable": true,  "bVisible": true, "sWidth": "" },
        { "aTargets": [3], "bSearchable": true,  "bVisible": true, "sWidth": "", "sClass": "" },
        { "aTargets": [4], "bSearchable": false,  "bVisible": false, "sWidth": "100px", "sClass": "right" },
        { "aTargets": [5], "bSearchable": true,  "bVisible": <?php echo $this->uri->segment(3) == 'edit' ? 'true' : 'false' ; ?>, "sWidth": "100px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
              <?php if ($this->uri->segment(3) == 'edit') { ?>
                return '<button class="btn btn-danger" type="button" onclick="f_hapus_detail_fas('+val[0]+')" >Hapus</button>';
              <?php } else { ?>
                return '';
              <?php } ?>
            }
        },
    ],
  });

  $('#btn_save_dtl_fas').click(function(e) {
    e.preventDefault();
    var id_ppo            = $('#id_ppo').val();
    var paramm            = $('#paramm').val();
    var id_head           = $('#dtlfas_id_head').val();
    var dtlfas_kd_fas     = $('#dtlfas_kd_fasilitas').val();
    var dtlfas_satuan     = $('#dtlfas_satuan').val();

    $.ajax({
        url: '<?php echo active_module_url('permohonan_online_upt'); ?>/save_dtl_fasilitas_bangunan/',
        type: "POST",    
        data: {
          id_ppo: id_ppo,
          paramm: paramm,
          id_head: id_head,
          dtlfas_kd_fas: dtlfas_kd_fas,
          dtlfas_satuan: dtlfas_satuan,
        },
        success: function(response) {
            alert(response);
            // $('#cuDialogDetailFas').modal('hide');
            reload_grid_detail_fasilitas(id_head);
            $('#dtlfas_kd_fasilitas').val('');
            $('#dtlfas_satuan').val('');

        },
        error: function() {
            alert("error");
        }    
    });    
  });

  $("#cuDialogDetail").draggable({
    handle: ".modal-header"
  });

  $("#cuDialogDetailFas").draggable({
    handle: ".modal-header"
  });
  /***end group detil   **********************************************************************************/

  //// END DTL NOP


  //// init
  var id_lamp = $('#jns_ply').val();
  var id_sub_lamp = $('#sub_jns_ply').val();
  f_chg_lamp(id_lamp, id_sub_lamp);

  $('#nop_re').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });

  $('#nop').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });
  
  $('#myform').on('submit', function(e) {
      e.preventDefault(); // cegah submit normal

      var form = this;

      // HTML5 validation
      if (!form.checkValidity()) {
          form.reportValidity();
          return;
      }

      var thn_awal  = $('#tahun_awal').val().trim();
      var thn_akhir = $('#tahun_akhir').val().trim();

      // validasi: wajib + 4 digit angka
      var regexTahun = /^[0-9]{4}$/;

      if (!regexTahun.test(thn_awal) || !regexTahun.test(thn_akhir)) {
          Swal.fire({
              icon: 'warning',
              title: 'Validasi',
              text: 'Tahun Awal dan Tahun Akhir harus berupa angka 4 digit'
          });
          return;
      }

      if (parseInt(thn_awal) > parseInt(thn_akhir)) {
          Swal.fire({
              icon: 'warning',
              title: 'Validasi',
              text: 'Tahun Awal tidak boleh lebih besar dari Tahun Akhir'
          });
          return;
      }

      // // ================= VALIDASI RADIO SYARAT =================
      // var belumDipilih = [];
      // var ids = [];

      // $('input[type=radio][name^="status"]').each(function () {
      //     var name = $(this).attr('name'); // status[ID]
      //     var id = name.match(/\[(\d+)\]/)[1];
      //     if (!ids.includes(id)) {
      //         ids.push(id);
      //     }
      // });

      // ids.forEach(function (id) {
      //     if (!$('input[name="status[' + id + ']"]:checked').length) {
      //         belumDipilih.push(id);
      //     }
      // });

      // if (belumDipilih.length > 0) {
      //     Swal.fire({
      //         icon: 'warning',
      //         title: 'Validasi',
      //         text: 'Masih ada persyaratan yang belum dipilih (YA / TIDAK)'
      //     });
      //     return;
      // }
      // // =========================================================


      var data = new FormData(form);

      $("#overlay").fadeIn(300);

      $.ajax({
          url: "<?php echo active_module_url() ?>pdl_pembetulan_kasubid/approve_permohonan/",
          type: 'POST',
          data: data,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(res) {

              if (res.result == 302) {
                  window.location.href = res.redirect;
                  return;
              }

              if (res.result == 400) {
                  Swal.fire({
                      icon: "error",
                      title: "Error",
                      text: res.msg
                  });
              } else {
                  Swal.fire({
                      icon: "success",
                      title: "Sukses",
                      text: res.msg,
                      timer: 2000,
                      showConfirmButton: false
                  }).then(() => {
                      window.location = '<?php echo active_module_url("pdl_pembetulan_kasubid"); ?>';
                  });
              }
          },
          complete: function () {
              $("#overlay").fadeOut(300);
          },
          error: function(xhr) {
              Swal.fire('Error', xhr.responseText, 'error');
          }
      });
  });

  $('#btn_tolak').on('click', function() {
    var form = document.getElementById("myform");
    // Check HTML5 required
    if (!form.checkValidity()) {
        form.reportValidity();
        return false;
    }

    // Swal Confirm dulu
    Swal.fire({
        title: 'Tolak Data Permohonan ini?',
        text: "Permohonan yang sudah ditolak tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

        // jika user klik confirm
        if (result.isConfirmed) {

            var data = new FormData(form);

            $("#overlay").fadeIn(300);


            $.ajax({
                url: "<?php echo active_module_url() ?>pdl_pembetulan_kasubid/tolak_permohonan/",
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {

                    if (res.result == 302) {
                        window.location.href = res.redirect;
                        return;
                    }

                    if (res.result == 400) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.msg
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Sukses",
                            text: res.msg,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location = '<?php echo active_module_url("pdl_pembetulan_kasubid"); ?>';
                        });
                    }
                },
                complete: function () {
                    $("#overlay").fadeOut(300);
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseText, 'error');
                }
            });
        }
    });

  });


  $('#btn_back').on('click', function() {
      window.location = '<?php echo active_module_url("pdl_pembetulan_kasubid"); ?>';
  });

  $('#btn_save_dsp').click(function() {
      var id_ppo        = $('#id_ppo').val();
      var ktp_wp        = $('#nik_wp_sppt').val();
      var nama_wp       = $('#nm_wp_sppt').val();
      var jalan_wp      = $('#jln_wp_sppt').val();
      var blok_wp       = $('#blok_kav_no_wp_sppt').val();
      var rt_wp         = $('#rt_wp_sppt').val();
      var rw_wp         = $('#rw_wp_sppt').val();
      var kelurahan_wp  = $('#kelurahan_wp_sppt').val();
      var kota_wp       = $('#kota_wp_sppt').val();
      var kodepos_wp    = $('#kd_pos_wp_sppt').val();
      var hp_wp         = $('#nohp').val();
      var pekerjaan_wp  = $('#pekerjaan_wp').val();
      var email_wp      = $('#email_wp_sppt').val();
      var kd_sts_op     = $('#sts_op').val();
      // var np_wp         = $('#np_wp').val();
      // alert(ktp_wp);

      if(ktp_wp == ''){
          alert('NIK Harap diisi...');
          return false;
      }

      $.ajax({
          url: '<?php echo active_module_url(); ?>/pdl_pembetulan_kasubid/save_data_subjek_pajak/',
          type: "POST",    
          data: {
            id_ppo: id_ppo,
            ktp_wp: ktp_wp,
            nama_wp: nama_wp,
            jalan_wp: jalan_wp,
            blok_wp: blok_wp,
            rt_wp: rt_wp,
            rw_wp: rw_wp,
            kelurahan_wp: kelurahan_wp,
            kota_wp: kota_wp,
            kodepos_wp: kodepos_wp,
            hp_wp: hp_wp,
            // np_wp: np_wp,
            pekerjaan_wp: pekerjaan_wp,
            email_wp: email_wp,
            kd_sts_op: kd_sts_op,
          },
          success: function(response) {
            alert(response);

          },
          error: function() {
              alert("error");
          }    
      });    

  });

  $('#btn_save_dop').click(function() {
      var id_ppo        = $('#id_ppo').val();
      var ktp_wp        = $('#nik_wp_sppt').val();
      var jalan_op      = $('#jln_op_sppt').val();
      var blok_op       = $('#blok_kav_no_op_sppt').val();
      var rt_op         = $('#rt_op_sppt').val();
      var rw_op         = $('#rw_op_sppt').val();
      var jns_tanah_op  = $('#jns_tanah_op').val();
      var luas_bumi     = $('#luas_tanah').val();
      var kd_znt_op     = $('#kd_znt_op').val();

      // alert(luas_bumi);

      $.ajax({
          url: '<?php echo active_module_url(); ?>/pdl_pembetulan_kasubid/save_data_objek_pajak/',
          type: "POST",    
          data: {
            id_ppo: id_ppo,
            ktp_wp: ktp_wp,
            jalan_op: jalan_op,
            blok_op: blok_op,
            rt_op: rt_op,
            rw_op: rw_op,
            jns_tanah_op: jns_tanah_op,
            luas_bumi: luas_bumi,
            kd_znt_op: kd_znt_op,
          },
          success: function(response) {
              alert(response);

          },
          error: function() {
              alert("error");
          }    
      });    

  });

  $('#btn_hitung_njop_bng').click(function(e) {
    e.preventDefault();
    njopBangunanClicked = true;
    enableSimpanButton();
    var id_ppo            = $('#id_ppo').val();
    var paramm            = $('#nop_t').val();
    var thn_ply           = $('#thn_permohonan').val();

    $.ajax({
        url: '<?php echo active_module_url(); ?>/pdl_pembetulan_kasubid/hitung_njop_bng/',
        type: "POST",    
        data: {
          id_ppo: id_ppo,
          paramm: paramm,
          thn_ply: thn_ply,
        },
        success: function(response) {
            var data = $.parseJSON(response);

            $('#njop_bng_perm_op').autoNumeric('set', data['NJOP_BNG_PERM']);
            $('#njop_bng_op').autoNumeric('set', data['NJOP_BNG']);

            Toast.fire({
                  icon: 'success',
                  title: 'Hitung NJOP Bangunan Berhasil.'
              });

        },
        error: function() {
            alert("error");
        }    
    });    

  });

  $('#btn_hitung_njop_bumi').click(function(e) {
      e.preventDefault();
      njopBumiClicked = true;
      enableSimpanButton();
      var id_ppo            = $('#id_ppo').val();
      var luas_bumi         = $('#luas_bumi').val();
      var jns_bumi          = $('#jns_tanah_op').val();
      var kd_znt            = $('#kd_znt_op').val();
      var paramm            = $('#nop_t').val();
      var thn_ply           = $('#thn_permohonan').val();

      $.ajax({
          url: '<?php echo active_module_url(); ?>/pdl_pembetulan_kasubid/hitung_njop_bumi/',
          type: "POST",    
          data: {
            id_ppo: id_ppo,
            luas_bumi: luas_bumi,
            jns_bumi: jns_bumi,
            kd_znt: kd_znt,
            paramm: paramm,
            thn_ply: thn_ply,
          },
          success: function(response) {
              var data = $.parseJSON(response);

              // alert(data['balikan_sp']);

              // $('#njop_bumi_perm_op').val(data['NJOP_BUMI_PERM']);
              // $('#njop_bumi_op').val(data['NJOP_BUMI']);

              $('#njop_bumi_perm_op').autoNumeric('set', data['NJOP_BUMI_PERM']);
              $('#njop_bumi_op').autoNumeric('set', data['NJOP_BUMI']);

              Toast.fire({
                  icon: 'success',
                  title: 'Hitung NJOP Bumi Berhasil.'
              });

          },
          error: function() {
              alert("error");
          }    
      });    

    });

  $('#njop_bumi_perm_op, #njop_bumi_op, #njop_bng_perm_op, #njop_bng_op, #dtl_nil_individu').autoNumeric('init', {
      aSep: '.', aDec: ',', vMax: '999999999999999',  mDec: '0'
  });

  // var tg_sk_dtp = $('#tgl_sk').datepicker({
  //     format: 'dd-mm-yyyy'
  // }).on('changeDate', function(ev) {
  //     tg_sk_dtp.hide();
  // }).data('datepicker');

  var tg_bap_dtp = $('#tgl_bap').datepicker({
      format: 'dd-mm-yyyy'
  }).on('changeDate', function(ev) {
    tg_bap_dtp.hide();
  }).data('datepicker');

  // Fungsi untuk enable button SIMPAN jika kedua tombol sudah diklik
  function enableSimpanButton() {
    if (njopBumiClicked && njopBangunanClicked) {
      $('#btn_batal').prop('disabled', false); // Enable tombol SIMPAN
    }
  }


  // // OVERLAY SPINNER 
  $(document).on({
      ajaxStart: function(){
          $("#overlay").fadeIn(300);　
      },
      ajaxStop: function(){ 
          $("#overlay").fadeOut(300);　
      }    
  });

  $('#btn_tolak_ply').on('click', function () {

      Swal.fire({
          title: 'Tolak Berkas?',
          text: 'Tolak Berkas ini dan kembalikan ke Verifikasi Pendanil?',
          icon: 'warning',
          input: 'textarea',
          inputLabel: 'Keterangan Penolakan',
          inputPlaceholder: 'Masukkan alasan penolakan...',
          inputAttributes: {
              maxlength: 500
          },
          showCancelButton: true,
          confirmButtonText: 'Tolak',
          cancelButtonText: 'Batal',
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          reverseButtons: true,
          preConfirm: (ket_tolak_ply) => {

              if (!ket_tolak_ply || ket_tolak_ply.trim() === '') {
                  Swal.showValidationMessage('Keterangan penolakan wajib diisi');
                  return false;
              }

              var id_ppo        = $('#id_ppo').val();

              return $.ajax({
                  url: '<?php echo active_module_url() ?>pdl_pembetulan_kasubid/tolak_ke_pelayanan/',
                  type: 'POST',
                  dataType: 'text',
                  data: {
                      id_ppo: id_ppo,
                      ket_tolak_ply: ket_tolak_ply
                  }
              }).fail(function(xhr) {
                  Swal.showValidationMessage(
                      'Terjadi kesalahan saat mengirim data'
                  );
              });
          }

      }).then((result) => {
          if (result.isConfirmed) {
              Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: result.value,
                  timer: 2000,
                  showConfirmButton: false
              }).then(() => {
                  window.location = '<?php echo active_module_url("pdl_pembetulan_kasubid"); ?>';
              });
          }
      });

  });

  // Titik tengah Kabupaten Bogor (Cibinong)
  const DEFAULT_LAT = -6.485213;
  const DEFAULT_LNG = 106.854232;
  const DEFAULT_ZOOM = 12;
  const DETAIL_ZOOM = 18;

  let map = null;
  let marker = null;

  $('#btnPeta').on('click', function () {

      var lat = parseFloat($('#latitude').val().trim().replace(',', '.'));
      var lng = parseFloat($('#longitude').val().trim().replace(',', '.'));

      var adaKoordinat = !isNaN(lat) && !isNaN(lng);

      if (!adaKoordinat) {
          lat = DEFAULT_LAT;
          lng = DEFAULT_LNG;
      }

      $('#modalPeta').modal('show');

      setTimeout(function () {

          // ===================
          // Pertama kali
          // ===================
          if (map == null) {

              map = L.map('map').setView(
                  [lat, lng],
                  adaKoordinat ? DETAIL_ZOOM : DEFAULT_ZOOM
              );

              L.tileLayer(
                  'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                  {
                      attribution: '&copy; OpenStreetMap'
                  }
              ).addTo(map);

              L.Control.geocoder({
                  defaultMarkGeocode: false
              }).on('markgeocode', function(e){

                  map.fitBounds(e.geocode.bbox);

              }).addTo(map);

          }

          map.invalidateSize();

          console.log("Latitude :", lat);
          console.log("Longitude:", lng);

          map.setView(
              [lat,lng],
              adaKoordinat ? DETAIL_ZOOM : DEFAULT_ZOOM
          );

          // ===================
          // Marker
          // ===================
          if(adaKoordinat){

              if(marker == null){

                  marker = L.marker(
                      [lat,lng],
                      {
                          draggable:false
                      }
                  ).addTo(map);

              }else{

                  marker.setLatLng([lat,lng]);

              }

          }else{

              if(marker != null){

                  map.removeLayer(marker);
                  marker = null;

              }

          }

      },300);

  });

});

</script>