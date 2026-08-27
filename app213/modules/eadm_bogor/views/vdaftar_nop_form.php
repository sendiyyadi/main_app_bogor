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

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Pendaftaran Objek Pajak Baru</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Pendaftaran Objek Pajak Baru</li>
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

                  <?php echo form_open($faction, array('id'=>'myform'));?>

                    <!-- SUBJEK / WAJIB PAJAK -->
                    <!-- SUBJEK / WAJIB PAJAK -->
                    <div class="panel">

                        <div class="row" style="margin-right:0px; margin-left:0px; background-image:url(<?php echo site_url('assets/img/stadion_pakansari.jpg'); ?>);
                          background-repeat:no-repeat; background-size:cover; ">

                              <div class="row" style="margin-right:0px; margin-left:0px">
                                <div class="well">
                                  <center><font style="font-size:13pt"><strong>DATA WAJIB PAJAK / SUBJEK PAJAK</strong></font></center>
                                </div>
                              </div>

                              <div class="card mt-2">
                              <div class="card-body">

                              <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label" for="nik">NIK</label><br>
                                  <input class="form-control" type="text" id="nik" name="nik" maxlength="16" autocomplete="off" value="<?php echo $dt['nik']?>" readonly >
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="nm_wp_sppt">NAMA LENGKAP</label><br>
                                  <input class="form-control" type="text" id="nm_wp_sppt" name="nm_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['nm_wp_sppt']?>" readonly >
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-9">
                                  <label class="form-label" for="jln_wp_sppt">ALAMAT LENGKAP</label><br>
                                  <input class="form-control"  type="text" id="jln_wp_sppt" name="jln_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['jln_wp_sppt']?>" readonly >
                                </div>
                                <div class="col-md-3">
                                  <label class="form-label" for="blok_kav_no_wp_sppt">BLOK / NO</label><br>
                                  <input class="form-control"  type="text" id="blok_kav_no_wp_sppt" name="blok_kav_no_wp_sppt" maxlength="15" autocomplete="off" value="<?php echo $dt['blok_kav_no_wp_sppt']?>" readonly >
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label" for="rt_wp_sppt">RT</label><br>
                                  <input class="form-control" type="text" id="rt_wp_sppt" name="rt_wp_sppt" autocomplete="off" maxlength="3" value="<?php echo $dt['rt_wp_sppt']?>" readonly >
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="rw_wp_sppt">RW</label><br>
                                  <input class="form-control" type="text" id="rw_wp_sppt" name="rw_wp_sppt" autocomplete="off" maxlength="2" value="<?php echo $dt['rw_wp_sppt']?>" readonly >
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label" for="kelurahan_wp_sppt">KELURAHAN</label><br>
                                  <input class="form-control" type="text" id="kelurahan_wp_sppt" name="kelurahan_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['kelurahan_wp_sppt']?>" readonly >
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="kota_wp_sppt">KABUPATEN / KOTA</label><br>
                                  <input class="form-control" type="text" id="kota_wp_sppt" name="kota_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['kota_wp_sppt']?>" readonly >
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label" for="kd_pos_wp_sppt">KODE POS</label><br>
                                  <input class="form-control" type="text" id="kd_pos_wp_sppt" name="kd_pos_wp_sppt" maxlength="5" autocomplete="off" value="<?php echo $dt['kd_pos_wp_sppt']?>" readonly >
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="npwp">NPWP</label><br>
                                  <input class="form-control" type="text" id="npwp" name="npwp" maxlength="15" autocomplete="off" value="<?php echo $dt['npwp']?>" readonly >
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label" for="nohp">NO HP (AKTIF)</label><br>
                                  <input class="form-control" type="text" id="nohp" name="nohp" maxlength="15" autocomplete="off" value="<?php echo $dt['nohp']?>" readonly >
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="email">ALAMAT EMAIL</label><br>
                                  <input class="form-control" type="text" id="email" name="email" maxlength="30" autocomplete="off" value="<?php echo $dt['email']?>" readonly >
                                  <input class="form-control" type="hidden" id="passwd" name="passwd" value="<?php echo $dt['passwd']?>" readonly >
                                </div>
                              </div>

                              </div>
                              </div>

                              <!-- OBJEK PAJAK -->
                              <div class="row" style="margin-right:0px; margin-left:0px">
                                <div class="well">
                                  <center><font style="font-size:13pt"><strong>DATA OBJEK PAJAK</strong></font></center>
                                </div>
                              </div>

                              <div class="card mt-2">
                              <div class="card-body">

                              <div class="row">
                                <div class="col-md-9">
                                  <label class="form-label" for="jln_op_sppt">ALAMAT LENGKAP</label><br>
                                  <input class="form-control" type="text" id="jln_op_sppt" name="jln_op_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['jln_op_sppt']?>" readonly >
                                </div>
                                <div class="col-md-3">
                                  <label class="form-label" for="blok_kav_no_op_sppt">BLOK / NO</label><br>
                                  <input class="form-control" type="text" id="blok_kav_no_op_sppt" name="blok_kav_no_op_sppt" maxlength="15" autocomplete="off" value="<?php echo $dt['blok_kav_no_op_sppt']?>" readonly >
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label" for="rt_op_sppt">RT</label><br>
                                  <input class="form-control" type="text" id="rt_op_sppt" name="rt_op_sppt" maxlength="3" autocomplete="off" value="<?php echo $dt['rt_op_sppt']?>" readonly >
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="rw_op_sppt">RW</label><br>
                                  <input class="form-control" type="text" id="rw_op_sppt" name="rw_op_sppt" maxlength="2" autocomplete="off" value="<?php echo $dt['rw_op_sppt']?>" readonly >
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label" for="nop_ttg_1">NOP TETANGGA 1</label><br>
                                  <input class="form-control" type="text" id="nop_ttg_1" name="nop_ttg_1" autocomplete="off" value="<?php echo $dt['nop_ttg_1']?>" readonly >
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="nop_ttg_2">NOP TETANGGA 2</label><br>
                                  <input class="form-control" type="text" id="nop_ttg_2" name="nop_ttg_2" autocomplete="off" value="<?php echo $dt['nop_ttg_2']?>" readonly >
                                </div>
                              </div>

                              <!-- <div class="row">
                                <div class="col-md-4">
                                  <label class="form-label" for="nama_wp_1">NAMA WAJIB PAJAK</label><br>
                                  <input class="form-control" style="width:90%" type="text" id="nama_wp_1" name="nama_wp_1" value="<?php //echo $dt['nama_wp_1']?>" readonly >
                                </div>
                                <div class="col-md-4">
                                  <label class="form-label" for="nama_wp_2">NAMA WAJIB PAJAK</label><br>
                                  <input class="form-control" style="width:90%" type="text" id="nama_wp_2" name="nama_wp_2" value="<?php //echo $dt['nama_wp_2']?>" readonly >
                                </div>
                              </div> -->

                              <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label" for="alamat_op_1">ALAMAT WAJIB PAJAK</label><br>
                                  <input class="form-control" type="text" id="alamat_op_1" name="alamat_op_1" value="<?php echo $dt['alamat_op_1']?>" readonly >
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label" for="alamat_op_2">ALAMAT WAJIB PAJAK</label><br>
                                  <input class="form-control" type="text" id="alamat_op_2" name="alamat_op_2" value="<?php echo $dt['alamat_op_2']?>" readonly >
                                </div>
                              </div>

                              </div>
                              </div>

                              <!-- LAMPIRAN FILE -->
                              <div class="row" style="margin-right:0px; margin-left:0px">
                                <div class="well" >
                                  <center><font style="font-size:13pt"><strong>LAMPIRAN FILE</strong></font></center>
                                </div>
                              </div>

                              <div class="card mt-2">
                              <div class="card-body">

                              <div class="row">
                                <div class="col-md-6 mt-2">
                                  <div class="input-group w-auto">
                                    <div class="input-group-prepend col-md-3 col-sm-7">
                                        <span class="input-group-text rounded-end-0">KTP</span>
                                    </div>
                                    <a target="_blank" href="<?php echo active_module_url().'daftar_nop/openblob/im_ktp/'.$dt['nik']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                  <div class="input-group w-auto">
                                    <div class="input-group-prepend col-md-3 col-sm-7">
                                        <span class="input-group-text rounded-end-0">RIWAYAT TANAH</span>
                                    </div>
                                    <a target="_blank" href="<?php echo active_module_url().'daftar_nop/openblob/im_lamp1/'.$dt['nik']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6 mt-2">
                                  <div class="input-group w-auto">
                                    <div class="input-group-prepend col-md-3 col-sm-7">
                                        <span class="input-group-text rounded-end-0">SPOP</span>
                                    </div>
                                    <a target="_blank" href="<?php echo active_module_url().'daftar_nop/openblob/im_lamp2/'.$dt['nik']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                  <div class="input-group w-auto">
                                    <div class="input-group-prepend col-md-3 col-sm-7">
                                        <span class="input-group-text rounded-end-0">LSPOP</span>
                                    </div>
                                    <a target="_blank" href="<?php echo active_module_url().'daftar_nop/openblob/im_lamp3/'.$dt['nik']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6 mt-2">
                                  <div class="input-group w-auto">
                                    <div class="input-group-prepend col-md-3 col-sm-7">
                                        <span class="input-group-text rounded-end-0">SERTIFIKAT</span>
                                    </div>
                                    <a target="_blank" href="<?php echo active_module_url().'daftar_nop/openblob/im_lamp4/'.$dt['nik']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                  <div class="input-group w-auto">
                                    <div class="input-group-prepend col-md-3 col-sm-7">
                                        <span class="input-group-text rounded-end-0">DENAH LOKASI</span>
                                    </div>
                                    <a target="_blank" href="<?php echo active_module_url().'daftar_nop/openblob/im_lamp5/'.$dt['nik']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6 mt-2">
                                  <div class="input-group w-auto">
                                    <div class="input-group-prepend col-md-3 col-sm-7">
                                        <span class="input-group-text rounded-end-0">TITIK KOORDINAT</span>
                                    </div>
                                    <a target="_blank" href="<?php echo active_module_url().'daftar_nop/openblob/im_lamp6/'.$dt['nik']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                  <div class="input-group w-auto">
                                    <div class="input-group-prepend col-md-3 col-sm-7">
                                        <span class="input-group-text rounded-end-0">LAIN LAIN</span>
                                    </div>
                                    <a target="_blank" href="<?php echo active_module_url().'daftar_nop/openblob/im_lamp7/'.$dt['nik']; ?>" class="btn btn-primary " data-toggle="tooltip" title="View"></i> Lihat File</a>
                                  </div>
                                </div>
                              </div>

                              </div>
                              </div>

                              <!-- NOP BARUNYA -->
                              <div class="row" style="margin-right:0px; margin-left:0px">
                                <div class="well" >
                                  <center><font style="font-size:13pt"><strong>NOP BARU</strong></font></center>
                                </div>
                              </div>

                              <div class="card mt-2">
                              <div class="card-body">

                              <div class="row">
                                <div class="col-md-12">
                                  <label class="form-label" for="kd_kecamatan">NOP BARU</label><br>
                                  <div class="row">
                                    <div class="col-sm-1" style="padding-right:0px">
                                      <input class="form-control" type="text" id="kd_propinsi" name="kd_propinsi" value="32" readonly >
                                    </div>
                                    <div class="col-sm-1" style="padding-right:0px">
                                      <input class="form-control" type="text" id="kd_dati2" name="kd_dati2" value="03" readonly >
                                    </div>
                                    <div class="col-sm-1" style="padding-right:0px">
                                      <input class="form-control" type="text" id="kd_kecamatan" maxlength="3" name="kd_kecamatan" >
                                    </div>
                                    <div class="col-sm-1" style="padding-right:0px">
                                      <input class="form-control" type="text" id="kd_kelurahan" maxlength="3" name="kd_kelurahan" >
                                    </div>
                                    <div class="col-sm-1" style="padding-right:0px">
                                      <input class="form-control" type="text" id="kd_blok" maxlength="3" name="kd_blok" >
                                    </div>
                                    <div class="col-sm-2" style="padding-right:0px">
                                      <input class="form-control" type="text" id="no_urut" maxlength="4" name="no_urut" >
                                    </div>
                                    <div class="col-sm-1" style="padding-right:0px">
                                      <input class="form-control" type="text" id="kd_jns_op" maxlength="1" name="kd_jns_op" >
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  <label class="form-label" for="kd_znt">KODE ZNT</label><br>
                                  <input class="form-control" style="width:14%" type="text" id="kd_znt" maxlength="2" name="kd_znt" >
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  <label class="form-label" for="alasan">KETERANGAN / ALASAN</label><br>
                                  <input class="form-control" style="width:100%" type="text" id="alasan" name="alasan" >
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
                        </div>

                    </form>
                    <br>
                </div>
            </div>

