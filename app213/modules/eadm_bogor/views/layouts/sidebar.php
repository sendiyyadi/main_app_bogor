<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="<?= active_module_url(); ?>" class="logo">
            <span class="logo-sm">
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" alt="" height="33">
                <span class="ms-1 fw-bold text-dark">MAIN APP BOGOR</span>
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
                        <a href="<?= active_module_url(); ?>main">
                            <i class="uil-home-alt"></i>
                            <!-- <i class="uil uil-sperms"></i> -->
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <?php if (app_get_role_akses('MENU_DAFTAR_NOP', 'M') == true) { ?>
                        <?php if (app_get_role_akses('daftar_nop', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'daftar_nop' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>daftar_nop">
                                    <i class="uil uil-house-user"></i>
                                    <span class="">Daftar NOP Baru</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_REG_ESPPT', 'M') == true) { ?>
                        <?php if (app_get_role_akses('reg_esppt', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'reg_esppt' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>reg_esppt">
                                    <i class="uil uil-file-plus-alt"></i>
                                    <span class="">Registrasi E-SPPT</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_PRM_ONLINE', 'M') == true) { ?>
                        <?php if (app_get_role_akses('permohonan_online', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'permohonan_online' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>permohonan_online">
                                    <i class="uil uil-cloud-upload"></i>
                                    <span class="">Permohonan Online</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_NOP_PROGRESSIVE', 'M') == true) { ?>
                        <?php if (app_get_role_akses('nop_prog', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'nop_prog' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>nop_prog">
                                    <i class="uil uil-image-plus"></i>
                                    <span class="">NOP Progressive</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_SPPT_BSRE', 'M') == true) { ?>
                      <?php if (app_get_role_akses('sppt_bsre', 'T') == true) { ?>
                        <li class="nav-item <?php echo $page_menu == 'sppt_bsre' ? 'active' : ''; ?>">
                          <a class="nav-link" href="<?php echo active_module_url() ?>sppt_bsre">
                            <i class="uil uil-file-check"></i>
                            <span class="">Approve SPPT BSRE</span></a>
                          </li>
                      <?php } ?>
                    <?php } ?>


                    <?php if (app_get_role_akses('MENU_KIRIM_SPPT', 'M') == true) { ?>
                      <?php if (app_get_role_akses('kirim_sppt', 'T') == true) { ?>
                        <li class="nav-item <?php echo $page_menu == 'kirim_sppt' ? 'active' : ''; ?>">
                          <a class="nav-link" href="<?php echo active_module_url() ?>kirim_sppt">
                            <i class="uil uil-file-export"></i>
                            <span class="">Kirim SPPT</span></a>
                          </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_LOG_KIRIM_SPPT', 'M') == true) { ?>
                      <?php if (app_get_role_akses('log_kirim_sppt', 'T') == true) { ?>
                        <li class="nav-item <?php echo $page_menu == 'log_kirim_sppt' ? 'active' : ''; ?>">
                          <a class="nav-link" href="<?php echo active_module_url() ?>log_kirim_sppt">
                            <i class="uil uil-list-ul"></i>
                            <span class="">Log Kirim SPPT</span></a>
                          </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_UPDATE_REG', 'M') == true) { ?>
                        <?php if (app_get_role_akses('update_reg', 'T') == true) { ?>
                          <li class="nav-item <?php echo $page_menu == 'update_reg' ? 'active' : ''; ?>">
                              <a class="nav-link" href="<?php echo active_module_url() ?>update_reg">
                                <i class="uil uil-file-edit-alt"></i>
                              <span class="">Update Data Registrasi</span></a>
                        </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_CATATAN_PEMBAYARAN', 'M') == true) { ?>
                        <?php if (app_get_role_akses('catatan_pembayaran', 'T') == true) { ?>
                          <li class="nav-item <?php echo $page_menu == 'catatan_pembayaran' ? 'active' : ''; ?>">
                              <a class="nav-link" href="<?php echo active_module_url() ?>catatan_pembayaran">
                                <i class="uil uil-bill"></i>
                              <span class="">Catatan Pembayaran</span></a>
                        </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_LAP_PENGURANGAN_STIMULUS', 'M') == true) { ?>
                        <?php if (app_get_role_akses('lap_pengurangan_stimulus', 'T') == true) { ?>
                          <li class="nav-item <?php echo $page_menu == 'lap_pengurangan_stimulus' ? 'active' : ''; ?>">
                              <a class="nav-link" href="<?php echo active_module_url() ?>lap_pengurangan_stimulus">
                                <i class="uil uil-file-minus-alt"></i>
                              <span class="">Lap Pengurangan Stimulus</span></a>
                        </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_LAP_PENGHAPUSAN_PIUTANG', 'M') == true) { ?>
                        <?php if (app_get_role_akses('lap_penghapusan_piutang', 'T') == true) { ?>
                          <li class="nav-item <?php echo $page_menu == 'lap_penghapusan_piutang' ? 'active' : ''; ?>">
                              <a class="nav-link" href="<?php echo active_module_url() ?>lap_penghapusan_piutang">
                                <i class="uil uil-file-times-alt"></i>
                              <span class="">Lap Penghapusan Piutang</span></a>
                        </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_LAP_PENGHAPUSAN_PAJAK_2025', 'M') == true) { ?>
                        <?php if (app_get_role_akses('lap_penghapusan_pajak_2025', 'T') == true) { ?>
                          <li class="nav-item <?php echo $page_menu == 'lap_penghapusan_pajak_2025' ? 'active' : ''; ?>">
                              <a class="nav-link" href="<?php echo active_module_url() ?>lap_penghapusan_pajak_2025">
                                <i class="uil uil-file-redo-alt"></i>
                              <span class="">Lap Pembebasan Pajak</span></a>
                        </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_LAP_PENGHAPUSAN_DENDA_ADM', 'M') == true) { ?>
                        <?php if (app_get_role_akses('lap_penghapusan_denda_adm', 'T') == true) { ?>
                          <li class="nav-item <?php echo $page_menu == 'lap_penghapusan_denda_adm' ? 'active' : ''; ?>">
                              <a class="nav-link" href="<?php echo active_module_url() ?>lap_penghapusan_denda_adm">
                                <i class="uil uil-file-times"></i>
                              <span class="">Lap Penghapusan Sanksi Administratif</span></a>
                        </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_REFERENSI', 'M') == true) { ?>
                        <li class="<?= $current == 'referensi'  ? 'mm-active' : ''; ?>">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-setting"></i>
                                <span>Referensi</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">

                                <?php if (app_get_role_akses('menu_kecamatan', 'T') == true) { ?>
                                    <li class="<?= isset($current_child) ? ($current_child == 'ref_kecamatan' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('kecamatan'); ?>">Kecamatan</a></li>
                                <?php } ?>

                                <?php if (app_get_role_akses('menu_kelurahan', 'T') == true) { ?>
                                    <li class="<?= isset($current_child) ? ($current_child == 'ref_kelurahan' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('kelurahan'); ?>">Kelurahan</a></li>
                                <?php } ?>

                                <?php if (app_get_role_akses('menu_lampiran_pelayanan', 'T') == true) { ?>
                                    <li class="<?= isset($current_child) ? ($current_child == 'ref_lampiran_pelayanan' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('lampiran_pelayanan'); ?>">Lampiran Pelayanan</a></li>
                                <?php } ?>
                            </ul>

                        </li>
                    <?php } ?>

                <?php } ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>