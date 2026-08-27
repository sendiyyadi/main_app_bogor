<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('date_validation'))
{
    function date_validation($date_str) {
        if (strpos($date_str, '/')==FALSE && strpos($date_str, '-')==FALSE && strpos($date_str, '.')==FALSE) {
            if (strlen($date_str)==6) {
                $date_str = substr($date_str,0,2) . '-' . substr($date_str,2,2) . '-' . substr($date_str,4,2);
            } elseif (strlen($date_str)==8) {
                $date_str = substr($date_str,0,2) . '-' . substr($date_str,2,2) . '-' . substr($date_str,4,4);
            }
        }
        $date_regex = '%\A(\d{1}|\d{2})[-/.](\d{1}|\d{2})[-/.](\d{2}|\d{4})\z%';
        $hasil = '';
        $ret= '';
        if (preg_match($date_regex, $date_str, $hasil) == TRUE) {
            if (count($hasil)==4) {
                if (strlen($hasil[3])==2) { $hasil[3] = '20' . $hasil[3]; }
                if (strlen($hasil[1])==1) { $hasil[1] = '0' . $hasil[1]; }
                if (strlen($hasil[2])==1) { $hasil[2] = '0' . $hasil[2]; }
                $ret = $hasil[3] . '-' . $hasil[2] . '-' . $hasil[1];
                if (checkdate($hasil[2], $hasil[1], $hasil[3])) {
                    return $ret;
                } else { return ''; }
            } else { return ''; }
        } else { return ''; }
    }
}

if ( ! function_exists('renbang_selected_tahun'))
{
    function renbang_selected_tahun() {
        $CI  =& get_instance();
        $thn = date('Y');
        $sTahun = $CI->session->userdata('filter_tahun');
        $ret = ($sTahun > 0) ? $sTahun : $thn;
        return $ret;
    }
}

if ( ! function_exists('renbang_html_filter_tahun'))
{
    function renbang_html_filter_tahun($id = 'filter_tahun') {
        $thn = date('Y');
        $sTahun = renbang_selected_tahun();
        $filterTahun = '';//'<label class="pull-left label-filter staticfont">Tahun</label>';
        $filterTahun .= '<select id="' . ($id != '' ? $id : 'filter_tahun') . '" class="pull-left span1" style="margin-left: 5px;">';
        for ($i = $thn; $i > $thn - 10; $i--) {
            $filterTahun .= '<option value="' . $i . '"' . ($i == $sTahun ? ' selected' : '') . '>' . $i . '</option>';
        }
        $filterTahun .= '</select>';
        return $filterTahun;
    }
}

?>