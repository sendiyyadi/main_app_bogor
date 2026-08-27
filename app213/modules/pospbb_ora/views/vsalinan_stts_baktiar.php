<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<script>
$(document).ready(function() {

    $("#btn_cari").click(function() {

        $("#btn_ctk_draft, #btn_ctk_bank_draft, #btn_cetak3").attr('disabled', 'disabled');

        var nop = $("#nop").val();
        var thn = $("#tahun").val();
        var ke = $("#ke").val();

        if (nop && thn) {
            $.ajax({
                url: "<?php echo active_module_url('salinan_stts/cari')?>"+nop+'/'+thn+'/'+ke,
                success: function (json) {
                    data = JSON.parse(json);
                    if(data['found']!=0) {

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
                    } 
                    else {
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
                error: function (xhr, desc, er) {
                    alert(er);
                }
            });
        } else {
            alert ('Harap mengisi NOP dan Tahun dengan benar!');
        }
    });

    $('#btn_ctk_draft').click(function() {
        var nop = $("#nop").val();
        var thn = $("#tahun").val();
        var ke  = $("#ke").val();
        window.open("<?php echo active_module_url('salinan_stts/cetak_draft')?>"+ nop+'/'+thn+'/'+ke, "Cetak");
    });

    $('#btn_ctk_bank_draft').click(function() {
        var nop = $("#nop").val();
        var thn = $("#tahun").val();
        var ke  = $("#ke").val();
        window.open("<?php echo active_module_url('salinan_stts/cetak_bank_draft')?>"+ nop+'/'+thn+'/'+ke, "Cetak Bank");
    });

    $('#terhutang, #pengurangan, #sisa, #denda, #utang').autoNumeric('init', {
        aSep: '.', aDec: ',', vMax: '999999999999.99',  mDec: '0'
    });

});

$(document).keypress(function(event){
    if (event.which == '13') {
        event.preventDefault();
    }
});
</script>

<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a data-toggle="tab" href="#transaksi"><strong>Salinan STTS</strong></a></li>
        </ul>

        <?php echo msg_block();?>

            <div class="row">
                <div class="span3">
                    <label class="staticfont">Nomor Objek Pajak</label>
                    <input class="span3" type="text" id="nop" name="nop">
                </div>
                <div class="span1" style="margin-left: 5px;">
                    <label class="staticfont">Tahun</label>
                    <input class="span1" type="text" id="tahun" name="tahun" />
                </div>

                <div class="span1" style="margin-left: 5px;">
                    <label class="staticfont">Ke</label>
                    <input class="span1" type="text" id="ke" name="ke" />
                </div>

                <div class="pull-left" style="margin-left: 5px;">
                    <label class="staticfont">&nbsp;</label>
                    <button type="button" class="btn btn-info" id="btn_cari" name="btn_cari">Cari</button>
                    <button type="button" class="btn btn-success" id="btn_ctk_draft" name="btn_ctk_draft" disabled>Cetak (Draft)</button>
                    <button type="button" class="btn btn-success" id="btn_ctk_bank_draft" name="btn_ctk_bank_draft" disabled>Cetak (Bank Draft)</button>
                    <!--button type="button" class="btn btn-success" id="btn_cetak3" name="btn_cetak3" disabled>Cetak (BANK)</button-->
                </div>
            </div>
            <hr/>

            <div class="row">
                <div class="span3">
                    <label class="staticfont">Nama Wajib Pajak</label>
                    <input class="span3" type="text" id="nm_wp" name="nm_wp" readonly />
                </div>
                <div class="span4" style="margin-left: 5px;">
                    <label class="staticfont">Alamat Wajib Pajak</label>
                    <input class="span4" type="text" id="jln_wp" name="jln_wp" readonly />
                </div>
                <div class="span1" style="margin-left: 5px;">
                    <label class="staticfont">RT</label>
                    <input class="span1" type="text" id="rt_wp" name="rt_wp" readonly />
                </div>
                <div class="span1" style="margin-left: 5px;">
                    <label class="staticfont">RW</label>
                    <input class="span1" type="text" id="rw_wp" name="rw_wp" readonly />
                </div>
            </div>

            <div class="row">
                <div class="span3">
                    <label class="staticfont">Kelurahan</label>
                    <input class="span3" type="text" id="lurah_wp" name="lurah_wp" readonly />
                </div>
                <div class="span3" style="margin-left: 5px;">
                    <label class="staticfont">Kota</label>
                    <input class="span3" type="text" id="kota_wp" name="kota_wp" readonly />
                </div>
                <div class="span2" style="margin-left: 5px;">
                    <label class="staticfont">NPWP</label>
                    <input class="span2" type="text" id="npwp" name="npwp" readonly />
                </div>
            </div>

            <div class="row">
                <div class="span2">
                    <label class="staticfont">PBB Terhutang</label>
                    <input class="span2" type="text" id="terhutang" name="terhutang" readonly />
                </div>
                <div class="span2" style="margin-left: 5px;">
                    <label class="staticfont">Pengurangan</label>
                    <input class="span2" type="text" id="pengurangan" name="pengurangan" readonly />
                </div>
                <div class="span3" style="margin-left: 5px;">
                    <label class="staticfont">PBB Yang Sudah Dibayar</label>
                    <input class="span2" type="text" id="pembayaran" name="pembayaran" readonly />
                </div>
            </div>
 
            <div class="row">
                <div class="span2">
                    <label class="staticfont">PBB Harus Dibayar</label>
                    <input class="span2" type="text" id="sisa" name="sisa" readonly />
                </div>
                <div class="span2" style="margin-left: 5px;">
                    <label class="staticfont">Jatuh Tempo</label>
                    <input class="span2" type="text" id="jthtempo" name="jthtempo" readonly />
                </div>
                <div class="span2" style="margin-left: 5px;">
                    <label class="staticfont">Denda Administrasi</label>
                    <input class="span2" type="text" id="denda" name="denda" readonly />
                </div>
            </div>

            <div class="row">
                <div class="span3">
                    <label class="staticfont">PBB Yang harus di bayar</label>
                    <input class="span2" type="text" id="utang" name="utang" readonly />
                </div>
            </div>
            <div class="row">
                <div class="span8">
                    <label class="staticfont">Dengan Huruf</label>
                    <input class="span8" type="text" id="terbilang" name="terbilang" readonly />
                </div>
            </div>


    </div>


</div>

<?php $this->load->view('_foot'); ?>