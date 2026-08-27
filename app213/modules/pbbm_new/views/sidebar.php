<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="<?= active_module_url(); ?>" class="logo">
            <span class="logo-sm">
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" alt="" height="33">
                <span class="ms-1 fw-bold text-dark">PBBM Bogor</span>
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <?php if ($this->session->userdata('login')) { ?>
                    <li>
                        <a href="<?= active_module_url(); ?>">
                            <i class="uil-home-alt"></i><span>Dashboard</span>
                        </a>
                    </li>

                    <li class="<?= $current == 'dph'  ? 'mm-active' : ''; ?> ">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-database-alt "></i>
                            <span>DPH</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_entri_data' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('dph'); ?>">Entri Data</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_download_dan_posting' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('dph_posting'); ?>">Download dan Posting</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_cetak_file_keluaran' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('dph_laporan'); ?>">Cetak File Keluaran</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_gagal_transaksi' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('dph_gagal'); ?>">Gagal Transaksi</a>
                            </li>
                        </ul>
                    </li>

                    <li class="<?= $current == 'dhkp'  ? 'mm-active' : ''; ?>">
                        <a href="<?php echo active_module_url('dhkp'); ?>">
                            <i class="uil-database-alt"></i><span>DHKP</span>
                        </a>
                    </li>

                    <li class="<?= $current == 'transaksi'  ? 'mm-active' : ''; ?> ">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-money-bill "></i>
                            <span>Transaksi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_rekap_bulanan' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('tranmonths'); ?>">Rekap Bulanan</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_rekap_harian' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('transaksi/2'); ?>">Rekap Harian</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_rincian_harian' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('transaksi/1'); ?>">Rincian Harian</a>
                            </li>
                        </ul>
                    </li>

                    <li class="<?= $current == 'realisasi'  ? 'mm-active' : ''; ?> ">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-money-bill"></i>
                            <span>Realisasi</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_semua' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('realisasi'); ?>">Semua</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_lebih_bayar' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('lb'); ?>">Lebih Bayar</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_kurang_bayar' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('kb'); ?>">Kurang Bayar</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_penerimaan_pembayaran' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('pmb'); ?>">Penerimaan Pembayaran</a>
                            </li>
                        </ul>
                    </li>

                    <li class="<?= $current == 'piutang'  ? 'mm-active' : ''; ?> ">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-money-bill "></i>
                            <span>Piutang</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_piutang' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('piutang'); ?>">Piutang</a>
                            </li>
                            <li class="<?= isset($current_child) ? ($current_child == 'users_groups_piutang_per_nop' ? 'mm-active' : '') : ''; ?>">
                                <a href="<?= active_module_url('piutang_nop'); ?>">Piutang per NOP</a>
                            </li>
                        </ul>
                    </li>

                    <li class="<?= $current == 'op'  ? 'mm-active' : ''; ?>">
                        <a href="<?php echo active_module_url('op'); ?>">
                            <i class="uil-user"></i><span>Objek Pajak</span>
                        </a>
                    </li>

                    <?php if (is_super_admin()) : ?>
                        <li class="<?= $current == 'ref'  ? 'mm-active' : ''; ?> ">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-cog"></i>
                                <span>Setting</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li class="<?= isset($current_child) ? ($current_child == 'users_groups_objek_pajak' ? 'mm-active' : '') : ''; ?>">
                                    <a href="<?= active_module_url('user_pbbms'); ?>">User Area</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                <?php } ?>
            </ul>
        </div>
    </div>

</div>