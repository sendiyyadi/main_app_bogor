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
/* END SPINNER */

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">PERMOHONAN ONLINE UPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Permohonan Online UPT</li>
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
                                                  <a target="_blank" href="<?php echo active_module_url().'monitoring_permohonan_online_upt/openblob_reg_esppt/IM_KTP_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File KTP"></i> Lihat File</a>
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
                                                  <a target="_blank" href="<?php echo active_module_url().'monitoring_permohonan_online_upt/openblob_reg_esppt/IM_SPPT_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File SPPT"></i> Lihat File</a>
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
                                                  <a target="_blank" href="<?php echo active_module_url().'monitoring_permohonan_online_upt/openblob_reg_esppt/IM_PBB_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File STTS"></i> Lihat File</a>
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
                                            <center><font style="font-size:13pt"><strong>DATA WAJIB PAJAK / SUBJEK PAJAK</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="nik_wp_sppt">NIK</label><br>
                                            <input class="form-control" type="text" id="nik_wp_sppt" name="nik_wp_sppt" maxlength="16" autocomplete="off" value="<?php echo $dt['nik_wp_sppt']?>" readonly >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="nm_wp_sppt">NAMA LENGKAP</label><br>
                                            <input class="form-control" type="text" id="nm_wp_sppt" name="nm_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['nm_wp_sppt']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-9">
                                            <label for="jln_wp_sppt">ALAMAT LENGKAP</label><br>
                                            <input class="form-control"  type="text" id="jln_wp_sppt" name="jln_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['jln_wp_sppt']?>" readonly >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="blok_kav_no_wp_sppt">BLOK / NO</label><br>
                                            <input class="form-control"  type="text" id="blok_kav_no_wp_sppt" name="blok_kav_no_wp_sppt" maxlength="15" autocomplete="off" value="<?php echo $dt['blok_kav_no_wp_sppt']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-3">
                                            <label for="rt_wp_sppt">RT</label><br>
                                            <input class="form-control" type="text" id="rt_wp_sppt" name="rt_wp_sppt" autocomplete="off" maxlength="3" value="<?php echo $dt['rt_wp_sppt']?>" readonly >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="rw_wp_sppt">RW</label><br>
                                            <input class="form-control" type="text" id="rw_wp_sppt" name="rw_wp_sppt" autocomplete="off" maxlength="2" value="<?php echo $dt['rw_wp_sppt']?>" readonly >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="kelurahan_wp_sppt">KELURAHAN</label><br>
                                            <input class="form-control" type="text" id="kelurahan_wp_sppt" name="kelurahan_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['kelurahan_wp_sppt']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="kota_wp_sppt">KABUPATEN / KOTA</label><br>
                                            <input class="form-control" type="text" id="kota_wp_sppt" name="kota_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['kota_wp_sppt']?>" readonly >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="kd_pos_wp_sppt">KODE POS</label><br>
                                            <input class="form-control" type="text" id="kd_pos_wp_sppt" name="kd_pos_wp_sppt" maxlength="5" autocomplete="off" value="<?php echo $dt['kd_pos_wp_sppt']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="nohp">NO HP (AKTIF)</label><br>
                                            <input class="form-control" type="text" id="nohp" name="nohp" maxlength="15" autocomplete="off" value="<?php echo $dt['nohp']?>" readonly >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="email_wp_sppt">ALAMAT EMAIL</label><br>
                                            <input class="form-control" type="text" id="email_wp_sppt" name="email_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['email_wp_sppt']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6">
                                            <label for="">STATUS OBJEK PAJAK</label><br>
                                            <?php echo $select_sts_op; ?>
                                            <!-- <input class="form-control" type="text" id="sts_objek_pajak" name="sts_objek_pajak" maxlength="15" autocomplete="off" value="<?php //echo $dt['sts_objek_pajak']?>" readonly > -->
                                          </div>
                                          <div class="col-md-6">
                                            <label for="">PEKERJAAN</label><br>
                                            <?php echo $select_pekerjaan_wp; ?>
                                            <!-- <input class="form-control" type="text" id="pekerjaan_wp" name="pekerjaan_wp" maxlength="30" autocomplete="off" value="<?php //echo $dt['pekerjaan_wp']?>" readonly > -->
                                          </div>
                                        </div>


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
                                          <div class="col-md-6">
                                            <label for="">Luas Tanah</label><br>
                                            <input class="form-control" type="text" id="luas_tanah" name="luas_tanah" autocomplete="off" value="<?php echo $dt['luas_tanah']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-9">
                                            <label for="jln_op_sppt">ALAMAT LENGKAP</label><br>
                                            <input class="form-control" type="text" id="jln_op_sppt" name="jln_op_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['jln_op_sppt']?>" readonly >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="blok_kav_no_op_sppt">BLOK / NO</label><br>
                                            <input class="form-control" type="text" id="blok_kav_no_op_sppt" name="blok_kav_no_op_sppt" maxlength="15" autocomplete="off" value="<?php echo $dt['blok_kav_no_op_sppt']?>" readonly >
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-3">
                                            <label for="rt_op_sppt">RT</label><br>
                                            <input class="form-control" type="text" id="rt_op_sppt" name="rt_op_sppt" maxlength="3" autocomplete="off" value="<?php echo $dt['rt_op_sppt']?>" readonly >
                                          </div>
                                          <div class="col-md-3">
                                            <label for="rw_op_sppt">RW</label><br>
                                            <input class="form-control" type="text" id="rw_op_sppt" name="rw_op_sppt" maxlength="2" autocomplete="off" value="<?php echo $dt['rw_op_sppt']?>" readonly >
                                          </div>
                                          <div class="col-md-6">
                                            <label for="alamat_op_1">Jenis Tanah</label><br>
                                            <?php echo $select_jns_tanah; ?>
                                            <!-- <input class="form-control" type="text" id="" name="" value="<?php //echo $dt['jns_tanah']?>" readonly > -->
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

                                        <!-- Close Objek pajak -->

                                        <!-- DATA BANGUNAN -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>DATA BANGUNAN</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
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

                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>DATA TRACKING BERKAS</strong></font></center>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label> LOKET ONLINE</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_apr_loket">NIP APPROVE LOKET ONLINE</label><br>
                                                <input class="form-control" type="text" id="nip_apr_loket" name="nip_apr_loket" autocomplete="off" value="<?php echo $tracking['nip_apr_loket']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_apr_loket">NAMA APPROVE LOKET ONLINE</label><br>
                                                <input class="form-control" type="text" id="nama_apr_loket" name="nama_apr_loket" autocomplete="off" value="<?php echo $tracking['nama_apr_loket']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_apr_loket">TANGGAL APPROVE LOKET ONLINE</label><br>
                                                <input class="form-control" type="text" id="tgl_apr_loket" name="tgl_apr_loket" autocomplete="off" value="<?php echo $tracking['tgl_apr_loket']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>VERIFIKATOR</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_ver_pdl">NIP VERIFIKATOR </label><br>
                                                <input class="form-control" type="text" id="nip_ver_pdl" name="nip_ver_pdl" autocomplete="off" value="<?php echo $tracking['nip_ver_pdl']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_ver_pdl">NAMA VERIFIKATOR </label><br>
                                                <input class="form-control" type="text" id="nama_ver_pdl" name="nama_ver_pdl" autocomplete="off" value="<?php echo $tracking['nama_ver_pdl']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_ver_pdl">TANGGAL VERIFIKATOR </label><br>
                                                <input class="form-control" type="text" id="tgl_ver_pdl" name="tgl_ver_pdl" autocomplete="off" value="<?php echo $tracking['tgl_ver_pdl']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>KASUBID PENILAIAN</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_subid_pdl">NIP KASUBID PENILAIAN</label><br>
                                                <input class="form-control" type="text" id="nip_subid_pdl" name="nip_subid_pdl" autocomplete="off" value="<?php echo $tracking['nip_subid_pdl']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_subid_pdl">NAMA KASUBID PENILAIAN</label><br>
                                                <input class="form-control" type="text" id="nama_subid_pdl" name="nama_subid_pdl" autocomplete="off" value="<?php echo $tracking['nama_subid_pdl']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_subid_pdl">TANGGAL KASUBID PENILAIAN</label><br>
                                                <input class="form-control" type="text" id="tgl_subid_pdl" name="tgl_subid_pdl" autocomplete="off" value="<?php echo $tracking['tgl_subid_pdl']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>KABID PENDANIL</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_bid_pdl">NIP KABID PENDANIL</label><br>
                                                <input class="form-control" type="text" id="nip_bid_pdl" name="nip_bid_pdl" autocomplete="off" value="<?php echo $tracking['nip_bid_pdl']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_bid_pdl">NAMA KABID PENDANIL</label><br>
                                                <input class="form-control" type="text" id="nama_bid_pdl" name="nama_bid_pdl" autocomplete="off" value="<?php echo $tracking['nama_bid_pdl']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_bid_pdl">TANGGAL KABID PENDANIL</label><br>
                                                <input class="form-control" type="text" id="tgl_bid_pdl" name="tgl_bid_pdl" autocomplete="off" value="<?php echo $tracking['tgl_bid_pdl']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>KOORDINATOR SUBID KEBERATAN</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_koor_pkp">NIP KOORDINATOR SUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="nip_koor_pkp" name="nip_koor_pkp" autocomplete="off" value="<?php echo $tracking['nip_koor_pkp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_koor_pkp">NAMA KOORDINATOR SUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="nama_koor_pkp" name="nama_koor_pkp" autocomplete="off" value="<?php echo $tracking['nama_koor_pkp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_koor_pkp">TANGGAL KOORDINATOR SUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="tgl_koor_pkp" name="tgl_koor_pkp" autocomplete="off" value="<?php echo $tracking['tgl_koor_pkp']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>VERIFIKATOR SUBID KEBERATAN </label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_ver_pkp">NIP VERIFIKATOR SUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="nip_ver_pkp" name="nip_ver_pkp" autocomplete="off" value="<?php echo $tracking['nip_ver_pkp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_ver_pkp">NAMA VERIFIKATOR SUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="nama_ver_pkp" name="nama_ver_pkp" autocomplete="off" value="<?php echo $tracking['nama_ver_pkp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_ver_pkp">TANGGAL VERIFIKATOR SUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="tgl_ver_pkp" name="tgl_ver_pkp" autocomplete="off" value="<?php echo $tracking['tgl_ver_pkp']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>KASUBID KEBERATAN</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_subid_pkp">NIP KASUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="nip_subid_pkp" name="nip_subid_pkp" autocomplete="off" value="<?php echo $tracking['nip_subid_pkp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_subid_pkp">NAMA KASUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="nama_subid_pkp" name="nama_subid_pkp" autocomplete="off" value="<?php echo $tracking['nama_subid_pkp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_subid_pkp">TANGGAL KASUBID KEBERATAN</label><br>
                                                <input class="form-control" type="text" id="tgl_subid_pkp" name="tgl_subid_pkp" autocomplete="off" value="<?php echo $tracking['tgl_subid_pkp']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>KABID PKP</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_bid_pkp">NIP KABID PKP</label><br>
                                                <input class="form-control" type="text" id="nip_bid_pkp" name="nip_bid_pkp" autocomplete="off" value="<?php echo $tracking['nip_bid_pkp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_bid_pkp">NAMA KABID PKP</label><br>
                                                <input class="form-control" type="text" id="nama_bid_pkp" name="nama_bid_pkp" autocomplete="off" value="<?php echo $tracking['nama_bid_pkp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_bid_pkp">TANGGAL KABID PKP</label><br>
                                                <input class="form-control" type="text" id="tgl_bid_pkp" name="tgl_bid_pkp" autocomplete="off" value="<?php echo $tracking['tgl_bid_pkp']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
										
										<div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>KEPALA BADAN</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_kaban">NIP KEPALA BADAN</label><br>
                                                <input class="form-control" type="text" id="nip_kaban" name="nip_kaban" autocomplete="off" value="<?php echo $tracking['nip_kaban']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_kaban">NAMA KEPALA BADAN</label><br>
                                                <input class="form-control" type="text" id="nama_kaban" name="nama_kaban" autocomplete="off" value="<?php echo $tracking['nama_kaban']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_kaban">TANGGAL KEPALA BADAN</label><br>
                                                <input class="form-control" type="text" id="tgl_kaban" name="tgl_kaban" autocomplete="off" value="<?php echo $tracking['tgl_kaban']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>VERIFIKATOR PENETAPAN</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_ver_pntp">NIP VERIFIKATOR PENETAPAN</label><br>
                                                <input class="form-control" type="text" id="nip_ver_pntp" name="nip_ver_pntp" autocomplete="off" value="<?php echo $tracking['nip_ver_pntp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_ver_pntp">NAMA VERIFIKATOR PENETAPAN</label><br>
                                                <input class="form-control" type="text" id="nama_ver_pntp" name="nama_ver_pntp" autocomplete="off" value="<?php echo $tracking['nama_ver_pntp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_ver_pntp">TANGGAL VERIFIKATOR PENETAPAN</label><br>
                                                <input class="form-control" type="text" id="tgl_ver_pntp" name="tgl_ver_pntp" autocomplete="off" value="<?php echo $tracking['tgl_ver_pntp']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="row">
                                              <div class="col-md-2 d-flex align-items-center" style="padding-left:20px;">
                                                  <label>KOORDINATOR PENETAPAN</label>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nip_bid_pntp">NIP KOORDINATOR PENETAPAN</label><br>
                                                <input class="form-control" type="text" id="nip_bid_pntp" name="nip_bid_pntp" autocomplete="off" value="<?php echo $tracking['nip_bid_pntp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="nama_bid_pntp">NAMA KOORDINATOR PENETAPAN</label><br>
                                                <input class="form-control" type="text" id="nama_bid_pntp" name="nama_bid_pntp" autocomplete="off" value="<?php echo $tracking['nama_bid_pntp']?>" readonly>
                                              </div>
                                              <div class="col-md-3">
                                                <label for="tgl_bid_pntp">TANGGAL KOORDINATOR PENETAPAN</label><br>
                                                <input class="form-control" type="text" id="tgl_bid_pntp" name="tgl_bid_pntp" autocomplete="off" value="<?php echo $tracking['tgl_bid_pntp']?>" readonly>
                                              </div>
                                            </div>
                                          </div>
                                        </div>

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

                                        <div class="row" style="margin-top:20px">
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
  oTable.fnReloadAjax("<?php echo active_module_url('monitoring_permohonan_online_upt/grid_dtl_bng_ol').$dt['rowid'].'?iDisplayLength=50'; ?>");
}

