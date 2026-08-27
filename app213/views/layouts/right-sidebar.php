<div class="right-bar">
    <div data-simplebar class="h-100">

        <div class="rightbar-title d-flex align-items-center px-3 py-4">

            <h5 class="m-0 me-2">Settings</h5>

            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <hr class="mt-0" />
        <h6 class="text-center mb-0">Theme</h6>

        <div class="p-4">
            <div class="form-check form-switch mb-3">
                <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                <label class="form-check-label" for="light-mode-switch">Light Mode</label>
            </div>

            <div class="form-check form-switch mb-3">
                <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch" data-bsStyle="<?= site_url('assets/templates/css/bootstrap-dark.min.css'); ?>" data-appStyle="<?= site_url('assets/templates/css/app-dark.min.css'); ?>" />
                <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
            </div>

        </div>

    </div>
</div>
<div class="rightbar-overlay"></div>