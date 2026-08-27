<body id="page-top">

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
        <?php if (app_get_role_akses('MENU_UPT', 'M') == true) { ?>

          <li class="nav-item<?php echo $page_menu == 'upt' ? ' active' : ''; ?>">
              <a class="nav-link<?php echo $page_menu == 'upt' ? '' : ' collapsed'; ?>" href="#" data-toggle="collapse"
                 data-target="#collapseUPT" aria-expanded="true" aria-controls="collapseUPT">
                  <i class="fas fa-fw fa-cog"></i>
                  <span>UPT</span>
              </a>
              <div id="collapseUPT" class="collapse <?php echo $page_menu == 'upt' ? 'show' : ''; ?>"
                   aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">

                      <?php if (app_get_role_akses('permohonan_online_upt', 'T') == true) { ?>
                          <a class="collapse-item <?php echo $current == 'permohonan_online_upt' ? 'active' : ''; ?>"
                             href="<?php echo active_module_url() ?>permohonan_online_upt">Permohonan Online</a>
                      <?php } ?>
                      <?php if (app_get_role_akses('monitoring_permo_upt', 'T') == true) { ?>
                          <a class="collapse-item <?php echo $current == 'monitoring_permo_upt' ? 'active' : ''; ?>"
                            href="<?php echo active_module_url() ?>monitoring_permo_upt">Monitoring</a>
                      <?php } ?>


                  </div>
              </div>
          </li>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_LOKET', 'M') == true) { ?>
            <?php if (app_get_role_akses('loket_permohonan_online_upt', 'T') == true) { ?>
                <li class="nav-item <?php echo $page_menu == 'loket_permohonan_online_upt' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo active_module_url() ?>loket_permohonan_online_upt">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="">LOKET PERMOHONAN ONLINE UPT</span></a>
                </li>
            <?php } ?>
        <?php } ?>

        <!-- Nav Item - Charts -->
        <?php if (app_get_role_akses('MENU_UPDATE_SPPT', 'M') == true) { ?>
            <?php if (app_get_role_akses('update_sppt', 'T') == true) { ?>
                <li class="nav-item <?php echo $page_menu == 'update_sppt' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo active_module_url() ?>update_sppt">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="">UPDATE STATUS SPPT</span></a>
                </li>
            <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_DAFNOM', 'M') == true) { ?>
            <?php if (app_get_role_akses('dafnom', 'T') == true) { ?>
                <li class="nav-item <?php echo $page_menu == 'dafnom' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo active_module_url() ?>dafnom">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="">REKAP DAFNOM</span></a>
                </li>
            <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_UPDATE_DAFNOM', 'M') == true) { ?>
            <?php if (app_get_role_akses('update_dafnom', 'T') == true) { ?>
                <li class="nav-item <?php echo $page_menu == 'update_dafnom' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo active_module_url() ?>update_dafnom">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="">UPDATE DAFNOM</span></a>
                </li>
            <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_REKAM_BAYAR_SPPT', 'M') == true) { ?>
            <?php if (app_get_role_akses('rekam_bayar_sppt', 'T') == true) { ?>
                <li class="nav-item <?php echo $page_menu == 'rekam_bayar_sppt' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo active_module_url() ?>rekam_bayar_sppt">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="">REKAM BAYAR SPPT</span></a>
                </li>
            <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_CEK_SPPT', 'M') == true) { ?>
            <?php if (app_get_role_akses('cek_sppt', 'T') == true) { ?>
                <li class="nav-item <?php echo $page_menu == 'cek_sppt' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo active_module_url() ?>cek_sppt">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="">CEK SPPT</span></a>
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
                <span class="">SIMULASI SPPT</span></a>
              </li>
          <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_SIMULASI_SPPT_DAFNOM', 'M') == true) { ?>
          <?php if (app_get_role_akses('simulasi_sppt_dafnom', 'T') == true) { ?>
            <li class="nav-item <?php echo $page_menu == 'simulasi_sppt_dafnom' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo active_module_url() ?>simulasi_sppt_dafnom">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span class="">SIMULASI SPPT DAFNOM</span></a>
              </li>
          <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_PERMOHONAN_ONLINE', 'M') == true) { ?>
          <?php if (app_get_role_akses('permohonan_online', 'T') == true) { ?>
            <li class="nav-item <?php echo $page_menu == 'permohonan_online' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo active_module_url() ?>permohonan_online">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span class="">PERMOHONAN ONLINE UPT</span></a>
              </li>
          <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_MONITORING_PELAYANAN', 'M') == true) { ?>
          <?php if (app_get_role_akses('monitoring_pelayanan', 'T') == true) { ?>
            <li class="nav-item <?php echo $page_menu == 'monitoring_pelayanan' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo active_module_url() ?>monitoring_pelayanan">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span class="">MONITORING PELAYANAN UPT</span></a>
              </li>
          <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_EDIT_BAYAR_SPPT', 'M') == true) { ?>
          <?php if (app_get_role_akses('edit_bayar_sppt', 'T') == true) { ?>
            <li class="nav-item <?php echo $page_menu == 'edit_bayar_sppt' ? 'active' : ''; ?>">
              <a class="nav-link" href="<?php echo active_module_url() ?>edit_bayar_sppt">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span class="">EDIT BAYAR SPPT</span></a>
              </li>
          <?php } ?>
        <?php } ?>

        <?php if (app_get_role_akses('MENU_INFO_RINCI_PBB', 'M') == true) { ?>
            <?php if (app_get_role_akses('info_rinci_pbb', 'T') == true) { ?>
                <li class="nav-item <?php echo $page_menu == 'info_rinci_pbb' ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo active_module_url() ?>info_rinci_pbb">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span class="">SPPT RINCI</span>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>

        <li class="nav-item <?php echo $current=='back_portal' ? 'active' : '';?>" >
          <a class="nav-link" href="<?php echo base_url().'back_portal';?>">
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
