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
                        <h4 class="mb-0">DETAIL SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Detail SPPT</li>
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

                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_kec" id="prm_awal_kec" value="<?php echo $dt['prm_awal_kec']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_kel" id="prm_awal_kel" value="<?php echo $dt['prm_awal_kel']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_sts" id="prm_awal_sts" value="<?php echo $dt['prm_awal_sts']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_nop" id="prm_awal_nop" value="<?php echo $dt['prm_awal_nop']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_thn" id="prm_awal_thn" value="<?php echo $dt['prm_awal_thn']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_idp" id="prm_awal_idp" value="<?php echo $dt['prm_awal_idp']?>" />
                            
                            <div class="row">
                                <div class="col-md-8">  <!-- DATA AWAL -->
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
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="nama_wp" id="nama_wp" value="<?php echo $dt['nama_wp']?>" readonly/>
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
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="user_penyerahan" id="user_penyerahan" value="<?php echo $dt['user_penyerahan']?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Keterangan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="txt_ket" id="txt_ket" value="<?php echo $dt['txt_ket']?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">ID Piutang</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="idp" id="idp" value="<?php echo $dt['idp']?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Foto</label>
                                        </div>
                                        <div class="col-md-8">
                                            <?php if ($dt['link_foto'] == '01'){ ?>
                                                <font color="red"><strong>TIDAK ADA FILE / FOTO YANG DI UPLOAD PETUGAS</strong></font>
                                            <?php } else if ($dt['link_foto'] == '02') { ?>
                                                <font color="red"><strong>FILE / FOTO TIDAK DITEMUKAN</strong></font>
                                            <?php } else { ?>
                                                <!-- <img src="<?php //echo $dt['link_foto']?>" width="400px"> -->
                                                <a href="<?php echo $dt['link_foto']?>" target="_blank" class="btn btn-info" title="Lihat Foto" style="margin-right: 5px">Lihat Foto</a>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                                
                            </div>

                            &nbsp;
                            <div class="row control-group">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-8">
                                    <button type="button" id="btn_batal" class="btn btn-sm btn-info" >KEMBALI</button>
                                </div>
                            </div>
    
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
        window.history.replaceState({}, "", "<?php echo active_module_url();?>approve_pembatalan/detail/<?php echo $dt['nop']?>");

        $("[id=btn_batal]").click(function(){
            var nop = $('#prm_awal_nop').val();
            var thn = $('#prm_awal_thn').val();
            var kel = $('#prm_awal_kel').val();
            var kec = $('#prm_awal_kec').val();
            var sts = $('#prm_awal_sts').val();
            var idp = $('#prm_awal_idp').val();

            var params = {
              mode: 'back',
              pawal_nop: nop,
              pawal_thn: thn,
              pawal_kel: kel,
              pawal_kec: kec,
              pawal_sts: sts,
              pawal_idp: idp,
            };
            var data_params = decodeURIComponent($.param(params));

            window.location = '<?php echo active_module_url();?>approve_pembatalan/?'+data_params;


        });
        
    });
</script>
