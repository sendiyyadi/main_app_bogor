</div>

<?= $this->load->view('layouts/right-sidebar'); ?>

<!-- JAVASCRIPT -->
<script src="<?= base_url('assets/templates/libs/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/metismenu/metisMenu.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/simplebar/simplebar.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/node-waves/waves.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/waypoints/lib/jquery.waypoints.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/jquery.counterup/jquery.counterup.min.js'); ?>"></script>

<!-- Form Advanced -->
<script src="<?= base_url('assets/templates/libs/select2/js/select2.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/spectrum-colorpicker2/spectrum.min.js'); ?>"></script>
<!-- <script src="<?= base_url('assets/templates/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script> -->
<script src="<?= base_url('assets/templates/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>"></script>
<!-- <script src="<?= base_url('assets/templates/libs/@chenfengyuan/datepicker/datepicker.min.js'); ?>"></script> -->
<!-- datepicker js -->
<script src="<?= base_url('assets/templates/libs/flatpickr/flatpickr.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/js/pages/form-advanced.init.js'); ?>"></script>


<!-- Required Datatables JS -->
<script src="<?= base_url('assets/templates/libs/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<!-- Buttons examples -->
<script src="<?= base_url('assets/templates/libs/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/jszip/jszip.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/pdfmake/build/pdfmake.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/pdfmake/build/vfs_fonts.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/datatables.net-buttons/js/buttons.colVis.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatables/media/js/jquery.dataTables.ext.js') ?>"></script>
<script src="https://cdn.datatables.net/plug-ins/1.13.3/api/fnReloadAjax.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url('assets/templates/libs/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js'); ?>"></script>
<!-- Datatable init js -->
<script src="<?= base_url('assets/templates/js/pages/datatables.init.js'); ?>"></script>
<!-- Sweet Alerts js -->
<script src="<?= base_url('assets/templates/libs/sweetalert2/sweetalert2.min.js'); ?>"></script>
<!-- Sweet alert init js-->
<script src="<?= base_url('assets/templates/js/pages/sweet-alerts.init.js'); ?>"></script>
<!-- parsleyjs -->
<script src="<?= base_url('assets/templates/libs/parsleyjs/parsley.min.js'); ?>"></script>
<script src="<?= base_url('assets/templates/js/pages/form-validation.init.js'); ?>"></script>

<!-- toastr plugin -->
<script src="<?= base_url('assets/templates/libs/toastr/build/toastr.min.js'); ?>"></script>
<!-- toastr init -->
<script src="<?= base_url('assets/templates/js/pages/toastr.init.js'); ?>"></script>
<!-- form mask -->
<script src="<?= base_url('assets/templates/libs/inputmask/min/jquery.inputmask.bundle.min.js'); ?>"></script>
<!-- form mask init -->
<script src="<?= base_url('assets/templates/js/pages/form-mask.init.js'); ?>"></script>
<script src="<?= base_url('assets/templates/js/app.js'); ?>"></script>


<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?= base_url('assets/pad/js/bootstrap-datepicker.js') ?>"></script>
<!-- <script src="<?= base_url() ?>assets/jq/js/jquery-ui-1.10.2.custom.min.js"></script> -->
<script src="<?php echo base_url() ?>assets/pad/js/jquery.form.js"></script>
<script src="<?php echo base_url() ?>assets/pad/js/jquery.dialog2.js"></script>
<script src="<?php echo base_url() ?>assets/pad/js/bootstrap.file-input.js"></script>
<script src="<?= base_url('assets/pad/js/bootstrap-datepicker.js') ?>"></script>

<!-- -->
<script src="<?= base_url('assets/bootstrap/js/bootstrap-typeahead.js') ?>"></script>
<script src="<?= base_url('assets/js/numberFormatter.js') ?>"></script>
<script src="<?= base_url('assets/js/autoNumeric.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.formatter.js') ?>"></script>

<script>
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        timeOut: "2000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };


    // SweetAlert2 Toast (GLOBAL)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        background: '#d1fae5',
        color: '#065f46',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    function toastSuccess(msg) {
        Toast.fire({
            icon: 'success',
            title: msg
        });
    }

    function toastError(msg) {
        Toast.fire({
            icon: 'error',
            title: msg
        });
    }

    var timer;
    var wait = 30;
    document.onkeypress = resetTimer;
    document.onmousemove = resetTimer;

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout("logout()", 60000 * wait);
    }

    function logout() {
        <?php if (MY_ENV != 'development'): ?>
            window.location.href = '<?php echo base_url() ?>logout';
        <?php else: ?>
            resetTimer();
        <?php endif; ?>
    }

    function showAlert(title, message, type = 'warning') {
        Swal.fire({
            icon: type,
            title: title,
            text: message
        });
    }


    $(document).ready(function() {
        $('#app_id').change(function() {
            window.location = '<?php echo base_url(); ?>change_module/' + $('#app_id').val();
        });

        $('#msg_helper').delay(5000).fadeOut('slow');
        $('#modalform').on('hidden', function() {
            $(this).removeData('modal');
        });
    });
</script>