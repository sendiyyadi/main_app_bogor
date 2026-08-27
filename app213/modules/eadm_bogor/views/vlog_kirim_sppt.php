<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">LOG KIRIM SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">LOG KIRIM SPPT</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
              <?php echo msg_block();?>
              <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <input type="text" id="c_nop" class="form-control" name="c_nop" placeholder="Cari NOP" style="width: 250px;">
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun</span>
                                    </div>
                                    <input type="text" id="c_TAHUN" class="form-control" name="c_TAHUN" placeholder="Cari Tahun">
                                </div>
                                <div class="input-group w-auto">
                                    <button onclick="reload_grid();" class="btn btn-primary" type="button">Cari</button>
                                </div>
                                
                            </div>
                            

                            <br>
                            <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>NOP</th>
                                        <th>TAHUN</th>
                                        <th>EMAIL</th>
                                        <th>STATUS</th>
                                        <th>TGL KIRIM</th>
                                    </tr>
                                </thead>
                            </table>
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
    var oTable;

    function reload_grid() {
        var nop = $('#c_nop').val();
        var tahun = $('#c_tahun').val();
        var params = {
            nop: nop,
            tahun: tahun,
        };
        var data_params = decodeURIComponent($.param(params));
        oTable.fnReloadAjax("<?php echo active_module_url(); ?>log_kirim_sppt/grid/?" + data_params);
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 1, "asc" ]],
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>log_kirim_sppt/grid"
        });

        $("[id=btn_cari]").click(function() {
          var nop = $("#c_nop").val();
          var tahun = $("#c_tahun").val();
          if(!nop){
            alert('harap mengisi nop');
          }else{
            reload_grid();
          }
        });

    });
</script>