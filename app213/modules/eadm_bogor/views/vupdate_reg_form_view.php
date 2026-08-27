<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>
<style>

.well {
  margin-top:20px;
  padding: 10px;
  min-height: 10px;
  background-color: #5D6385;
  color: #FFF;
  width: 100%;
  border-radius: 10px !important;
  margin-bottom:20px;
}

</style>


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">DETAIL REGISTRASI E-SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">DETAIL REGISTRASI E-SPPT</li>
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

                          <div class="row" style="margin-right:0px; margin-left:0px">
                            <div class="well">
                              <center><font style="font-size:13pt"><strong>DATA OBJEK PAJAK</strong></font></center>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="nop_lengkap">NOP</label><br>
                              <input class="form-control" type="text" id="nop_lengkap" name="nop_lengkap" autocomplete="off" value="<?php echo $dt['nop_lengkap']?>" readonly >
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-9">
                              <label for="jln_op_sppt">ALAMAT LENGKAP</label><br>
                              <input class="form-control" type="text" id="jln_op_sppt" name="jln_op_sppt" value="<?php echo $dt['jln_op_sppt']?>" readonly >
                            </div>
                            <div class="col-md-3">
                              <label for="blok_kav_no_op_sppt">BLOK / NO</label><br>
                              <input class="form-control" type="text" id="blok_kav_no_op_sppt" name="blok_kav_no_op_sppt" value="<?php echo $dt['blok_kav_no_op_sppt']?>" readonly >
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="kecamatan_op_nama">KECAMATAN</label><br>
                              <input class="form-control" type="text" id="kecamatan_op_nama" name="kecamatan_op_nama" value="<?php echo $dt['kecamatan_op_nama']?>" readonly >
                            </div>
                            <div class="col-md-6">
                              <label for="kelurahan_op_nama">KELURAHAN</label><br>
                              <input class="form-control" type="text" id="kelurahan_op_nama" name="kelurahan_op_nama" value="<?php echo $dt['kelurahan_op_nama']?>" readonly >
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="rt_op_sppt">RT</label><br>
                              <input class="form-control" type="text" id="rt_op_sppt" name="rt_op_sppt" maxlength="3" autocomplete="off" value="<?php echo $dt['rt_op_sppt']?>" readonly >
                            </div>
                            <div class="col-md-6">
                              <label for="rw_op_sppt">RW</label><br>
                              <input class="form-control" type="text" id="rw_op_sppt" name="rw_op_sppt" maxlength="2" autocomplete="off" value="<?php echo $dt['rw_op_sppt']?>" readonly >
                            </div>
                          </div>

                          <!-- OBJEK PAJAK -->
                          <div class="row" style="margin-right:0px; margin-left:0px">
                            <div class="well">
                              <center><font style="font-size:13pt"><strong>DATA PEMOHON / SUBJEK PAJAK</strong></font></center>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="nik">NIK</label><br>
                              <input class="form-control" type="text" id="nik" name="nik" value="<?php echo $dt['nik']?>" readonly >
                            </div>
                            <div class="col-md-6">
                              <label for="nm_wp_sppt">NAMA LENGKAP</label><br>
                              <input class="form-control" type="text" id="nm_wp_sppt" name="nm_wp_sppt" value="<?php echo $dt['nm_wp_sppt']?>" readonly >
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="nohp">NO HP (AKTIF)</label><br>
                              <input class="form-control" type="text" id="nohp" name="nohp" value="<?php echo $dt['nohp']?>" readonly >
                            </div>
                            <div class="col-md-6">
                              <label for="email">ALAMAT EMAIL</label><br>
                              <input class="form-control" type="text" id="email" name="email" value="<?php echo $dt['email']?>" readonly >
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="loginname">LOGINNAME</label><br>
                              <input class="form-control" type="text" id="loginname" name="loginname" value="<?php echo $dt['loginname']?>" readonly >
                              
                            </div>
                            <div class="col-md-6 hidden">
                              <label for="loginname">PASSWORD</label><br>
                              <input class="form-control" type="hidden" id="passwd" name="passwd" value="<?php echo $dt['passen']?>" readonly >
                            </div>
                          </div>


                          <!-- LAMPIRAN FILE -->
                          <div class="row" style="margin-right:0px; margin-left:0px">
                            <div class="well" >
                              <center><font style="font-size:13pt"><strong>LAMPIRAN FILE</strong></font></center>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="im_ktp">KTP</label><br>
                              <a target="_blank" href="<?php echo active_module_url().'update_reg/openblob/im_ktp_blob/'.$dt['nik'].'/'.$dt['status_verif'].'/'.$dt['crea_date']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="im_lamp2">SPPT</label><br>
                              <a target="_blank" href="<?php echo active_module_url().'update_reg/openblob/im_sppt_blob/'.$dt['nik'].'/'.$dt['status_verif'].'/'.$dt['crea_date']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <label for="im_lamp4">STTS</label><br>
                              <a target="_blank" href="<?php echo active_module_url().'update_reg/openblob/im_pbb_blob/'.$dt['nik'].'/'.$dt['status_verif'].'/'.$dt['crea_date']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                            </div>
                          </div>


                          <div class="row" style="margin-top:40px">
                            <div class="col-md-6">
                              <!-- <button class="btn btn-danger" id="btn_approve" type="button">APPROVE</button> -->
                              <!-- <button class="btn btn-success" id="btn_tolak" type="button">TOLAK</button> -->
                    					<button class="btn btn-warning" type="button" id="btn_kembali">KEMBALI</button>
                            </div>
                          </div>
                      </div>
                  </div>
                </form>
                </div>
                </div>
              <br>
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

  $('#btn_kembali').click(function() {
    window.location = '<?php echo active_module_url("update_reg");?>';
  });

});

</script>
