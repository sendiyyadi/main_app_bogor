<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/sidebar'); ?>

<style>
    body {
       
        background-image: url(<?= base_url('assets/img/BGG.jpg'); ?>);
        background-size: cover;
        background-position: center;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0" style="color:white;">Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);" style="color:white;">PBBM Bogor</a>
                                </li>
                                <li class="breadcrumb-item active" style="color:white;">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center gap-2 justify-content-center" style="margin-top: -50px;">
                <div class="input-group w-auto">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-end-0">Kecamatan</span>
                    </div>
                    <select id="kec_kd" name="kec_kd" class="input form-control select2" style="width:250px;"><?php echo $kecamatans; ?></select>
                </div>
                <div class="input-group w-auto">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-end-0">Kelurahan</span>
                    </div>
                    <select id="kel_kd" name="kel_kd" class="input form-control select2" style="width:250px;"><?php echo $kelurahans; ?></select>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="text-center">
                <h3 style="color:white;">Penerimaan Pembayaran PBB</h3>
                <h5 style="color:white;">Tahun 2025</h5>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup" id="amt_daily">menghitung...</span></h4>
                        <p class="text-muted mb-0">Hari ini</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup" id="amt_weekly">menghitung...</span></h4>
                        <p class="text-muted mb-0">Minggu ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup" id="amt_monthly">menghitung...</span></h4>
                        <p class="text-muted mb-0">Bulan ini</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup" id="amt_yearly">menghitung...</span></h4>
                        <p class="text-muted mb-0">Tahun ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="text-center">
                <h3 style="color:white;">Kelompok</h3>
                <!-- <h5>Tahun 2025</h5> -->
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup" id="tetap">menghitung...</span></h4>
                        <p class="text-muted mb-0">Ketetapan <?php echo $tahun; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup" id="pokok">menghitung...</span></h4>
                        <p class="text-muted mb-0">Realisasi Pokok</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup" id="piutang">menghitung...</span></h4>
                        <p class="text-muted mb-0">Realisasi Piutang</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1">Rp. <span data-plugin="counterup" id="denda">menghitung...</span></h4>
                        <p class="text-muted mb-0">Realisasi Denda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 100px;"></div>

    <?= $this->load->view('layouts/foot'); ?>
</div>

<?= $this->load->view('layouts/scripts'); ?>

<script>
    function get_realisasi() {
        var kec_kd = "<?php echo $kec_kd; ?>";
        var kel_kd = "<?php echo $kel_kd; ?>";
        var params = "kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;

        $.ajax({
            url: "<?php echo active_module_url($this->uri->segment(2)) ?>get_realisasi?" + params,
            async: true,
            success: function(j) {

                //alert(j);
                var data = $.parseJSON(j);
                $('#amt_daily').html(data['amt_daily']);
                $('#amt_weekly').html(data['amt_weekly']);
                $('#amt_monthly').html(data['amt_monthly']);
                $('#amt_yearly').html(data['amt_yearly']);

                $('#tetap').html(data['tetap']);
                $('#pokok').html(data['pokok']);
                $('#piutang').html(data['piutang']);
                $('#denda').html(data['denda']);

                // var angka = data['tetap'].replace(/\./g, '');
                // $('#tetap').html(angka);

                // $('#amt_daily').counterUp({
                //     delay: 10,
                //     time: 1000
                // });
                // $('#amt_weekly').counterUp({
                //     delay: 10,
                //     time: 1000
                // });
                // $('#amt_monthly').counterUp({
                //     delay: 10,
                //     time: 1000
                // });
                // $('#amt_yearly').counterUp({
                //     delay: 10,
                //     time: 1000
                // });

                // $('#tetap').counterUp({
                //     delay: 10,
                //     time: 1000
                // });

                // $('#pokok').counterUp({
                //     delay: 10,
                //     time: 1000
                // });
                // $('#piutang').counterUp({
                //     delay: 10,
                //     time: 1000
                // });
                // $('#denda').counterUp({
                //     delay: 10,
                //     time: 1000
                // });
            },
            error: function(xhr, desc, er) {
                alert(er);
            }
        });
    }


    $(document).ready(function() {
        $("#kec_kd, #kel_kd, #tahun, #buku").change(function() {
            var kec_kd = $("#kec_kd").val();
            var params = "kec_kd=" + kec_kd;

            if ($(this).attr('id') == 'kel_kd')
                params = params + "&kel_kd=" + $(this).val();

            window.location = "<?php echo active_module_url(); ?>?" + params;

        });

        get_realisasi();
    });

    // $('.counter').counterUp();
</script>

<?= $this->load->view('layouts/footer'); ?>