<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">NOP PROGRESSIVE</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">NOP PROGRESSIVE</li>
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

                <form method="post" action="<?php echo $faction; ?>" id="myform" >
                    <input type="hidden" name="p_id" id="p_id" value="<?php echo $dt['p_id']; ?>" >
                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">NO PERMOHONAN</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="no_prm" name="no_prm" value="<?php echo $dt['no_prm']; ?>" readonly >
                      </div>
                    </div>

                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">NOP</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="f_nop" name="f_nop" value="<?php echo $dt['f_nop']; ?>" readonly >
                      </div>
                    </div>

                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">NAMA WP</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="nama_wp" name="nama_wp" value="<?php echo $dt['nama_wp']; ?>" readonly >
                      </div>
                    </div>

                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">ALAMAT OP</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="alamat_op" name="alamat_op" value="<?php echo $dt['alamat_op']; ?>" readonly >
                      </div>
                    </div>

                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">KELURAHAN OP</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="kel_top" name="kel_top" value="<?php echo $dt['kel_top']; ?>" readonly >
                      </div>
                    </div>

                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">KECAMATAN OP</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="kec_top" name="kec_top" value="<?php echo $dt['kec_top']; ?>" readonly >
                      </div>
                    </div>

                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">RT OP</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="rt_op" name="rt_op" value="<?php echo $dt['rt_op']; ?>" readonly >
                      </div>
                    </div>
                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">RW OP</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="rw_op" name="rw_op" value="<?php echo $dt['rw_op']; ?>" readonly >
                      </div>
                    </div>

                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">NIKNOP</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="niknop" name="niknop" value="<?php echo $dt['niknop']; ?>" readonly >
                      </div>
                    </div>

                    <div class="form-group row mt-2">
                      <label for="" class="form-label ">ALASAN</label>
                      <div class="col-sm-6">
                        <textarea type="text" maxlength="173"  style="width: 500px;height: 50px;" name="ket_tolak" id="ket_tolak"><?php echo $dt['ket_tolak'] ?></textarea>
                      </div>
                    </div>

                    <div class="row ms-0 me-0 mb-3 mt-4" style="">
                      <div class="well" >
                        <center><font style="font-size:13pt"><strong>LAMPIRAN FILE</strong></font></center>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-group w-auto">
                          <div class="input-group-prepend">
                              <span class="input-group-text rounded-end-0">SPPT</span>
                          </div>
                          <div class="col-md-3 col-sm-2 ms-2" id="IM_SPPT_BLOB" style="align-self:center">
                            <?php echo $dt['IM_SPPT_BLOB']; ?>
                          </div>
                        </div>
                      </div>
                     <div class="col-md-6">
                        <div class="input-group w-auto">
                          <div class="input-group-prepend">
                              <span class="input-group-text rounded-end-0">BUKTI KEPEMILIKAN</span>
                          </div>
                          <div class="col-md-3 col-sm-2 ms-2" id="IM_PBB_BLOB" style="align-self:center">
                            <?php echo $dt['IM_PBB_BLOB']; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row mt-2">
                      <div class="col-md-6">
                        <?php if ($this->uri->segment(3) == 'action'): ?>
                          <button type="button" id="btn_approve" class="btn btn-success">Approve</button>
                          <button type="button" id="btn_tolak" class="btn btn-danger">Tolak</button>
                        <?php endif ?>
                        
                        <button type="button" id="btn_batal" class="btn btn-info">Batal / Kembali</button>
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

  $('#btn_batal').click(function() {
    window.location = '<?php echo active_module_url($controller);?>';
  });

  $("#btn_approve").on("click", function(e){
      e.preventDefault();
      $('#myform').attr('action', "<?php echo active_module_url($controller.'/approve/'.$p_id)?>").submit();
  });

  $("#btn_tolak").on("click", function(e){
      e.preventDefault();
      var keterangan = document.getElementById('ket_tolak').value;
      if(keterangan == ''){
        alert('Harap isi keterangan untuk tolak dokumen');
      }else{
      $('#myform').attr('action', "<?php echo active_module_url($controller.'/tolak/'.$p_id)?>").submit();  
      }
  });


});

</script>

