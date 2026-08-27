<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
  table.dataTable tbody tr.row_selected {
    background-color: #B0BED9 !important;
  }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">DETAIL SPPT BERMASALAH</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Detail SPPT Bermasalah</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            echo msg_block();
            if(validation_errors()){
              echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
              echo validation_errors('<small>','</small>');
              echo '</blockquote>';
            }
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-10">  <!-- DATA AWAL -->
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">NOP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="nop" id="nop" value="<?php echo $dt['nop']?>" readonly/>
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Nama WP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="nama_wp" id="nama_wp" value="<?php echo $dt['nama_wp']?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kecamatan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kecamatan" id="kecamatan" value="<?php echo $dt['kecamatan']?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kelurahan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kelurahan" id="kelurahan" value="<?php echo $dt['kelurahan']?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Tgl Penyerahan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="tgl_penyerahan" id="tgl_penyerahan" value="<?php echo $dt['tgl_penyerahan']?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">User Penyerahan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="loginname" id="loginname" value="<?php echo $dt['loginname']?>" readonly />
                                        </div>
                                    </div>

                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">FOTO</label>
                                        </div>
                                        <div class="col-md-8">
                                            <img src="<?php echo $dt['link_foto']?>" width="400px">
                                            <!-- <input class="input form-control" type="text" style="margin-right: 5px;" name="link_foto" id="link_foto" value="<?php echo $dt['link_foto']?>" readonly /> -->
                                        </div>
                                    </div>

                                </div>

                            </div>

                            &nbsp;
                            <div class="row control-group">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-8">
                                    <button id="btn_batal" class="btn btn-sm btn-info" >KEMBALI</button>
                                </div>
                            </div>

                        <!-- END DIV CARD BODY -->
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


<!-- tambahan datatables -->
<script>

var ID;
var NOP;
var THN_SPPT;
var oTable;

    $(document).ready(function () {


        $("[id=btn_batal]").click(function(){
            window.location = '<?php echo active_module_url();?>laporan/';
        });

    });
</script>
