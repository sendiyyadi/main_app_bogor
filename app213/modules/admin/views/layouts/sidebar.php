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
                <!-- <li class="menu-title">Menu</li> -->
                <li>
                    <a href="<?= active_module_url(); ?>">
                        <i class="uil-home-alt"></i><span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= $current == 'settings'  ? 'mm-active' : ''; ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_app_form' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('apps'); ?>">Aplikasi</a></li>
                    </ul>
                </li>
                <!-- <li class="menu-title">Pengaturan</li> -->
                <li class="<?= $current == 'settings'  ? 'mm-active' : ''; ?>">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-users-alt"></i>
                        <span>User & Privileges</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_user_form' ? 'mm-active' : '') : ''; ?>">
                            <a href="<?= active_module_url('users'); ?>">Users</a>
                        </li>
                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_group_form' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('groups'); ?>">Group Users</a></li>
                        <li class="<?= isset($current_child) ? ($current_child == 'users_groups_privileges_form' ? 'mm-active' : '') : ''; ?>"><a href="<?= active_module_url('privileges'); ?>">Group Privileges</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>