<style>
#sidebar-menu ul li ul.sub-menu li ul.sub-menu li a {
    padding: .4rem 1.5rem .4rem 4.5rem;
    font-size: 12px !important;
}
</style>
<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="<?= active_module_url(); ?>" class="logo">
            <span class="logo-sm">
                <img src="<?= base_url('assets/img/eadm-logo.png'); ?>" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url('assets/img/eadm-logo.png'); ?>" alt="" height="33">
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
                            <!-- <i class="uil-home-alt"></i> -->
                            <i class="uil uil-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <?php if (app_get_role_akses('MENU_UPT', 'M') == true) { ?>
                        <li class="<?= $current == 'upt'  ? 'mm-active' : ''; ?> hidden">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-setting"></i>
                                <span>UPT</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app_get_role_akses('permohonan_online_upt', 'T') == true) { ?>
                                    <li class="<?= isset($current_child) ? ($current_child == 'permohonan_online_upt' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('permohonan_online_upt'); ?>">Permohonan Online</a></li>
                                <?php } ?>

                                <?php if (app_get_role_akses('monitoring_permo_upt', 'T') == true) { ?>
                                    <li class="<?= isset($current_child) ? ($current_child == 'monitoring_permo_upt' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('monitoring_permo_upt'); ?>">Monitoring</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (app_get_role_akses('MENU_LOKET', 'M') == true) { ?>
                        <?php if (app_get_role_akses('loket_permohonan_online_upt', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'loket_permohonan_online_upt' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>loket_permohonan_online_upt">
                                    <i class="uil uil-store"></i>
                                    <span class="">LOKET ONLINE</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_PENDANIL', 'M') == true) { ?>
                        <li class="<?= $current == 'pendanil'  ? 'mm-active' : ''; ?>">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil uil-clipboard-notes"></i>
                                <span>PENDANIL</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php //if (app_get_role_akses('pdl_pembetulan', 'T') == true) { ?>
                                    <!-- <li class="<?= isset($current_child) ? ($current_child == 'pdl_pembetulan' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('pdl_pembetulan'); ?>">Pembetulan</a></li> -->

                                    <li class="">
                                        <a href="javascript:void(0);" class="has-arrow">
                                            Pembetulan
                                        </a>

                                        <ul class="sub-menu">
                                            <?php if (app_get_role_akses('pdl_pembetulan', 'T') == true) { ?>
                                            <li>
                                                <a href="<?= active_module_url('pdl_pembetulan'); ?>">
                                                    Verifikasi
                                                </a>
                                            </li>
                                            <?php } ?>
                                            <?php if (app_get_role_akses('pdl_pembetulan_kasubid', 'T') == true) { ?>
                                            <li>
                                                <a href="<?= active_module_url('pdl_pembetulan_kasubid'); ?>">
                                                    Kasubid
                                                </a>
                                            </li>
                                            <?php } ?>
                                            <?php if (app_get_role_akses('pdl_pembetulan_kabid', 'T') == true) { ?>
                                            <li>
                                                <a href="<?= active_module_url('pdl_pembetulan_kabid'); ?>">
                                                    Kabid
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </li>

                                <?php //} ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_VERIFIKASI', 'M') == true) { ?>
                        <li class="<?= $current == 'verifikasi'  ? 'mm-active' : ''; ?>">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil uil-clipboard-notes"></i>
                                <span>VERIFIKASI</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php if (app_get_role_akses('pdl_mutasi_habis', 'T') == true) { ?>
                                    <li class="<?= isset($current_child) ? ($current_child == 'pdl_mutasi_habis' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('pdl_mutasi_habis'); ?>">Mutasi Habis</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_BID_KEBERATAN', 'M') == true) { ?>
                        <li class="<?= $current == 'bid_keberatan'  ? 'mm-active' : ''; ?>">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil uil-balance-scale"></i>
                                <span>KEBERATAN</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php //if (app_get_role_akses('bid_keberatan_pembetulan', 'T') == true) { ?>
                                    <!-- <li class="<?= isset($current_child) ? ($current_child == 'bid_keberatan_pembetulan' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('bid_keberatan_pembetulan'); ?>">Pembetulan</a></li> -->
                                <?php //} ?>

                                <li class="">
                                    <a href="javascript:void(0);" class="has-arrow">
                                        Pembetulan
                                    </a>

                                    <ul class="sub-menu">
                                        
                                        <?php if (app_get_role_akses('bid_keberatan_pembetulan_verif', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pembetulan_verif'); ?>">
                                                Verifikasi
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('bid_keberatan_pembetulan', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pembetulan'); ?>">
                                                Koordinator
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('bid_keberatan_pembetulan_kasubid', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pembetulan_kasubid'); ?>">
                                                Kasubid
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('bid_keberatan_pembetulan_kabid', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pembetulan_kabid'); ?>">
                                                Kabid
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('bid_keberatan_pembetulan_sekban', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pembetulan_sekban'); ?>">
                                                Sekban
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('bid_keberatan_pembetulan_kaban', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pembetulan_kaban'); ?>">
                                                Kaban
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                <?php if (app_get_role_akses('bid_keberatan_angsuran', 'T') == true) { ?>
                                    <li class="<?= isset($current_child) ? ($current_child == 'bid_keberatan_angsuran' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('bid_keberatan_angsuran'); ?>">Angsuran</a></li>
                                <?php } ?>

                                <li class="">
                                    <a href="javascript:void(0);" class="has-arrow">
                                        Pengurangan
                                    </a>

                                    <ul class="sub-menu">
                                        <?php //if (app_get_role_akses('bid_keberatan_pengurangan', 'T') == true) { ?>
                                        <!-- <li>
                                            <a href="<?= active_module_url('bid_keberatan_pengurangan'); ?>">
                                                Koordinator
                                            </a>
                                        </li> -->
                                        <?php //} ?>
                                        <?php if (app_get_role_akses('bid_keberatan_pengurangan_verif', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pengurangan_verif'); ?>">
                                                Verifikasi
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('bid_keberatan_pengurangan_kasubid', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pengurangan_kasubid'); ?>">
                                                Kasubid
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('bid_keberatan_pengurangan_kabid', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pengurangan_kabid'); ?>">
                                                Kabid
                                            </a>
                                        </li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('bid_keberatan_pengurangan_sekban', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pengurangan_sekban'); ?>">
                                                Sekban
                                            </a>
                                        </li>
                                        <?php } ?>

                                        <?php if (app_get_role_akses('bid_keberatan_pengurangan_kaban', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('bid_keberatan_pengurangan_kaban'); ?>">
                                                Kaban
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_PENETAPAN_UPT', 'M') == true) { ?>
                        <li class="<?= $current == 'penetapan'  ? 'mm-active' : ''; ?>">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil uil-file-check-alt"></i>
                                <span>PENETAPAN</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php //if (app_get_role_akses('pnt_mutasi_habis', 'T') == true) { ?>
                                    <!-- <li class="<?= isset($current_child) ? ($current_child == 'pnt_mutasi_habis' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('pnt_mutasi_habis'); ?>">Mutasi Habis</a></li> -->
                                <?php //} ?>

                                <?php //if (app_get_role_akses('pnt_pembetulan', 'T') == true) { ?>
                                    <!-- <li class="<?= isset($current_child) ? ($current_child == 'pnt_pembetulan' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('pnt_pembetulan'); ?>">Pembetulan</a></li> -->
                                <?php //} ?>
                                <li class="">
                                    <a href="javascript:void(0);" class="has-arrow">
                                        Mutasi Habis
                                    </a>

                                    <ul class="sub-menu">
                                        <?php if (app_get_role_akses('pnt_mutasi_habis_verif', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('pnt_mutasi_habis_verif'); ?>">
                                                Verifikasi
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('pnt_mutasi_habis', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('pnt_mutasi_habis'); ?>">
                                                Penetapan
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                <li class="">
                                    <a href="javascript:void(0);" class="has-arrow">
                                        Pembetulan
                                    </a>

                                    <ul class="sub-menu">
                                        <?php if (app_get_role_akses('pnt_pembetulan_verif', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('pnt_pembetulan_verif'); ?>">
                                                Verifikasi
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('pnt_pembetulan', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('pnt_pembetulan'); ?>">
                                                Penetapan
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                <li class="">
                                    <a href="javascript:void(0);" class="has-arrow">
                                        Aktivasi SPPT
                                    </a>

                                    <ul class="sub-menu">
                                        <?php if (app_get_role_akses('pnt_aktivasi_nop_verif', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('pnt_aktivasi_nop_verif'); ?>">
                                                Verifikasi
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('pnt_aktivasi_nop', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('pnt_aktivasi_nop'); ?>">
                                                Penetapan
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                <?php if (app_get_role_akses('pnt_angsuran', 'T') == true) { ?>
                                    <li class="<?= isset($current_child) ? ($current_child == 'pnt_angsuran' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('pnt_angsuran'); ?>">Angsuran</a></li>
                                <?php } ?>

                                <li class="">
                                    <a href="javascript:void(0);" class="has-arrow">
                                        Pengurangan
                                    </a>

                                    <ul class="sub-menu">
                                        <?php if (app_get_role_akses('pnt_pengurangan_verif', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('pnt_pengurangan_verif'); ?>">
                                                Verifikasi
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if (app_get_role_akses('pnt_pengurangan', 'T') == true) { ?>
                                        <li>
                                            <a href="<?= active_module_url('pnt_pengurangan'); ?>">
                                                Penetapan
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>

                                <?php //if (app_get_role_akses('pnt_aktivasi_nop', 'T') == true) { ?>
                                    <!-- <li class="<?= isset($current_child) ? ($current_child == 'pnt_aktivasi_nop' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('pnt_aktivasi_nop'); ?>">Aktivasi SPPT</a></li> -->
                                <?php //} ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_MONITORING_PELAYANAN', 'M') == true) { ?>
                        <?php if (app_get_role_akses('monitoring_permohonan_online_upt', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'monitoring_permohonan_online_upt' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>monitoring_permohonan_online_upt">
                                    <i class="uil uil-search"></i>
                                    <span class="">MONITORING PLYNAN</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_CEK_PEM_VIRTUAL_ACC', 'M') == true) { ?>
                        <?php if (app_get_role_akses('cek_pembayaran_virtual_acc', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'cek_pembayaran_virtual_acc' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>cek_pembayaran_virtual_acc">
                                    <i class="uil-file-search-alt"></i>
                                    <span class="">CEK PEM VIRTUAL ACC</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_CEK_NIK', 'M') == true) { ?>
                        <?php if (app_get_role_akses('check_nik', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'check_nik' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>check_nik">
                                    <i class="uil-file-search-alt"></i>
                                    <span class="">CEK NIK</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_CEK_BPHTB', 'M') == true) { ?>
                        <?php if (app_get_role_akses('check_bphtb', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'check_bphtb' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>check_bphtb">
                                    <i class="uil-file-search-alt"></i>
                                    <span class="">CEK BPHTB</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_SPOP_LSPOP', 'M') == true) { ?>
                        <?php if (app_get_role_akses('spop_lspop', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'spop_lspop' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>spop_lspop">
                                    <i class="uil-file-search-alt"></i>
                                    <span class="">SPOP LSPOP</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <hr>

                    <?php if (app_get_role_akses('MENU_UPDATE_SPPT', 'M') == true) { ?>
                        <?php if (app_get_role_akses('update_sppt', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'update_sppt' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>update_sppt">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span class="">Update Status SPPT</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_DAFNOM', 'M') == true) { ?>
                        <?php if (app_get_role_akses('dafnom', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'dafnom' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>dafnom">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span class="">Rekap DAFNOM</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_UPDATE_DAFNOM', 'M') == true) { ?>
                        <?php if (app_get_role_akses('update_dafnom', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'update_dafnom' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>update_dafnom">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span class="">Update DAFNOM</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_REKAM_BAYAR_SPPT', 'M') == true) { ?>
                        <?php if (app_get_role_akses('rekam_bayar_sppt', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'rekam_bayar_sppt' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>rekam_bayar_sppt">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span class="">Rekam Bayar SPPT</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_CEK_SPPT', 'M') == true) { ?>
                        <?php if (app_get_role_akses('cek_sppt', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'cek_sppt' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>cek_sppt">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span class="">Cek SPPT</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_SK_NJOP', 'M') == true) { ?>
                        <?php if (app_get_role_akses('sk_njop', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'sk_njop' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>sk_njop">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span class="">SK NJOP</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_SIMULASI_SPPT', 'M') == true) { ?>
                      <?php if (app_get_role_akses('simulasi_sppt', 'T') == true) { ?>
                        <li class="nav-item <?php echo $page_menu == 'simulasi_sppt' ? 'active' : ''; ?>">
                          <a class="nav-link" href="<?php echo active_module_url() ?>simulasi_sppt">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">Simulasi SPPT</span></a>
                          </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_SIMULASI_SPPT_DAFNOM', 'M') == true) { ?>
                      <?php if (app_get_role_akses('simulasi_sppt_dafnom', 'T') == true) { ?>
                        <li class="nav-item <?php echo $page_menu == 'simulasi_sppt_dafnom' ? 'active' : ''; ?>">
                          <a class="nav-link" href="<?php echo active_module_url() ?>simulasi_sppt_dafnom">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">Simulasi SPPT DAFNOM</span></a>
                          </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_PERMOHONAN_ONLINE', 'M') == true) { ?>
                      <?php if (app_get_role_akses('permohonan_online', 'T') == true) { ?>
                        <li class="nav-item <?php echo $page_menu == 'permohonan_online' ? 'active' : ''; ?>">
                          <a class="nav-link" href="<?php echo active_module_url() ?>permohonan_online">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">Permohonan Online UPT</span></a>
                          </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_MONITORING_PELAYANAN', 'M') == true) { ?>
                      <?php if (app_get_role_akses('monitoring_pelayanan', 'T') == true) { ?>
                        <li class="nav-item <?php echo $page_menu == 'monitoring_pelayanan' ? 'active' : ''; ?>">
                          <a class="nav-link" href="<?php echo active_module_url() ?>monitoring_pelayanan">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">Monitoring Pelayanan UPT</span></a>
                          </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_EDIT_BAYAR_SPPT', 'M') == true) { ?>
                      <?php if (app_get_role_akses('edit_bayar_sppt', 'T') == true) { ?>
                        <li class="nav-item <?php echo $page_menu == 'edit_bayar_sppt' ? 'active' : ''; ?>">
                          <a class="nav-link" href="<?php echo active_module_url() ?>edit_bayar_sppt">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">Edit Bayar SPPT</span></a>
                          </li>
                      <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_INFO_RINCI_PBB', 'M') == true) { ?>
                        <?php if (app_get_role_akses('info_rinci_pbb', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'info_rinci_pbb' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>info_rinci_pbb">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span class="">SPPT Rinci</span>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>


                <?php } ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>