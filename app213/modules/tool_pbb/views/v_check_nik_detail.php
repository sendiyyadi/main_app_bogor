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
                        <h4 class="mb-0">Detail: <?= $nik ?> - <?= $peps ?></h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Check NIK</li>
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

                            <div class="row mt-4">
                                <div class="col-md-1"> 
                                    <a href="<?= active_module_url('/check_nik') ?>" class="btn btn-danger" id="btn_back">KEMBALI</a>
                                </div>
                            </div>

                            <br>
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>TAHUN</th>
                                        <th>NAMA WP</th>
                                        <th>LUAS TANAH</th>
                                        <th>NJOP TANAH</th>
                                        <th>LUAS BNG</th>
                                        <th>NJOP BNG</th>
                                        <th>PBB TERHUTANG</th>
                                        <th>FAKTOR PENGURANG</th>
                                        <th>PBB YANG HARUS DIBAYAR</th>
                                        <th>STATUS PEMBAYARAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
    $(document).ready(function() {
        oTable = $('#table1').DataTable({
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>check_nik/detail_nik/<?php echo $nik; ?>/<?php echo $peps; ?>"
        });
    });
</script>