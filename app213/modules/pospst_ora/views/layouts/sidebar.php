<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="<?= active_module_url(); ?>" class="logo">
            <span class="logo-sm">
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" alt="" height="33">
                <span class="ms-1 fw-bold text-dark">POSPST Bogor</span>
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