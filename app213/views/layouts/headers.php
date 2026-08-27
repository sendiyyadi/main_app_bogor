<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= APP_TITLE ?></title>

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url()?>assets/img/favicon.ico">

    <link href="<?= base_url('assets/templates/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link id="bootstrap-style" href="<?= base_url('assets/templates/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('assets/templates/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link id="app-style" href="<?= base_url('assets/templates/css/app.min.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Form Advanced -->
    <link href="<?= base_url('assets/templates/libs/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/templates/libs/spectrum-colorpicker2/spectrum.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/templates/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/templates/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/templates/libs/@chenfengyuan/datepicker/datepicker.min.css'); ?>">
    <!-- datepicker css -->
    <link rel="stylesheet" href="<?= base_url('assets/templates/libs/flatpickr/flatpickr.min.css'); ?>">

    <!-- DataTables -->
    <link href="<?= base_url('assets/templates/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/templates/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?= base_url('assets/templates/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- SweetAlert -->
    <link href="<?= base_url('assets/templates/libs/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Toastr -->
    <link type="text/css" href="<?= base_url('assets/templates/libs/toastr/build/toastr.min.css'); ?>" rel="stylesheet">

    <link href="<?= base_url('assets/pad/css/datepicker.css') ?>" rel="stylesheet">

    <style>
        .table-responsive {
            margin-bottom: 0.7rem !important;
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spin-icon">
                <!-- <i class="uil-shutter-alt spin-icon"></i> -->
                <img src="<?= base_url('assets/img/img_logo.png'); ?>" class="animated bounceIn infinite slow" width="50">
            </div>
        </div>
    </div>

    <div id="layout-wrapper">

        <!-- ========== Header Start ========== -->
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?= active_module_url(); ?>" class="logo">
                            <span class="logo-sm">
                                <img src="<?= base_url('assets/img/eadm-logo.png'); ?>" alt="" height="35">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url('assets/img/eadm-logo.png'); ?>" alt="" height="33">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                </div>


                <div class="d-flex">

                    <?php if (is_super_admin() || $this->session->userdata('canchangemod')) : ?>
                        <div class="dropdown d-inline-block ms-2 d-flex align-items-center">
                            <select class="form-select waves-effect" name="app_id" id="app_id">
                                <?php if (isset($apps) && $apps) : ?>
                                    <?php if (is_super_admin()) : ?>
                                        <option value="admin">ADMIN</option>
                                    <?php endif; ?>

                                    <?php foreach ($apps as $data) : ?>
                                        <option value="<?= $data->APP_PATH; ?>" <?php if (active_module() == $data->APP_PATH) echo 'selected'; ?>><?= $data->NAMA; ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <option value="">Not configured!</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if (is_login()) : ?>
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="<?= base_url('assets/templates/images/users/profile.jpg'); ?>" alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1 fw-bold font-size-13">
                                    <?= $this->session->userdata('username'); ?>
                                    <span class="d-block text-muted text-start fw-normal">
                                    </span>
                                </span>
                                <i class="uil-angle-down d-none d-xl-inline-block font-size-15 ms-2"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo base_url() . 'admin/ubah_passport/changepwd/' . lda_user_id(); ?>">
                                    <i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">Change Password</span>
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url() . 'logout'; ?>" onclick="return confirm('Anda yakin ingin keluar dari halaman ini?');">
                                    <i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Sign out</span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </header>