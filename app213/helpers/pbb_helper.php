<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('mintahun_sppt'))
{
    function mintahun_sppt()
    {
        $CI  =& get_instance();
        $qry =  $CI->db->query("select nvl((select min(thn_pajak_sppt) from V_SPPT), to_char(sysdate,'YYYY') ) as mintahun from dual")->row();
        $ret = $qry->MINTAHUN;
        return  $ret; 
    }
}

if (!function_exists('hitdenda')) {
    //
    function hitdenda($tagihan, $tgl)
    {
        $tgl = strtotime($tgl);
        $x   = (date('Y') - date('Y', $tgl)) * 12;
        $y   = (date('m') - date('m', $tgl));
        $z   = $x + $y + 1;
        if (date('d') <= date('d', $tgl))
            $z = $z - 1;
        if ($z < 1)
            $z = 0;
        if ($z > 24)
            $z = 24;
        $persen = 2;
        $denda  = round($z * $persen / 100 * $tagihan);
        return $denda;
    }
}

if (!function_exists('buku_bawah')) {
    function buku_bawah($i = 0)
    {
        if ($i < 6)
            return 1;
        elseif ($i < 10)
            return 100000;
        elseif ($i < 13)
            return 500000;
        elseif ($i < 15)
            return 2000000;
        else
            return 5000000;
    }
}

if (!function_exists('buku_atas')) {
    function buku_atas($i = 0)
    {
        if ($i == 1)
            return 99999;
        elseif ($i == 2 || $i == 6)
            return 499999;
        elseif ($i == 3 || $i == 7 || $i == 10)
            return 1999999;
        elseif ($i == 4 || $i == 8 || $i == 11 || $i == 13)
            return 4999999;
        elseif ($i == 5 || $i == 9 || $i == 12 || $i == 14)
            return 999999999999;
        else
            return 0;
    }

}

if (!function_exists('buku_name')) {
    function buku_name($i = 0)
    {
        if ($i == 1) {
            return 'I';
            // break;
        } elseif ($i == 2) {
            return "I, II";
            // break;
        } elseif ($i == 3) {
            return "I, II, III";
            // break;
        } elseif ($i == 4) {
            return "I, II, III, IV";
            // break;
        } elseif ($i == 5) {
            return "I, II, III, IV, V";
            // break;
        } elseif ($i == 6) {
            return "II";
            // break;
        } elseif ($i == 7) {
            return "II, III";
            // break;
        } elseif ($i == 8) {
            return "II, III, IV";
            // break;
        } elseif ($i == 9) {
            return "II, III, IV, V";
            // break;
        } elseif ($i == 10) {
            return "III";
            // break;
        } elseif ($i == 11) {
            return "III, IV";
            // break;
        } elseif ($i == 12) {
            return "III, IV, V";
            // break;
        } elseif ($i == 13) {
            return "IV";
            // break;
        } elseif ($i == 14) {
            return "IV, V";
            // break;
        } elseif ($i == 15) {
            return "V";
            // break;
        } else
            return 0;
    }

}
