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
/*  margin-left: 10px;*/
}

label{
  align-self: center;
}

p{
  margin-bottom: 0px;
  align-self: center;
}

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
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">PERMOHONAN ONLINE</li>
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

                <?php echo form_open($faction, array('id'=>'myform'));?>

                <!-- SUBJEK / WAJIB PAJAK -->
                <!-- SUBJEK / WAJIB PAJAK -->
                <div class="panel">

                    <div class="row" style="margin-right:0px; margin-left:0px; background-image:url(<?php echo site_url('assets/img/stadion_pakansari.jpg'); ?>);
                      background-repeat:no-repeat; background-size:cover; ">
                      <!-- <div class="col-md-2" style=""></div> -->
                      <div class="col-md-12 ">

                          <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                            <div class="well">
                              <center><font style="font-size:13pt"><strong>DATA PERMOHONAN ONLINE</strong></font></center>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-4" style="padding-left:20px;">
                                  <label for="nopel">NO PELAYANAN</label>
                                </div>
                                <div class="col-md-7">
                                  <input class="form-control" type="text" id="nopel" name="nopel" autocomplete="off" value="<?php echo $dt['nopel']?>" readonly >
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-4" style="padding-left:20px;">
                                  <label for="jns_pelayanan">JENIS PELAYANAN</label>
                                </div>
                                <div class="col-md-7">
                                  <input class="form-control" type="text" id="jns_pelayanan" name="jns_pelayanan" autocomplete="off" value="<?php echo $dt['jns_pelayanan']?>" readonly >
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
                                  <label for="tgl_permohonan">TGL PERMOHONAN</label>
                                </div>
                                <div class="col-md-7">
                                  <input class="form-control" type="text" id="tgl_permohonan" name="tgl_permohonan" autocomplete="off" value="<?php echo $dt['tgl_permohonan']?>" readonly >
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
                                  <label for="thn_ketetapan">THN KETETAPAN</label>
                                </div>
                                <div class="col-md-7">
                                  <input class="form-control" type="text" id="thn_ketetapan" name="thn_ketetapan" autocomplete="off" value="<?php echo $dt['thn_ketetapan']?>" readonly >
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
                                  <input class="form-control" type="text" id="nama_pemohon" name="nama_pemohon" autocomplete="off" value="<?php echo $dt['nama_pemohon']?>" readonly >
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-4" style="padding-left:20px;">
                                  <label for="alamat_pemohon">ALAMAT PEMOHON</label>
                                </div>
                                <div class="col-md-7">
                                  <input class="form-control" type="text" id="alamat_pemohon" name="alamat_pemohon" autocomplete="off" value="<?php echo $dt['alamat_pemohon']?>" readonly >
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
                                  <input class="form-control" type="text" id="telp" name="telp" autocomplete="off" value="<?php echo $dt['telp']?>" readonly >
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-4" style="padding-left:20px;">
                                  <label for="keterangan">KETERANGAN</label>
                                </div>
                                <div class="col-md-7">
                                  <input class="form-control" type="text" id="keterangan" name="keterangan" autocomplete="off" value="<?php echo $dt['keterangan']?>" readonly >
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

                          <div class="row">
                            <div class="col-md-6 mt-2">
                              <div class="row geser_kanan">
                                <label class="col-md-4 col-sm-12" for="im_ktp">SPOP</label>
                                <div class="col-md-7 col-sm-12">
                                  <?php if ($da['L_SKKP_PBB'] == 1): ?>
                                    <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SKKP_PBB1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                    <?php else: ?>
                                      <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                  <?php endif ?>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 mt-2">
                              <div class="row">
                              <label class="col-md-4 col-sm-12" for="im_ktp">LSPOP</label>
                              <div class="col-md-7 col-sm-12">
                                  <?php if ($da['L_SPMKP_PBB'] == 1): ?>
                                    <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SPMKP_PBB1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  <?php else: ?>
                                    <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                  <?php endif ?>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mt-2">
                              <div class="row geser_kanan">
                                 <label class="col-md-4 col-sm-12" for="im_lamp2">KTP</label>
                                 <div class="col-md-7 col-sm-12">
                                    <?php if ($da['L_KTP_WP'] == 1): ?>
                                    <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_KTP_WP1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                    <?php else: ?>
                                        <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                    <?php endif ?>
                                  </div>

                              </div>
                            </div>
                            <div class="col-md-6 mt-2">
                              <div class="row">
                              <label class="col-md-4 col-sm-12" for="im_lamp2">BUKTI KEPEMILIKAN TANAH</label>
                              <div class="col-md-7 col-sm-12">
                                  <?php if ($da['L_SERTIFIKAT_TANAH'] == 1): ?>
                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SERTIFIKAT_TANAH1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  <?php else: ?>
                                    <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                  <?php endif; ?>
                                </div>

                              </div>

                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mt-2">
                              <div class="row geser_kanan">
                              <label class="col-md-4 col-sm-12" for="im_lamp4">IMB</label>
                              <div class="col-md-7 col-sm-12">
                                  <?php if ($da['L_IMB'] == 1): ?>
                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_IMB1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  <?php else: ?>
                                    <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                  <?php endif ?>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 mt-2">
                              <div class="row">
                                <label class="col-md-4 col-sm-12" for="im_lamp4">AJB</label>
                                <div class="col-md-7 col-sm-12">
                                    <?php if ($da['L_AKTE_JUAL_BELI'] ==  1): ?>
                                    <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_AKTE_JUAL_BELI1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                    <?php else: ?>
                                        <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                    <?php endif; ?>
                                  </div>
                              </div>

                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mt-2">
                              <div class="row geser_kanan">
                              <label class="col-md-4 col-sm-12" for="im_lamp4">VALIDASI BPHTB</label>
                              <div class="col-md-7 col-sm-12">
                                  <?php if ($da['L_SURAT_KUASA'] == 1): ?>
                                    <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SURAT_KUASA1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  <?php else: ?>
                                    <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                  <?php endif ?>
                                </div>

                              </div>
                            </div>
                            <div class="col-md-6 mt-2">
                              <div class="row">
                              <label class="col-md-4 col-sm-12" for="im_lamp4">SRT PENGANTAR DESA</label>
                              <div class="col-md-7 col-sm-12">
                                  <?php if ($da['L_PERMOHONAN'] == 1): ?>
                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_PERMOHONAN1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  <?php else: ?>
                                    <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                  <?php endif ?>
                                </div>

                              </div>

                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mt-2">
                              <div class="row geser_kanan">
                              <label class="col-md-4 col-sm-12" for="im_lamp4">SURKET TDK SENGKETA</label>
                              <div class="col-md-7 col-sm-12">
                                  <?php if ($da['L_STTS'] == 1): ?>
                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_STTS1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  <?php else: ?>
                                    <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                  <?php endif ?>
                                </div>

                              </div>

                            </div>
                            <div class="col-md-6 mt-2">
                              <div class="row ">
                                <label class="col-md-4 col-sm-12" for="im_lamp4">RIWAYAT TANAH</label>
                                <div class="col-md-7 col-sm-12">
                                    <?php if ($da['L_SK_KEBERATAN'] == 1): ?>
                                      <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SK_KEBERATAN1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                    <?php else: ?>
                                      <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                    <?php endif ?>
                                  </div>

                              </div>

                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mt-2">
                              <div class="row geser_kanan">
                                 <label class="col-md-4 col-sm-12" for="im_lamp4">SPPT</label>
                                 <div class="col-md-7 col-sm-12">
                                     <?php if ($da['L_SPPT'] == 1): ?>
                                       <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SPPT1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                     <?php else: ?>
                                      <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                     <?php endif ?>
                                   </div>

                              </div>

                            </div>
                            <div class="col-md-6 mt-2">
                              <div class="row">
                                <label class="col-md-4 col-sm-12" for="im_lamp4">BUKTI BAYAR ASLI</label>
                                <div class="col-md-7 col-sm-12">
                                    <?php if ($da['L_SPPT_STTS'] == 1): ?>
                                      <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SPPT_STTS1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                    <?php else: ?>
                                      <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                    <?php endif ?>
                                  </div>

                              </div>

                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 mt-2">
                              <div class="row geser_kanan">
                                <label class="col-md-4 col-sm-12" for="im_lamp4">SK PENGURANGAN</label>
                                <div class="col-md-7 col-sm-12">
                                    <?php if ($da['L_SK_PENGURANGAN'] == 1): ?>
                                    <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_SK_PENGURANGAN1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                    <?php else: ?>
                                        <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                    <?php endif ?>
                                  </div>

                              </div>

                            </div>
                            <div class="col-md-6 mt-2">
                              <div class="row">
                              <label class="col-md-4 col-sm-12" for="im_lamp4">LAIN LAIN</label>
                              <div class="col-md-7 col-sm-12">
                                  <?php if ($da['L_LAIN_LAIN']): ?>
                                  <a target="_blank" href="<?php echo active_module_url().'permohonan_online/openblob/L_LAIN_LAIN1/'.$dt['nopel']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  <?php else: ?>
                                    <div class="col-md-3"><p class="teks_red">File Tidak Ada</p></div>
                                  <?php endif ?>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="row">
                            <div class="col-md-12">
                              <label for="loginname">Keterangan</label><br>
                              <textarea class="form-control" type="text" id="keterangan_a" name="keterangan_a"  ><?php echo $dt['keterangan_a']; ?></textarea>
                            </div>
                          </div>

                          <div class="row" style="margin-top:40px">
                            <div class="col-md-6">
                              <button class="btn btn-success" id="btn_approve" type="button">APPROVE</button>
                              <button class="btn btn-danger" id="btn_tolak" type="button">TOLAK</button>
                    					<button class="btn btn-info" type="button" id="btn_batal">BATAL</button>
                            </div>
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

$(document).ready(function() {
  // $('#nop_ttg_1').formatter({
  //       'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  // });

  // $('#nik').keyup(function(){
  //   $("#loginname").val($(this).val());
  // });

  $('#btn_batal').click(function() {
    window.location = '<?php echo active_module_url("permohonan_online");?>';
  });

  $("#btn_approve").on("click", function(e){
      e.preventDefault();
      $('#myform').attr('action', "<?php echo active_module_url('permohonan_online/approve')?>").submit();
  });

  $("#btn_tolak").on("click", function(e){
      e.preventDefault();
       var keterangan = document.getElementById('keterangan_a').value;
       if(keterangan == ''){
        alert('Harap isi keterangan untuk tolak dokumen');
      }else{
        $('#myform').attr('action', "<?php echo active_module_url('permohonan_online/tolak'); ?>").submit();
      }
  });


});

</script>