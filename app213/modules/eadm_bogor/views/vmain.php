<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

    <style>
        .back_rest {
            background-image: url(<?php echo base_url('assets/img/backgroud_ijo_gede.jpg'); ?>);
            padding: 20px;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 200;
            line-height: 24px;
            color: white;
            /*background-color: #98FB98;*/

            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;
		}
    </style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Dashboard E-adm Kab Bogor - <?= $this->session->userdata('groupkd') ?></h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block();?>
            <div class="row">
                <div class="col-12">

            		<div class="back_rest">
            		  <center>
              			<h2 style="color:#FFF;">BAPPENDA  <?php //echo LICENSE_TO_SUB?></h2>
              			<h3 style="color:#FFF;"><?php echo LICENSE_TO?></h3><br />
              			<img src="<?php echo app_img_logo('assets/img/semut.png')?>" alt="logo" style="max-height:300px;"><br />
            				<br /><br /><br /><P><i class="icon-star">JUJUR AMANAH RAMAH</i>  <i class="icon-star"></i></P> 
              			<!--<h2>Modul Retribusi Jasa Pemanfaatan Kekayaan Daerah</h2> -->
              			<!--<P>Module ini digunakan untuk mengelola data Kekayaan Daerah</P>-->
              			<!--<br /><br /><br /><P><i class="icon-star">JUJUR AMANAH RAMAH</i>  <i class="icon-star"></i></P>-->
            			</center>
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
