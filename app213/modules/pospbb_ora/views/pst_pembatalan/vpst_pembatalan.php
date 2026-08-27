<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Pembatalan Pembayaran Khusus</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Pembayaran Khusus</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="<?= active_module_url('pst_pembatalan'); ?>">Pembatalan</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (validation_errors()) {
                echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
                echo validation_errors('<small style="color:red;">', '</small>');
                echo '</blockquote>';
            } ?>

            <?php echo msg_block(); ?>

            <div class="row">
                <div class="col-12">
                    <?= form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Pelayanan</label>
                                        <input class="form-control" type="text" name="thn_pelayanan" id="thn_pelayanan" maxlength="4" placeholder="Masukkan Tahun">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">‎</label>
                                        <input class="form-control" type="text" name="bundel_pelayanan" id="bundel_pelayanan" maxlength="4" placeholder="Masukkan Bundel">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">‎</label>
                                        <input class="form-control" type="text" name="no_urut_pelayanan" id="no_urut_pelayanan" maxlength="3" placeholder="Masukkan No Urut">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Pembayaran Ke</label>
                                        <input class="form-control" type="text" id="pmbke" name="pmbke" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Pelayanan</label>
                                        <?= $select_jns_pel; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2" id="div_angs">
                                    <div class="mb-3">
                                        <label class="form-label">Angsuran Ke</label>
                                        <?= $select_angsuran; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label">‎</label>
                                        <input class="form-control" type="text" name="prefix" id="prefix" value="<?= $prefix ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Objek Pajak</label>
                                        <input class="form-control" type="text" name="nop" id="nop" placeholder="Masukkan NOP">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <input class="form-control" type="text" name="tahun" id="tahun" placeholder="Masukkan Tahun" maxlength="4">
                                        <input class="d-none" type="hidden" id="id_p" name="id_p" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label">ㅤ</label>
                                        <div>
                                            <button type="button" class="btn waves-effect waves-light btn-info" id="btn_cari" name="btn_cari">Cari</button>
                                            <button type="button" class="btn waves-effect waves-light btn-primary" id="btn_batal" name="btn_batal" disabled>Batal STTS</button>
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
                                <div class="col-sm-12 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">PBB Terhutang</label>
                                        <input class="form-control" type="text" name="terhutang" id="terhutang" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Denda Administrasi</label>
                                        <input class="form-control" type="text" name="denda" id="denda" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">PBB Yang Sudah Dibayar</label>
                                        <input class="form-control" type="text" name="pembayaran" id="pembayaran" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Jatuh Tempo</label>
                                        <input class="form-control" type="text" name="jthtempo" id="jthtempo" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">PBB Harus Di Bayar</label>
                                        <input class="form-control" type="text" name="sisa" id="sisa" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Pengurang</label>
                                        <input class="form-control" type="text" name="pengurangan" id="pengurangan" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="col-sm-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-danger">PBB Yang Harus Dibayar</label>
                                        <input class="form-control text-danger" type="text" name="utang" id="utang" readonly>
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
                            <input type="hidden" id="ke" name="ke" />
                            <input type="hidden" id="bayar_id" name="bayar_id" />
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<script>
    var formatter = new Intl.NumberFormat('id-ID', {
        //style: 'currency',
        //currency: 'IDR ',
        minimumFractionDigits: 0,
    });

    function chgPel() {

        if ($("#jns_pel_id").val() == '3') {
            $("#div_angs").show();
        } else {
            $("#div_angs").hide();
        }
    }

    $(document).ready(function() {

        $("#div_angs").hide();

        $("#btn_cari").click(function() {
            //
            var nopd = $("#prefix").val() + $("#nop").val();
            var thn = $("#tahun").val();
            var thn_p = $("#thn_pelayanan").val();
            var bundel_p = $("#bundel_pelayanan").val();
            var urut_p = $("#no_urut_pelayanan").val();
            var jns_p = $("#jns_pel_id").val();
            var angs_p = $("#angs_id").val();
            var pmbke = $("#pmbke").val();
            //
            //alert('vvvvv : ' + nopd);
            var params = {
                thn: thn,
                nopd: nopd,
                thn_p: thn_p,
                bdl_p: bundel_p,
                urt_p: urut_p,
                jns_p: jns_p,
                pmbke: pmbke,
                angs_p: angs_p,
            };
            var data_params = decodeURIComponent($.param(params));
            //
            if (thn_p && bundel_p && urut_p && jns_p) {

                $.ajax({
                    url: "<?php echo active_module_url('pst_pembatalan/cari') ?>" + "/?" + data_params,
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
                            //$("#pengurangan").val(data['FAKTOR_PENGURANG_SPPT']);
                            //$("#pembayaran").val(0);
                            //$("#pembayaran").val(data['JML_SPPT_YG_DIBAYAR']);
                            //$("#sisa").val(data['PBB_TERHUTANG_SPPT']);
                            //$("#pmbke").val(data['pmbke']);
                            $("#id_p").val(data['ID_P']);
                            $("#jthtempo").val(data['TGL_JATUH_TEMPO_SPPT']);
                            //$("#denda").val(data['DENDA_SPPT']);
                            //$("#utang").val(data['JML_SPPT_YG_DIBAYAR']);
                            $("#terbilang").val(data['terbilang']);
                            $("#bayar_id").val(data['bayar_id']);

                            $("#terhutang").autoNumeric('set', data['PBB_TERHUTANG_SPPT']);
                            $("#pengurangan").autoNumeric('set', data['FAKTOR_PENGURANG_SPPT']);
                            $("#sisa").autoNumeric('set', data['PBB_TERHUTANG_SPPT']);
                            $("#denda").autoNumeric('set', data['DENDA_SPPT']);
                            $("#pembayaran").autoNumeric('set', data['JML_SPPT_YG_DIBAYAR']);
                            $("#utang").autoNumeric('set', data['JML_SPPT_YG_DIBAYAR']);

                            if (data['jml_sppt_yg_dibayar'] == 0) {
                                $("#btn_batal").attr('disabled', 'disabled');
                            } else {
                                $("#btn_batal").removeAttr('disabled');
                            }

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
                            //$("#pmbke").val("");
                            $("#id_p").val("");
                            $("#jthtempo").val("");
                            $("#denda").val("");
                            $("#utang").val("");
                            $("#terbilang").val("");
                            $("#bayar_id").val("");
                            alert('Data tidak ditemukan');
                            $("#nop").focus();
                            $("#btn_batal").attr('disabled', 'disabled');
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

        $('#btn_batal').click(function() {
            //
            var sukses = 'no';
            var nop = $("#prefix").val() + $("#nop").val();
            var thn = $("#tahun").val();
            var thn_p = $("#thn_pelayanan").val();
            var bundel_p = $("#bundel_pelayanan").val();
            var urut_p = $("#no_urut_pelayanan").val();
            var jns_p = $("#jns_pel_id").val();
            var angs_p = $("#angs_id").val();
            var pmbke = $("#pmbke").val();
            var byr_id = $("#bayar_id").val();
            //
            var params = {
                nop: nop,
                thn: thn,
                thn_p: thn_p,
                bdl_p: bundel_p,
                urt_p: urut_p,
                jns_p: jns_p,
                pmbke: pmbke,
                angs_p: angs_p,
                byr_id: byr_id
            };
            var data_params = decodeURIComponent($.param(params));
            //
            if (confirm('Yakin dibatalkan')) {
                $.ajax({
                    type: 'GET',
                    url: "<?php echo active_module_url('pst_pembatalan/proses') ?>" + "/?" + data_params,
                    async: false,
                    beforeSend: function() {},
                    success: function(msg) {

                        if (msg == 'yes') {
                            alert('Data Berhasil dibatalkan.');
                            //$("#btn_cari").trigger('click');
                        } else if (msg == 'no1') {
                            alert('Data yg dibatalkan hrs dimulai Pembayaran terakhir..!');
                            //$("#btn_cari").trigger('click');
                        } else if (msg == 'no2') {
                            alert('Data yg dibatalkan hrs dimulai Pembayaran Angsuran terakhir..!');
                            //$("#btn_cari").trigger('click');
                        } else {
                            //alert('Data gagal dibatalkan.');
                            alert(msg);
                        }
                    }
                });
                return false;
            }

        });

        $('#pmbke').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            vMax: '99.99',
            mDec: '0'
        });

        $('#terhutang, #pengurangan, #sisa, #denda, #pembayaran, #utang').autoNumeric('init', {
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