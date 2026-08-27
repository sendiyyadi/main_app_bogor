<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Laporan Penghapusan Sanksi Administratif</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Laporan</a>
                                </li>
                                <li class="breadcrumb-item active">Laporan Penghapusan Sanksi Administratif</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input class="form-control" type="text" id="tglawal" name="tglawal" value="<?= date('d-m-Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">s.d</label>
                                        <input class="form-control" type="text" id="tglakhir" name="tglakhir" value="<?= date('d-m-Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Kecamatan</label>
                                        <?= $select_kecamatan; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label" for="pilih_dok">Pilih Laporan</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pilih_dok" id="pilih_dok" checked="checked" value="rinci">
                                            <label class="form-check-label" for="pilih_dok">
                                                Rincian Harian
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pilih_dok" id="pilih_dok" value="pertgl">
                                            <label class="form-check-label" for="pilih_dok">
                                                Rekapitulasi Per-Tanggal Bayar
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pilih_dok" id="pilih_dok" value="perkec">
                                            <label class="form-check-label" for="pilih_dok">
                                                Rekapitulasi Per-Kecamatan
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 float-end">
                                <button type="button" id="btnshow_rpt" name="btnshow_rpt" class="btn btn-info waves-effect waves-light">Lihat Laporan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<script>
    function show_rpt() {

        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();
        var kd_kecamatan = $('#kd_kecamatan').val();
        var pilih_dok = $("input[id='pilih_dok']:checked").val();
        var rpt = $("input[id='pilih_dok']:checked").val();

        //alert("aaaaaaaaaaaaaaaa : " + tglawal + " tglakhir : " +tglakhir + " kd_kecamatan : " + kd_kecamatan + " pilih_dok :" + pilih_dok);

        var rptparams = {
            rpt: rpt,
            tglawal: tglawal,
            tglakhir: tglakhir,
            kd_kecamatan: kd_kecamatan,
            pilih_dok: pilih_dok,
        }

        var data = decodeURIComponent($.param(rptparams));
        var url = '<?php echo active_module_url($this->router->fetch_class()); ?>cetak/pdf/?' + data;
        var winparams = 'width=' + screen.width + ',height=' + screen.height + ',directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no';
        window.open(url, 'Laporan', winparams);

    }

    function search_kelurahan(kec) {

        $.ajax({
            url: "<?php echo active_module_url() ?>lap_hapus_denda/get_kelurahan/" + kec,
            success: function(j) {
                var data = $.parseJSON(j);
                var select;
                if ($('div.tab-pane.active').has('select#kd_kelurahan')) {
                    select = $('[id=kd_kelurahan]');
                } else {
                    select = $('div.tab-pane.active select#kd_kelurahan');
                }

                select.html("");
                $.each(data, function(i, val) {
                    select.append($('<option />', {
                        value: val['kd_kelurahan'],
                        text: val['nm_kelurahan']
                    }));
                });
            },
            error: function(xhr, desc, er) {
                alert(er);
            }
        });

    }

    $(document).ready(function() {

        var tglawal_dtp = $('#tglawal').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tglawal_dtp.hide();
        }).data('datepicker');

        var tglakhir_dtp = $('#tglakhir').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tglakhir_dtp.hide();
        }).data('datepicker');

        $("[id=btnshow_rpt]").click(function() {
            show_rpt($(this).data('tipelaporan'));
        });

    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>