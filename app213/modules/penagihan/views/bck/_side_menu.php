<body id="page-top">
    <!-- <div class="overlay"></div>
  <div class="spanner">
    <div class="loader"></div>
    <p>Sedang ambil data...</p>
  </div> -->

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-kir-pkl sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <!--<div class="sidebar-brand-icon rotate-n-15">-->
                    <i class="fas fa-code"></i>
                </div>
                <div class="sidebar-brand-text mx-2">ADMIN<strong></strong></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo $page_menu == 'beranda' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo active_module_url() ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span class="">Beranda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <?php if (app_get_role_akses('MENU_LIST_USER', 'M') == true) { ?>
                <?php if (app_get_role_akses('list_user', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'list_user' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>list_user">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">LIST USER</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <!-- <?php //if (app_get_role_akses('MENU_SPPT_BERMASALAH', 'M') == true) { ?>
                <?php //if (app_get_role_akses('sppt_bermasalah', 'T') == true) { ?>
                    <li class="nav-item <?php //echo $page_menu == 'sppt_bermasalah' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php //echo active_module_url() ?>sppt_bermasalah">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">SPPT BERMASALAH</span></a>
                    </li>
                <?php //} ?>
            <?php //} ?> -->

           <!--  <?php //if (app_get_role_akses('MENU_PERUBAHAN_SPPT', 'M') == true) { ?>
                <?php //if (app_get_role_akses('perubahan_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php //echo $page_menu == 'perubahan_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php //echo active_module_url() ?>perubahan_sppt">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">PERUBAHAN SPPT</span></a>
                    </li>
                <?php //} ?>
            <?php //} ?> -->

            <?php if (app_get_role_akses('MENU_PEMBETULAN_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('pembetulan_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'pembetulan_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>pembetulan_sppt">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">PEMBETULAN SPPT</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_PEMUTAKHIRAN_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('pemutakhiran_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'pemutakhiran_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>pemutakhiran_sppt">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">LAPORAN PEMUTAKHIRAN SPPT</a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_PEMBATALAN_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('pembatalan_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'pembatalan_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>pembatalan_sppt">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">PEMBATALAN SPPT</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_PEMBATALAN_SPPT_NEW', 'M') == true) { ?>
                <?php if (app_get_role_akses('pembatalan_sppt_new', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'pembatalan_sppt_new' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>pembatalan_sppt_new">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">LAPORAN PEMBATALAN SPPT</a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_APPROVE_PEMBATALAN', 'M') == true) { ?>
                <?php if (app_get_role_akses('approve_pembatalan', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'approve_pembatalan' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>approve_pembatalan">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">APPROVE PEMBATALAN</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_PROSES_LAPORAN', 'M') == true) { ?>
                <?php if (app_get_role_akses('proses_laporan', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'proses_laporan' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>proses_laporan">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">PROSES LAPORAN</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_LAPORAN', 'M') == true) { ?>
                <?php if (app_get_role_akses('laporan', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'laporan' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>laporan">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">LAPORAN</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_LAP_PERUBAHAN_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('laporan_perubahan_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'laporan_perubahan_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>laporan_perubahan_sppt">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">LAP PERUBAHAN SPPT</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_LAP_DISTRIBUSI', 'M') == true) { ?>
                <?php if (app_get_role_akses('lap_distribusi', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'lap_distribusi' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>lap_distribusi">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">LAPORAN DISTRIBUSI</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if (app_get_role_akses('MENU_LAP_SPPT', 'M') == true) { ?>
                <?php if (app_get_role_akses('lap_sppt', 'T') == true) { ?>
                    <li class="nav-item <?php echo $page_menu == 'lap_sppt' ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo active_module_url() ?>lap_sppt">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span class="">LAPORAN SPPT TERSAMPAIKAN</span></a>
                    </li>
                <?php } ?>
            <?php } ?>

            <li class="nav-item <?php echo $current == 'back_portal' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo base_url() . 'back_portal'; ?>">
                    <i class="fa fa-sign-out-alt"></i>
                    <span>Logout ke Menu Utama</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->