<?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>

<script>

$(document).ready(function() {
  $('#nop_ttg_1').formatter({
        'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });
  $('#nop_ttg_2').formatter({
        'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
  });

  $('#cari_nop_1').click(function() {
      var nop = $('#nop_ttg_1').val();
      $.ajax({
        url: "<?php echo active_module_url()?>daftar_objek_pajak/get_nop_ttg_1/"+nop,
        async: false,
        success: function (j) {
          var data = $.parseJSON(j);
          if (data['nama_wp'] == ''){
            alert('NOP Tidak Ditemukan...');
            return false;
          } else {
            $("#nama_wp_1").val(data['nama_wp']);
            $("#alamat_op_1").val(data['alamat_op']);
          }
        },
        error: function (xhr, desc, er) {
          alert(er);
        }
      });
  });

  $('#cari_nop_2').click(function() {
      var nop = $('#nop_ttg_2').val();
      $.ajax({
        url: "<?php echo active_module_url()?>daftar_objek_pajak/get_nop_ttg_1/"+nop,
        async: false,
        success: function (j) {
          var data = $.parseJSON(j);
          if (data['nama_wp'] == ''){
            alert('NOP Tidak Ditemukan...');
            return false;
          } else {
            $("#nama_wp_2").val(data['nama_wp']);
            $("#alamat_op_2").val(data['alamat_op']);
          }
        },
        error: function (xhr, desc, er) {
          alert(er);
        }
      });
  });

  $('#nik').keyup(function(){
    $("#loginname").val($(this).val());
  });

  $('#btn_batal').click(function() {
    window.location = '<?php echo active_module_url("daftar_nop");?>';
  });

  $("#btn_approve").on("click", function(e){
      var kd_kec    = $("#kd_kecamatan").val();
      var kd_kel    = $("#kd_kelurahan").val();
      var kd_blok   = $("#kd_blok").val();
      var no_urut   = $("#no_urut").val();
      var kd_jns_op = $("#kd_jns_op").val();
      var kd_znt    = $("#kd_znt").val();
      var alasan    = $("#alasan").val();
      if( kd_kec == '' || kd_kel == '' || kd_blok == '' || no_urut == '' || kd_jns_op == '' ){
        alert('NOP BARU Harap diisi dengan benar...'); return false;
      }
      if( kd_znt == ''){
        alert('KODE ZNT Harap diisi dengan benar...'); return false;
      }
      if( alasan == ''){
        alert('KETERANGAN / ALASAN Harap diisi dengan benar...'); return false;
      }
      e.preventDefault();
      $('#myform').attr('action', "<?php echo active_module_url('daftar_nop/approve')?>").submit();
  });

  $("#btn_tolak").on("click", function(e){
      var kd_kec    = $("#kd_kecamatan").val();
      var kd_kel    = $("#kd_kelurahan").val();
      var kd_blok   = $("#kd_blok").val();
      var no_urut   = $("#no_urut").val();
      var kd_jns_op = $("#kd_jns_op").val();
      var kd_znt    = $("#kd_znt").val();
      var alasan    = $("#alasan").val();
      if( kd_kec != '' || kd_kel != '' || kd_blok != '' || no_urut != '' || kd_jns_op != '' ){
        alert('NOP BARU Harap dikosongkan...'); return false;
      }
      if( kd_znt != ''){
        alert('KODE ZNT Harap dikosongkan...'); return false;
      }
      if( alasan != ''){
        alert('KETERANGAN / ALASAN Harap dikosongkan...'); return false;
      }
      e.preventDefault();
      $('#myform').attr('action', "<?php echo active_module_url('daftar_nop/tolak')?>").submit();
  });


});

</script>