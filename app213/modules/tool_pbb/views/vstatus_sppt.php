<!-- <?php //include_once('_head.php'); 
      ?>                CSS JS -->

<!--  versi eon -->
<?php $this->load->view('_head.php'); ?> <!-- CSS JS -->
<?php include_once('_side_menu.php'); ?> <!-- MENU SIDEBAR -->
<?php $this->load->view('_navbar'); ?> <!-- NAVBAR MENU -->
<?php $this->load->view('_js.php'); ?>

<style>

</style>
<?php //include_once('_side_menu.php'); 
?> <!-- MENU SIDEBAR -->

<?php //include_once('_navbar.php'); 
?> <!-- NAVBAR MENU -->

<div class="content" style="">
        <div class="container-fluid">

            <ul class="nav nav-tabs">
                <li class="active">
                    <!-- <h5><strong>Update Status SPPT - <?= $nop ?> - <?= $tahun ?></strong></h5> -->
                    <h5><strong>Update Status SPPT - </strong></h5>

                </li>
            </ul>

            <div class="row mt-4">
                <div class="col-md-1"> 
                    <a href="<?= base_url('/tool_pbb/update_sppt') ?>" class="btn btn-danger" id="btn_back">KEMBALI</a>
                </div>
            </div>
            <br>

        </div>
    </div>

<!-- VERSI EON -->
<!-- Footer -->
<?php $this->load->view('_foot.php'); ?>

<!-- Logout Modal-->
<?php $this->load->view('_logout_modal.php'); ?>

<!-- tambahan datatables -->
<script>
  
</script>