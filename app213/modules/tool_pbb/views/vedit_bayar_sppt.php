<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
  table.dataTable tbody tr.row_selected {
    background-color: #B0BED9 !important;
  }

  .nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}

</style>


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Edit Bayar SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Edit Bayar SPPT</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo msg_block();?>
            <?php
                if (validation_errors()) {
                    echo '<blockquote><strong>Harap sesuaikan data berikut :</strong>';
                    echo validation_errors('<small>', '</small>');
                    echo '</blockquote>';
                }
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="c_nop" class="form-control" name="c_nop" placeholder="Cari NOP" style="width:200px">
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="c_tahun" class="form-control" name="c_tahun" placeholder="Cari Tahun">
                                    </div>
                                </div>
                                <div class="col-md-1"><button class="btn btn-primary" id="btn_cari">Cari</button></div>
                            </div>

                            <br>
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>NOP</th>
                                        <th>Tahun</th>
                                        <th>Nama WP</th>
                                        <th>Alamat WP</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Terhutang</th>
                                        <th>Pengurang</th>
                                        <th>Tagihan</th>
                                        <th>Status</th>
                                        <th>RT</th>
                                        <th>RW</th>
                                        <th>Kelurahan</th>
                                        <th>Kota</th>
                                        <th>NPWP</th>
                                        <th>Pembayaran ke</th>
                                        <th>Action</th>
                                        <!-- <th>Detail</th> -->
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


<!-- tambahan datatables -->
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
        oTable.fnReloadAjax("<?php echo active_module_url(); ?>edit_bayar_sppt/grid/?" + data_params);
    }

    $(document).ready(function() {
        oTable = $('#table1').DataTable({
            "iDisplayLength": 100,
            // "bPaginate": true,
            // "bSort": true,
            // "bInfo": true,
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 1, "asc" ]],
            "aoColumnDefs": [
                { "bSearchable": false, "bVisible": false, "aTargets": [9] },
                { "bSearchable": false, "bVisible": false, "aTargets": [10] },
                { "bSearchable": false, "bVisible": false, "aTargets": [11] },
                { "bSearchable": false, "bVisible": false, "aTargets": [12] },
                { "bSearchable": false, "bVisible": false, "aTargets": [13] },
                {
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [15],
                    "mRender": function(data, type, full) {
                        var nama = encodeURIComponent(full[2].replace(/\//g, '-'));
                        var alamat = encodeURIComponent(full[3].replace(/\//g, '-'));
                        // KAV.PRASAJA, C/5/37
                        var btn_detail = '<a href="<?php echo active_module_url()?>edit_bayar_sppt/detail/'+full[0]+'/'+full[1]+'/'+nama+'/'+alamat+'/'+full[9]+'/'+full[10]+'/'+full[11]+'/'+full[12]+'/'+full[13]+'/'+full[14]+'" type="button" class="btn btn-primary" target="_blank">Detail</a>';
                        return btn_detail;
                    }
                },
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>edit_bayar_sppt/grid"
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

        // $("[id=btn_tes]").click(function() {
        //   var tahun = $("#c_tahun").val();
        //   alert(tahun);
        // });

    });
</script>