function reload_grid_detail_fasilitas(id_head) {
  oTable2.fnReloadAjax("<?php echo active_module_url('monitoring_permohonan_online_upt/grid_dtl_fas_ol'); ?>" + id_head);
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
      url: '<?php echo active_module_url('monitoring_permohonan_online_upt'); ?>/get_dtl_bng/' + id_dob,
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
        url: "<?= active_module_url('monitoring_permohonan_online_upt/get_lampiran_by_pelayanan_and_sub'); ?>",
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
                return '<button class="btn btn-success" type="button" onclick="f_view_detail('+val[0]+')" >Detail</button>';
            }
        },
        { "aTargets": [7], "bSearchable": true,  "bVisible": <?php echo $dt['kd_jns_ply'] == '03' ? 'true' : 'false' ; ?>, "sWidth": "100px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                return '';
            }
        },
        { "aTargets": [8], "bSearchable": true,  "bVisible": true, "sWidth": "180px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                return '<button class="btn btn-warning" type="button" onclick="f_fas_detail('+val[0]+')" >Detail Fasilitas</button>';
            }
        },
    ],
    "sAjaxSource": "<?php echo active_module_url('monitoring_permohonan_online_upt/grid_dtl_bng_ol').$dt['rowid'].'?iDisplayLength=50';?>"
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
        { "aTargets": [5], "bSearchable": true,  "bVisible": <?php echo $dt['kd_jns_ply'] == '03' ? 'true' : 'false' ; ?>, "sWidth": "100px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                return '';
            }
        },
    ],
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

  $('#btn_back').on('click', function() {
    window.location = '<?php echo active_module_url("monitoring_permohonan_online_upt"); ?>';
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
            $('#myform').attr('action', "<?php echo active_module_url('monitoring_permohonan_online_upt/approve') ?>").submit();
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
                $('#myform').attr('action', "<?php echo active_module_url('monitoring_permohonan_online_upt/tolak') ?>").submit();
            }
        });
    }
    
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