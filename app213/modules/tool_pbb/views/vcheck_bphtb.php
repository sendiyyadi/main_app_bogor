<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
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
                        <h4 class="mb-0">CHECK BPHTB</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Check BPHTB</li>
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
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="c_nop" class="form-control" name="c_nop" placeholder="Cari NOP">
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <button class="btn btn-primary" id="btn_cari">CARI</button>
                                </div>
                            </div>

                            <br>
                            <div style="overflow-x:auto;">
                                <div style="width:2000px; ">
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>TGL BOOKING</th>
                                                <th>NO BOOK</th>
                                                <th>NOP</th>
                                                <th>SUBJEK PAJAK</th>
                                                <th>OBJEK PAJAK</th>
                                                <th>BPHTB TERHUTANG</th>
                                                <th>SETOR</th>
                                                <th>STS</th>
                                                <th>TRACKING</th>
                                                <th>KET</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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


<script>

    var oTable;

    function reload_grid() {
        var nop = $('#c_nop').val();

        var params = {
            nop : nop,
        };

        var data_params = decodeURIComponent($.param(params));
        console.log("<?php echo active_module_url();?>check_bphtb/grid/?"+data_params);
        oTable.fnReloadAjax("<?php echo active_module_url();?>check_bphtb/grid/?"+data_params);
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
            "aoColumnDefs": [
                { "bSearchable": false, "bVisible": true, "aTargets": [ 7 ], "sWidth": "70px" },
                
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "oLanguage": {
                "sProcessing":   "<img border='0' src='<?php echo base_url('assets/pad/img/ajax-loader-big-circle-ball.gif')?>' />",
                "sLengthMenu":   "Tampilkan _MENU_ entri",
                "sZeroRecords":  "Tidak ada data",
                "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix":  "",
                "sSearch":       "Cari : ",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "&laquo;",
                    "sPrevious": "&lsaquo;",
                    "sNext":     "&rsaquo;",
                    "sLast":     "&raquo;",
                }
            },
            "sAjaxSource": "<?php echo active_module_url(); ?>check_bphtb/grid"
        });

        $("[id=btn_cari]").click(function(){
            reload_grid();
        });
    });

    

</script>