i<div class="vertical-menu">
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

                    <?php if (app_get_role_akses('MENU_LIST_USER', 'M') == true) { ?>
                        <?php if (app_get_role_akses('list_user', 'T') == true) { ?>
                            <li class="nav-item <?php echo $page_menu == 'list_user' ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo active_module_url() ?>list_user">
                                    <i class="uil uil-users-alt"></i>
                                    <span class="">List User</span></a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php if (app_get_role_akses('MENU_PEMBETULAN_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('pembetulan_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'pembetulan_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>pembetulan_sppt">
                            <i class="uil uil-file-check-alt"></i>
                            <span class="">Pembetulan SPPT</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_PEMUTAKHIRAN_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('pemutakhiran_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'pemutakhiran_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>pemutakhiran_sppt">
                            <i class="uil uil-file-search-alt"></i>
                            <span class="">Lap Pemutakhiran SPPT</a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_PEMBATALAN_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('pembatalan_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'pembatalan_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>pembatalan_sppt">
                            <i class="uil uil-folder-times"></i>
                            <span class="">Pembatalan SPPT</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_PEMBATALAN_SPPT_NEW', 'M') == true) { ?>
                <?php if (app_get_role_akses('pembatalan_sppt_new', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'pembatalan_sppt_new' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>pembatalan_sppt_new">
                            <i class="uil uil-file-times"></i>
                            <span class="">Lap Pembatalan SPPT</a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_APPROVE_PEMBATALAN', 'M') == true) { ?>
                <?php if (app_get_role_akses('approve_pembatalan', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'approve_pembatalan' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>approve_pembatalan">
                            <i class="uil uil-folder-check"></i>
                            <span class="">Aprove Pembatalan</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_PROSES_LAPORAN', 'M') == true) { ?>
                <?php if (app_get_role_akses('proses_laporan', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'proses_laporan' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>proses_laporan">
                            <i class="uil uil-file-check"></i>
                            <span class="">Proses Laporan</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_LAPORAN', 'M') == true) { ?>
                <?php if (app_get_role_akses('laporan', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'laporan' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>laporan">
                            <i class="uil uil-file-download"></i>
                            <span class="">Laporan</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_LAP_PERUBAHAN_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('laporan_perubahan_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'laporan_perubahan_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>laporan_perubahan_sppt">
                            <i class="uil uil-file-edit-alt"></i>
                            <span class="">Lap Perubahan SPPT</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_LAP_DISTRIBUSI', 'M') == true) { ?>
                <?php if (app_get_role_akses('lap_distribusi', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'lap_distribusi' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>lap_distribusi">
                            <i class="uil uil-file-share-alt"></i>
                            <span class="">Lap Distribusi</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_LAP_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('lap_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'lap_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>lap_sppt">
                            <i class="uil uil-file-check-alt"></i>
                            <span class="">Lap SPPT Tersampaikan</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

                <?php } ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>