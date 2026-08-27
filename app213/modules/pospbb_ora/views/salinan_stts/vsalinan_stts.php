<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Salinan STTS</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">STTS</a>
                                </li>
                                <li class="breadcrumb-item active">Salinan STTS</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block(); ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Objek Pajak</label>
                                        <input class="form-control" type="text" name="nop" id="nop" placeholder="Masukkan NOP">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <input class="form-control" type="text" name="tahun" id="tahun" placeholder="Masukkan Tahun">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label">Ke</label>
                                        <input class="form-control" type="text" name="ke" id="ke">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label">ㅤ</label>
                                        <div>
                                            <button type="button" class="btn waves-effect waves-light btn-info" id="btn_cari" name="btn_cari">Cari</button>
                                            <button type="button" class="btn waves-effect waves-light btn-success" id="btn_ctk_draft" name="btn_ctk_draft" disabled>Cetak (Draft)</button>
                                            <button type="button" class="btn waves-effect waves-light btn-success" id="btn_ctk_bank_draft" name="btn_ctk_bank_draft" disabled>Cetak Bank (Draft)</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Wajib Pajak</label>
                                        <input class="form-control" type="text" name="nm_wp" id="nm_wp" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Alamat Wajib Pajak</label>
                                        <input class="form-control" type="text" name="jln_wp" id="jln_wp" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label">RT</label>
                                        <input class="form-control" type="text" name="rt_wp" id="rt_wp" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label">RW</label>
                                        <input class="form-control" type="text" name="rw_wp" id="rw_wp" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Kelurahan</label>
                                        <input class="form-control" type="text" name="lurah_wp" id="lurah_wp" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Kota</label>
                                        <input class="form-control" type="text" name="kota_wp" id="kota_wp" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">NPWP</label>
                                        <input class="form-control" type="text" name="npwp" id="npwp" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">PBB Terhutang</label>
                                        <input class="form-control" type="text" name="terhutang" id="terhutang" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Pengurangan</label>
                                        <input class="form-control" type="text" name="pengurangan" id="pengurangan" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">PBB Yang Sudah Dibayar</label>
                                        <input class="form-control" type="text" name="pembayaran" id="pembayaran" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">PBB Harus Dibayar</label>
                                        <input class="form-control" type="text" name="sisa" id="sisa" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jatuh Tempo</label>
                                        <input class="form-control" type="text" name="jthtempo" id="jthtempo" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Denda Administrasi</label>
                                        <input class="form-control" type="text" name="denda" id="denda" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">PBB Yang Harus Dibayar</label>
                                        <input class="form-control" type="text" name="utang" id="utang" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Dengan Huruf</label>
                                        <input class="form-control" type="text" name="terbilang" id="terbilang" readonly>
                                    </div>
                                </div>
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
    $(document).ready(function() {

        $("#btn_cari").click(function() {

            $("#btn_ctk_draft, #btn_ctk_bank_draft, #btn_cetak3").attr('disabled', 'disabled');

            var nop = $("#nop").val();
            var thn = $("#tahun").val();
            var ke = $("#ke").val();

            if (nop && thn) {
                $.ajax({
                    url: "<?php echo active_module_url('salinan_stts/cari') ?>" + nop + '/' + thn + '/' + ke,
                    success: function(json) {
                        data = JSON.parse(json);
                        if (data['found'] != 0) {

                            $("#nm_wp").val(data['NM_WP_SPPT']);
                            $("#jln_wp").val(data['JLN_WP_SPPT']);
                            $("#rt_wp").val(data['RT_WP_SPPT']);
                            $("#rw_wp").val(data['RW_WP_SPPT']);
                            $("#lurah_wp").val(data['KELURAHAN_WP_SPPT']);
                            $("#kota_wp").val(data['KOTA_WP_SPPT']);
                            $("#npwp").val(data['NPWP_SPPT']);
                            //$("#terhutang").val(data['PBB_TERHUTANG_SPPT']);
                            $('#terhutang').autoNumeric('set', data['PBB_TERHUTANG_SPPT']);
                            //$("#pengurangan").val(data['FAKTOR_PENGURANG_SPPT']);
                            //$("#pengurangan").val(data['FAKTOR_PENGURANG_BAYAR']);
                            $("#pengurangan").autoNumeric('set', data['FAKTOR_PENGURANG_SPPT']);
                            $("#pembayaran").val(0);
                            //$("#sisa").val(data['PBB_TERHUTANG_SPPT']);
                            $("#sisa").autoNumeric('set', data['PBB_TERHUTANG_SPPT']);
                            $("#jthtempo").val(data['TGL_JATUH_TEMPO_SPPT']);
                            //$("#denda").val(data['DENDA_SPPT']);
                            $("#denda").autoNumeric('set', data['DENDA_SPPT']);
                            //$("#utang").val(data['JML_SPPT_YG_DIBAYAR']);
                            $("#utang").autoNumeric('set', data['JML_SPPT_YG_DIBAYAR']);
                            $("#terbilang").val(data['terbilang']);
                            $("#btn_ctk_draft, #btn_ctk_bank_draft, #btn_cetak3").removeAttr('disabled');
                        } else {
                            $("#nm_wp").val("");
                            $("#jln_wp").val("");
                            $("#rt_wp").val("");
                            $("#rw_wp").val("");
                            $("#lurah_wp").val("");
                            $("#kota_wp").val("");
                            $("#npwp").val("");
                            $("#terhutang").val("");
                            $("#pengurangan").val("");
                            $("#pembayaran").val("");
                            $("#sisa").val("");
                            $("#jthtempo").val("");
                            $("#denda").val("");
                            $("#utang").val("");
                            $("#terbilang").val("");

                            alert('Data tidak ditemukan');
                            $("#nop").focus();
                        }
                    },
                    error: function(xhr, desc, er) {
                        alert(er);
                    }
                });
            } else {
                alert('Harap mengisi NOP dan Tahun dengan benar!');
            }
        });

        $('#btn_ctk_draft').click(function() {
            var nop = $("#nop").val();
            var thn = $("#tahun").val();
            var ke = $("#ke").val();
            window.open("<?php echo active_module_url('salinan_stts/cetak_draft') ?>" + nop + '/' + thn + '/' + ke, "Cetak");
        });

        $('#btn_ctk_bank_draft').click(function() {
            var nop = $("#nop").val();
            var thn = $("#tahun").val();
            var ke = $("#ke").val();
            window.open("<?php echo active_module_url('salinan_stts/cetak_bank_draft') ?>" + nop + '/' + thn + '/' + ke, "Cetak Bank");
        });

        $('#terhutang, #pengurangan, #sisa, #denda, #utang').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            vMax: '999999999999.99',
            mDec: '0'
        });

    });

    $(document).keypress(function(event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>