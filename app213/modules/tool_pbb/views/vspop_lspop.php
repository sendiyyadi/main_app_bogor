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
/* END SPINNER */

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">MENU SPOP LSPOP</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">SPOP LSPOP</li>
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

            <div class="card">
              <?php echo form_open('', array('id'=>'myform', 'enctype'=>'multipart/form-data'));?>
              <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                  <div class="bg-success rounded text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                      <i class="bx bx-user-circle fs-3"></i> 
                  </div>
                  <h5 class="text-success fw-bold mb-0 me-3" style="letter-spacing: 1px;">Cari Data Objek Pajak</h5>
                  <div class="flex-grow-1 border-top border-success opacity-50"></div>
              </div>

                <div class="mb-3 row">
                    <label for="nop" class="col-md-3 col-form-label">NOP SPPT P2</label>
                    <div class="col-md-8">
                        <input class="form-control text-uppercase" type="text"  id="nop" name="nop" inputmode="numeric" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-md-3 col-form-label"></label>
                    <div class="col-md-3">
                        <button type="button" id="btn_send" class="btn btn-outline-success waves-effect waves-light w-md">CARI DATA</button>
                    </div>
                </div>
              </div>

            </form>

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

$(document).ready(function() {

    $('#nop').formatter({
        'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
    });

    $('#btn_send').on('click', function(e) {
        let nop = $('#nop').val(); 
        window.location = '<?php echo active_module_url("spop_lspop/detail"); ?>'+nop;
    });

});

</script>
