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
                        <h4 class="mb-0">KEPALA BADAN - PELAYANAN PENGURANGAN</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Kaban - Pelayanan Pengurangan</li>
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
                                                <input class="form-control" type="text" id="telp" name="telp" autocomplete="off" value="<?php echo $dt['telp']?>" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                              </div>
                                            </div>

                                            <div class="row mt-4 pl-0 pl-md-3" id="r_png">
                                              <div class="col-md-11">
                                                <div class="card shadow">
                                                  <div class="card-header py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">PENGURANGAN</h6>
                                                  </div>
                                                  <div class="card-body">
                                                    <div class="row mt-2">
                                                      <div class="col-md-5" style="padding-left:20px;">
                                                        <label for="telp">JNS PENGURANGAN</label>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <input class="form-control" type="text" id="jns_png" name="jns_png" value="<?php echo $dt['jns_png']?>" readonly >
                                                      </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                      <div class="col-md-5" style="padding-left:20px;">
                                                        <label for="telp">PERSENTASE</label>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <input class="form-control" type="text" id="pct_png" name="pct_png" value="<?php echo $dt['pct_png']?>" readonly >
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div class="row mt-4 pl-0 pl-md-3" id="r_png">
                                              <div class="col-md-11">
                                                <div class="card shadow">
                                                  <div class="card-header py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">PENGURANGAN DISETUJUI</h6>
                                                  </div>
                                                  <div class="card-body">
                                                    <div class="row mt-2">
                                                      <div class="col-md-5" style="padding-left:20px;">
                                                        <label for="telp">PERSENTASE</label>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <input class="form-control" type="text" id="pct_png_disetujui" name="pct_png_disetujui" value="<?php echo $dt['pct_png_disetujui']?>" >
                                                      </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                      <div class="col-md-5" style="padding-left:20px;">
                                                        <label for="telp">STS PERMOHONAN</label>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <?php echo $select_sts_pengurangan; ?>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
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

                                            <div class="row mt-2 <?php echo $dt['kd_jns_ply'] == '08' ? '' : 'hidden'; ?>">
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

                                        <!-- LEMBAR PENELITI -->
                                        <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                                          <div class="well" >
                                            <center><font style="font-size:13pt"><strong>LEMBAR PENELITI</strong></font></center>
                                          </div>
                                        </div>

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
                                        <!-- END LEMBAR PENELITI -->

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
                                          <div class="col-md-12">
                                            <?php if ($this->uri->segment(3) == 'edit') { ?>
                                            <button class="btn btn-success" id="btn_approve" type="submit">Approve Kaban</button>
                                            <button class="btn btn-danger" id="btn_tolak" type="button">Tolak</button>
                                            <button class="btn btn-warning" id="btn_tolak_ply" type="button" >Penelitian Ulang</button>
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

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>


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
  var id_sub_lamp = $('#sub_jns_ply').val();
  f_chg_lamp(id_lamp, id_sub_lamp);

  $('#nop_re').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });

  $('#nop').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });
  
  $('#btn_back').on('click', function() {
    window.location = '<?php echo active_module_url("bid_keberatan_pengurangan_kaban"); ?>';
  }); 

  $('#myform').on('submit', function(e) {
      e.preventDefault(); // cegah submit normal

      var form = this;

      // HTML5 validation
      if (!form.checkValidity()) {
          form.reportValidity();
          return;
      }

      var data = new FormData(form);

      $("#overlay").fadeIn(300);

      $.ajax({
          url: "<?php echo active_module_url() ?>bid_keberatan_pengurangan_kaban/approve_permohonan/",
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
                      window.location = '<?php echo active_module_url("bid_keberatan_pengurangan_kaban"); ?>';
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
        html: `Permohonan yang sudah ditolak tidak dapat dikembalikan.
                <br>
                <span style="font-size: 0.85em; color: #888; display: block; margin-top: 10px;">
                    Catatan: Status Permohonan akan otomatis menjadi DITOLAK.
                </span>
              `,
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
                url: "<?php echo active_module_url() ?>bid_keberatan_pengurangan_kaban/tolak_permohonan/",
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
                            window.location = '<?php echo active_module_url("bid_keberatan_pengurangan_kaban"); ?>';
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

  $('#btn_tolak_ply').on('click', function () {

      Swal.fire({
          title: 'Tolak Berkas?',
          text: 'Tolak Berkas ini dan kembalikan ke Verifikasi?',
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
                  url: '<?php echo active_module_url() ?>bid_keberatan_pengurangan_kaban/tolak_ke_pelayanan/',
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
                  window.location = '<?php echo active_module_url("bid_keberatan_pengurangan_kaban"); ?>';
              });
          }
      });

  });



});

</script>