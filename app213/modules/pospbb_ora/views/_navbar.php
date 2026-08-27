<style>
	@media (min-width: 979px) {
		.wekeke{
			 margin-top: -2px !important;
			 width:100%;
			 position:fixed;
		}
		.navbar-inner {
			 border: 0px !important;
			 border-radius: 0px !important;
		}
	}
	.nav-tabs {
		margin-bottom: 6px;
	}
	.content {
		padding-top: 45px;
	}
</style>

<div class="navbar navbar-inverse wekeke" style="z-index:1029; ">
    <div class="navbar-inner">
        <div class="container-fluid">

			<?php if($this->session->userdata('login')) {?>
 
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li <?php echo $current=='beranda' ? 'class="active"' : '';?>><a class="brand" href="<?php echo active_module_url();?>"><?php echo strtoupper(lda_app_nama());?></a></li>

                        <?php if ((isset($tpnm) && $tpnm) || (is_super_admin())) {?>
                        
                            <?php if (app_get_role_akses('m01_mn_pemby_khusus', 'M') == true) { ?>
                                <li class="dropdown <?php echo $page_menu=='pst_pembayaran_khusus' ? 'active' : '';?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pembayaran Khusus <strong class="caret"></strong></a>
                                    <ul class="dropdown-menu">
                                        <?php if (app_get_role_akses('m01_sm_hapus_sanksi_admin', 'S') == true) { ?>
                                            <li class="dropdown-submenu">

                                            	<a href="#">Penghapusan Sanksi Adm</a>
                                            	<ul class="dropdown-menu">

                                                    <?php if (app_get_role_akses('pst_penghapusan_individu', 'T') == true) { ?>
                                                        <li class="<?php if ($current == 'pst_penghapusan_individu') {echo 'active';} ?>" >
                                                        <a href="<?php echo active_module_url('pst_penghapusan_individu');?>">Individu</a></li>
                                                    <?php } ?>

                                                    <?php if (app_get_role_akses('pst_penghapusan_kolektif', 'T') == true) { ?>
                                                        <li class="<?php if ($current == 'pst_penghapusan_kolektif') {echo 'active';} ?>" >
                                                        <a href="<?php echo active_module_url('pst_penghapusan_kolektif');?>">Kolektif</a></li>
                                                    <?php } ?>

                                            	</ul>
                                            </li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('pst_keberatan', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'pst_keberatan') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('pst_keberatan');?>">Keberatan</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('pst_angsuran', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'pst_angsuran') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('pst_angsuran');?>">Angsuran</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('pst_pembatalan', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'pst_pembatalan') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('pst_pembatalan');?>">Pembatalan</a></li>
                                        <?php } ?>

                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (app_get_role_akses('m02_mn_stts', 'M') == true) { ?>
                                <li class="dropdown <?php echo $page_menu=='m02_mn_stts' ? 'active' : '';?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">STTS<strong class="caret"></strong></a>
                                    <ul class="dropdown-menu">

                                        <?php if (app_get_role_akses('sts_bayar_op', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'sts_bayar_op') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('sts_bayar_op');?>">Status Pembayaran</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('bayar_by_nop_thn', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'bayar_by_nop_thn') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('bayar_by_nop_thn');?>">Cetak STTS</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('bayar_by_nop_all_thn', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'bayar_by_nop_all_thn') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('bayar_by_nop_all_thn');?>">Cetak STTS - Per Tahun</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('bayar_by_range_nop_thn', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'bayar_by_range_nop_thn') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('bayar_by_range_nop_thn');?>">Cetak STTS - Per Range</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('bayar_by_blok_thn', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'bayar_by_blok_thn') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('bayar_by_blok_thn');?>">Cetak STTS - Per Blok</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('upload_nop', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'upload_nop') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('upload_nop');?>">Cetak STTS - Upload NOP</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('salinan_stts', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'salinan_stts') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('salinan_stts');?>">Salinan STTS</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('batal_pembayaran', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'batal_pembayaran') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('batal_pembayaran');?>">Pembatalan STTS</a></li>
                                        <?php } ?>

                                        <li class="<?php if ($current == 'tes_upload_nop') {echo 'active';} ?>" >
                                        <a href="<?php echo active_module_url('tes_upload_nop');?>">TES - Upload NOP</a></li>



                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (app_get_role_akses('m03_mn_transaksi', 'M') == true) { ?>
                                <li class="dropdown <?php echo $page_menu=='m03_mn_transaksi' ? 'active' : '';?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transaksi <strong class="caret"></strong></a>

                                    <ul class="dropdown-menu">

                                        <?php if (app_get_role_akses('rekap_bulan', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'rekap_bulan') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('rekap_bulan');?>">Rekap Bulanan</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('rekap_harian', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'rekap_harian') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('rekap_harian');?>">Rekap Harian</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('rincian_harian', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'rincian_harian') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('rincian_harian');?>">Rincian Harian</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('rekap_user', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'rekap_user') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('rekap_user');?>">Rekap User</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('rincian_user', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'rincian_user') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('rincian_user');?>">Rincian User</a></li>
                                        <?php } ?>

                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if (app_get_role_akses('m04_mn_laporan', 'M') == true) { ?>
                                <li class="dropdown <?php echo $page_menu=='m04_mn_laporan' ? 'active' : '';?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan<strong class="caret"></strong></a>
                                    <ul class="dropdown-menu">

                                        <?php if (app_get_role_akses('lap_trima_harian', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'lap_trima_harian') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('lap_trima_harian');?>">Laporan Harian</a></li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('lap_batal', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'lap_batal') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('lap_batal');?>">Laporan Pembatalan</a></li>
                                        <?php } ?>

                                    </ul>
                                </li>
                            <?php } ?>   

                            <?php if (app_get_role_akses('m05_mn_users', 'M') == true) { ?>
                                <li class="dropdown <?php echo $page_menu=='m05_mn_users' ? 'active' : '';?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users POSPBB<strong class="caret"></strong></a>
                                    <ul class="dropdown-menu">

                                        <?php if (app_get_role_akses('pos_user', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'pos_user') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('pos_user');?>">Users</a></li>
                                        <?php } ?>

                                         <?php if (app_get_role_akses('tp_bayar', 'T') == true) { ?>
                                            <li class="<?php if ($current == 'tp_bayar') {echo 'active';} ?>" >
                                            <a href="<?php echo active_module_url('tp_bayar');?>">Tempat Pembayaran</a></li>
                                        <?php } ?>

                                    </ul>
                                </li>
                            <?php } ?> 

                        <?php }?>
                        
                        <li class="">
                            <a href="#"><span class="label-important" style="padding:3px;"><strong><?php echo !empty($tpnm) ? "TP. ".$tpnm : 'TP Anda Tidak Valid';?></strong></span></a>
                        </li>
                        
                    </ul>
                </div>
			<?php }?>
      </div>
    </div>
  </div>