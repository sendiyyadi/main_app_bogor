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
                        <h4 class="mb-0">PROSES PERUBAHAN ALAMAT SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Proses Perubahan Alamat SPPT</li>
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
                                <div class="col-md-6">
                                    <h2> Data Awal </h2>
                                </div>
                                <div class="col-md-6">
                                    <h2> Data Perubahan </h2>
                                </div>
                            </div>

                            <?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal'));?>
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="id" id="id" value="<?php echo $dt[ID_DSP]?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_kec" id="prm_awal_kec" value="<?php echo $dt['prm_awal_kec']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_kel" id="prm_awal_kel" value="<?php echo $dt['prm_awal_kel']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_sts" id="prm_awal_sts" value="<?php echo $dt['prm_awal_sts']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_nop" id="prm_awal_nop" value="<?php echo $dt['prm_awal_nop']?>" />
                            <input class="input form-control" type="hidden" style="margin-right: 5px;" name="prm_awal_thn" id="prm_awal_thn" value="<?php echo $dt['prm_awal_thn']?>" />
                            <div class="row">
                                <div class="col-md-6">  <!-- DATA AWAL -->
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Nama WP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="nama_wp" id="nama_wp" value="<?php echo $dt[NM_WP_SPPT_D]?>" readonly/>
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kecamatan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kec_wp_a" id="kec_wp_a" value="<?php echo $dt[KECAMATAN_WP_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kelurahan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kel_wp_a" id="kel_wp_a" value="<?php echo $dt[KELURAHAN_WP_NM_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">RT</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="rt_wp_a" id="rt_wp_a" value="<?php echo $dt[RT_WP_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">RW</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="rw_wp_a" id="rw_wp_a" value="<?php echo $dt[RW_WP_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Alamat</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="alamat_wp_a" id="alamat_wp_a" value="<?php echo $dt[JALAN_WP_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <!-- OP -->
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kecamatan OP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kec_op_a" id="kec_op_a" value="<?php echo $dt[KECAMATAN_OP_NM_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kelurahan OP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kel_op_a" id="kel_op_a" value="<?php echo $dt[KELURAHAN_OP_NM_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">RT</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="rt_op_a" id="rt_op_a" value="<?php echo $dt[RT_OP_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">RW</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="rw_op_a" id="rw_op_a" value="<?php echo $dt[RW_OP_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Alamat</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="alamat_op_a" id="alamat_op_a" value="<?php echo $dt[JALAN_OP_OLD_DSP]?>" readonly />
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">  <!-- DATA PERUBAHAN -->
                                <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Nama WP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="nama_wp_a" id="nama_wp_a" value="<?php echo $dt[NM_WP_SPPT_D]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kecamatan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kec_wp_b" id="kec_wp_b" value="<?php echo $dt[KECAMATAN_WP_NM_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kelurahan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kel_wp_b" id="kel_wp_b" value="<?php echo $dt[KELURAHAN_WP_NM_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">RT</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="rt_wp_b" id="rt_wp_b" value="<?php echo $dt[RT_WP_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">RW</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="rw_wp_b" id="rw_wp_b" value="<?php echo $dt[RW_WP_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Alamat</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="alamat_wp_b" id="alamat_wp_b" value="<?php echo $dt[JALAN_WP_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <!-- OP -->
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kecamatan OP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kec_op_b" id="kec_op_b" value="<?php echo $dt[KECAMATAN_OP_NM_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Kelurahan OP</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="kel_op_b" id="kel_op_b" value="<?php echo $dt[KELURAHAN_OP_NM_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">RT</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="rt_op_b" id="rt_op_b" value="<?php echo $dt[RT_OP_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">RW</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="rw_op_b" id="rw_op_b" value="<?php echo $dt[RW_OP_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row control-group" style="margin-bottom:5px">
                                        <div class="col-md-3">
                                            <label class="control-label" style="vertical-align:sub">Alamat</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="input form-control" type="text" style="margin-right: 5px;" name="alamat_op_b" id="alamat_op_b" value="<?php echo $dt[JALAN_OP_NEW_DSP]?>" readonly />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            &nbsp;
                            <div class="row control-group">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-8">
                                  <?php //echo $dt[STATUS_DSP] ?>
                                    <?php if($dt[STATUS_DSP] == 0){ ?>
                                      <button type="button" id="btn_tolak" class="btn btn-sm btn-primary" >TOLAK</button>
                                      <button type="submit" id="btn_approve" class="btn btn-sm btn-primary" >APPROVE</button>
                                    <?php }  ?>
                                    <button type="button" id="btn_batal" class="btn btn-sm btn-info" >KEMBALI</button>
                                </div>
                            </div>
                            </form>

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

        window.history.replaceState({}, "", "<?php echo active_module_url();?>perubahan_sppt/detail/<?php echo $dt[ID_DSP]?>");

        $("[id=btn_approve]").click(function(){
            // alert('approved');

        });

        $("[id=btn_batal]").click(function(){
            var nop = $('#prm_awal_nop').val();
            var thn = $('#prm_awal_thn').val();
            var kel = $('#prm_awal_kel').val();
            var kec = $('#prm_awal_kec').val();
            var sts = $('#prm_awal_sts').val();

            var params = {
              mode: 'back',
              pawal_nop: nop,
              pawal_thn: thn,
              pawal_kel: kel,
              pawal_kec: kec,
              pawal_sts: sts,
            };
            var data_params = decodeURIComponent($.param(params));

            window.location = '<?php echo active_module_url();?>perubahan_sppt/?'+data_params;


        });

        $("[id=btn_tolak]").click(function(){
            var id = $('#id').val();
            var nop = $('#prm_awal_nop').val();
            var thn = $('#prm_awal_thn').val();
            var kel = $('#prm_awal_kel').val();
            var kec = $('#prm_awal_kec').val();
            var sts = $('#prm_awal_sts').val();

            var params = {
              mode: 'back',
              pawal_nop: nop,
              pawal_thn: thn,
              pawal_kel: kel,
              pawal_kec: kec,
              pawal_sts: sts,
            };
            var data_params = decodeURIComponent($.param(params));
            // alert(id);
            window.location = '<?php echo active_module_url();?>perubahan_sppt/process_tolak/'+id+'/?'+data_params;
        });

    });
</script>
