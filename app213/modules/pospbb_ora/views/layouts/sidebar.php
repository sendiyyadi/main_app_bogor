<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="<?= active_module_url(); ?>" class="logo">
            <span class="logo-sm">
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" alt="" height="33">
                <span class="ms-1 fw-bold text-dark">POSPBB Bogor</span>
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        <!-- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <?php if ($this->session->userdata('login')) { ?>

                    <li>
                        <a href="<?= active_module_url(); ?>">
                            <i class="uil-home-alt"></i><span>Dashboard</span>
                        </a>
                    </li>

                    <?php if ((isset($tpnm) && $tpnm) || (is_super_admin())) { ?>

                        <?php if (app_get_role_akses('m01_mn_pemby_khusus', 'M') == true) { ?>
                            <li class="<?= $current == 'stts'  ? 'mm-active' : ''; ?>">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-money-insert"></i>
                                    <span>Pembayaran Khusus</span>
                                </a>

                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if (app_get_role_akses('m01_sm_hapus_sanksi_admin', 'S') == true) { ?>
                                        <li class="<?= $current == 'stts_c'  ? 'mm-active' : ''; ?>">
                                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                                <span>Penghapusan Sanksi</span>
                                            </a>
                                            <ul class="sub-menu" aria-expanded="false">
                                                <?php if (app_get_role_akses('pst_penghapusan_individu', 'T') == true) { ?>
                                                    <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_c_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('pst_penghapusan_individu'); ?>">Individu</a></li>
                                                <?php } ?>
                                                <?php if (app_get_role_akses('pst_penghapusan_kolektif', 'T') == true) { ?>
                                                    <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_c_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('pst_penghapusan_kolektif'); ?>">Kolektif</a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('pst_keberatan', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('pst_keberatan'); ?>">Keberatan</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('pst_angsuran', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('pst_angsuran'); ?>">Angsuran</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('pst_pembatalan', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('pst_pembatalan'); ?>">Pembatalan</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (app_get_role_akses('m02_mn_stts', 'M') == true) { ?>
                            <li class="<?= $current == 'stts'  ? 'mm-active' : ''; ?>">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-archive"></i>
                                    <span>STTS</span>
                                </a>

                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if (app_get_role_akses('sts_bayar_op', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('sts_bayar_op'); ?>">Status Pembayaran</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('bayar_by_nop_thn', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('bayar_by_nop_thn'); ?>">Cetak STTS</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('bayar_by_nop_all_thn', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('bayar_by_nop_all_thn'); ?>">Cetak STTS - Per Tahun</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('bayar_by_range_nop_thn', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('bayar_by_range_nop_thn'); ?>">Cetak STTS - Per Range</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('bayar_by_blok_thn', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('bayar_by_blok_thn'); ?>">Cetak STTS - Per Blok</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('upload_nop', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('upload_nop'); ?>">Cetak STTS - Upload NOP</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('salinan_stts', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('salinan_stts'); ?>">Salinan STTS</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('batal_pembayaran', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('batal_pembayaran'); ?>">Pembatalan STTS</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('batal_bendahara', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('batal_bendahara'); ?>">Pembatalan STTS (Bendahara)</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('rekam_bayar', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('rekam_bayar'); ?>">Rekam Bayar (Bendahara)</a></li>
                                    <?php } ?>

                                    <li class="<?= isset($current_child) ? ($current_child == 'users_groups_stts_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('tes_upload_nop'); ?>">TES - Upload NOP</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (app_get_role_akses('m03_mn_transaksi', 'M') == true) { ?>
                            <li class="<?= $current == 'stts'  ? 'mm-active' : ''; ?>">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-money-bill-stack"></i>
                                    <span>Transaksi</span>
                                </a>

                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if (app_get_role_akses('rekap_bulan', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_transaction_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('rekap_bulan'); ?>">Rekap Bulanan</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('rekap_harian', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_transaction_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('rekap_harian'); ?>">Rekap Harian</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('rincian_harian', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_transaction_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('rincian_harian'); ?>">Rincian Harian</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('rekap_user', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_transaction_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('rekap_user'); ?>">Rekap User</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('rincian_user', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_transaction_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('rincian_user'); ?>">Rincian User</a></li>
                                    <?php } ?>
                                </ul>

                            </li>
                        <?php } ?>

                        <?php if (app_get_role_akses('m04_mn_laporan', 'M') == true) { ?>
                            <li class="<?= $current == 'stts'  ? 'mm-active' : ''; ?>">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-books"></i>
                                    <span>Laporan</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <?php if (app_get_role_akses('lap_trima_harian', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_report_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('lap_trima_harian'); ?>">Laporan Harian</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('lap_batal', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_report_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url('lap_batal'); ?>">Laporan Pembatalan</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('lap_hapus_denda', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_report_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url(); ?>lap_hapus_denda">Laporan Penghapusan Sanksi Administratif</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('lap_pengurangan_covid', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_report_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url(); ?>lap_pengurangan_covid">Laporan Pengurangan (Covid-19)</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('lap_pengurangan_stimulus_2021', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_report_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url(); ?>lap_pengurangan_stimulus_2021">Laporan Pengurangan (Stimulus)</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('lap_rekam_bayar', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_report_form' ? 'mm-active' : '') : ''; ?>"><a href="<?php echo active_module_url(); ?>lap_rekam_bayar">Laporan Pembayaran Transfer</a></li>
                                    <?php } ?>
                                </ul>

                            </li>
                        <?php } ?>

                        <?php if (app_get_role_akses('m05_mn_users', 'M') == true) { ?>
                            <li class="<?= $current == 'users'  ? 'mm-active' : ''; ?>">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="uil-users-alt"></i>
                                    <span>Users</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">

                                    <?php if (app_get_role_akses('pos_user', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_users_users_form' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('pos_user'); ?>">POSPBB Users</a></li>
                                    <?php } ?>

                                    <?php if (app_get_role_akses('tp_bayar', 'T') == true) { ?>
                                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_users_tpemb_form' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('tp_bayar'); ?>">Tempat Pembayaran</a></li>
                                    <?php } ?>
                                </ul>

                            </li>
                        <?php } ?>

                    <?php } ?>

                    <li style="background-color: #CFE2F3;">
                        <a href="#">
                            <i class="uil-chat-bubble-user"></i><span><?php echo !empty($tpnm) ? "TP. " . $tpnm : 'TP Anda Tidak Valid'; ?></span>
                        </a>
                    </li>

                <?php } ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>