<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>

th { font-size: 15px; }
td { font-size: 14px; }


th {
    font-weight : bold
}

.text-center-vertical {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

<div class="content" style="">
    <div class="container-fluid">

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#"><strong>LAPORAN PENGURANGAN STIMULUS</strong></a>
            </li>
        </ul>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">LAPORAN PENGURANGAN STIMULUS</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">LAPORAN PENGURANGAN STIMULUS</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-horizontal">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="input-group w-auto">
                                        <div class="input-group-prepend" style="width:100px;">
                                            <span class="input-group-text rounded-end-0">Tanggal</span>
                                        </div>
                                        <input class="input form-control" id="tglawal" name="tglawal" type="text" value="<?php echo date('d-m-Y')?>"/>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-end-0">s.d</span>
                                        </div>
                                        <input class="input form-control" id="tglakhir" name="tglakhir" type="text" value="<?php echo date('d-m-Y')?>"/>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="input-group w-auto">
                                        <div class="input-group-prepend" style="width:100px;">
                                            <span class="input-group-text rounded-end-0">Tahun Pajak</span>
                                        </div>
                                        <input class="input form-control" id="thn_pjk_awal" name="thn_pjk_awal" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" type="number" value="<?php echo date('Y')?>"/>
                                    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-end-0">s.d</span>
                                        </div>
                                        <input class="input form-control" id="thn_pjk_akhir" name="thn_pjk_akhir" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" type="number" value="<?php echo date('Y')?>"/>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="input-group w-auto">
                                        <div class="input-group-prepend" style="width:100px;">
                                            <span class="input-group-text rounded-end-0">Kecamatan</span>
                                        </div>
                                        <?php echo $select_kecamatan;?>
                                    </div>
                                </div>

                                <hr>

                                <div class="control-group">
                                    <div class="controls">
                                        <button id="btnshow_rpt" class="btn btn-primary" name="btnshow_rpt">Lihat Laporan</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>


<script>

function show_rpt(){

    var tglawal = $('#tglawal').val();
    var tglakhir = $('#tglakhir').val();
    var thn_awal = $('#thn_pjk_awal').val();
    var thn_akhir = $('#thn_pjk_akhir').val();
    var kd_kecamatan = $('#kd_kecamatan').val();

    var rptparams = {
        tglawal: tglawal,
        tglakhir: tglakhir,
        thn_awal: thn_awal,
        thn_akhir: thn_akhir,
        kd_kecamatan: kd_kecamatan,
    }

    var data = decodeURIComponent($.param(rptparams));
    var url  = '<?php echo active_module_url($this->router->fetch_class());?>cetak/pdf/?'+data;
    var winparams = 'width='+screen.width+',height='+screen.height+',directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no';
    window.open(url, 'Laporan', winparams);

}

$(document).ready(function() {

    $("[id=btnshow_rpt]").click(function(){
        show_rpt($(this).data('tipelaporan'));
    });

    //validasi tanggal
    var tglawal_dtp = $('#tglawal').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    }).on('changeDate', function(ev) {
        tglawal_dtp.hide();
        validateTanggal();
    }).data('datepicker');

    var tglakhir_dtp = $('#tglakhir').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    }).on('changeDate', function(ev) {
        tglakhir_dtp.hide();
        validateTanggal();
    }).data('datepicker');

    function validateTanggal() {
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        // ubah dari dd-mm-yyyy ke objek Date
        var partsAwal = tglawal.split('-');
        var partsAkhir = tglakhir.split('-');

        var dateAwal = new Date(partsAwal[2], partsAwal[1] - 1, partsAwal[0]);
        var dateAkhir = new Date(partsAkhir[2], partsAkhir[1] - 1, partsAkhir[0]);

        if (dateAwal > dateAkhir) {
            $('#tglawal').val($('#tglakhir').val());
        }
    }

    //validasi tahun
    const thnAwal = document.getElementById('thn_pjk_awal');
    const thnAkhir = document.getElementById('thn_pjk_akhir');

    function validateYears() {
        const awal = parseInt(thnAwal.value);
        const akhir = parseInt(thnAkhir.value);

        if (awal > akhir) {
            thnAwal.value = akhir;
        }
    }

    thnAwal.addEventListener('input', validateYears);
    thnAkhir.addEventListener('input', validateYears);

});
</script>
