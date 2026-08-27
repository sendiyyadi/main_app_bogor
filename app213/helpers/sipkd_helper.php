<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

//author: irul
/*
active_module
active_module_url
is_login
is_super_admin
sipkd_app_id
sipkd_is_all_unit
sipkd_default_unit
sipkd_tahun_anggaran
sipkd_step_kegiatan
sipkd_is_closing
sipkd_user_id
sipkd_user_name
sipkd_group_id
sipkd_group_name
date_validation

app_img_logo
app_img_header
*/

// app_img_logo
if (! function_exists('app_img_logo')) {
    function app_img_logo($img_url = 'assets/img/img_logo.png')
    {
        if (file_exists('assets/img/app/img_logo_' . active_module() . '.png'))
            $ret = base_url('assets/img/app/img_logo_' . active_module() . '.png');
        else
            $ret = base_url($img_url);

        return  $ret;
    }
}

// app_img_header
if (! function_exists('app_img_header')) {
    function app_img_header($img_url = 'assets/img/img_header.png')
    {
        if (file_exists('assets/img/app/img_header_' . active_module() . '.png'))
            $ret = base_url('assets/img/app/img_header_' . active_module() . '.png');
        else
            $ret = base_url($img_url);

        return  $ret;
    }
}

// active_module
if (! function_exists('active_module')) {
    function active_module()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('active_module');
        return  $ret;
    }
}

// active_module_url
if (! function_exists('active_module_url')) {
    function active_module_url($uri = '')
    {
        $CI  = &get_instance();
        if ($uri == '') {
            $ret =  base_url() . $CI->session->userdata('active_module') . '/';
        } else {
            $ret =  base_url() . $CI->session->userdata('active_module') . '/' . $uri . '/';
        }
        return  $ret;
    }
}

// is_login
if (! function_exists('is_login')) {
    function is_login()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('login');
        return  $ret;
    }
}

// is_super_admin
if (! function_exists('is_super_admin')) {
    function is_super_admin()
    {
        $CI  = &get_instance();
        if ($CI->session->userdata('groupname') == 'Sys Admin') {
            return true;
        } else {
            return  false;
        }
    }
}

// is_admin
if (! function_exists('is_admin')) {
    function is_admin()
    {
        $CI  = &get_instance();
        if ($CI->session->userdata('groupname') == 'Administrator') {
            return true;
        } else {
            return  false;
        }
    }
}

// sipkd_app_id
if (! function_exists('sipkd_app_id')) {
    function sipkd_app_id()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('app_id');
        return  $ret;
    }
}

// sipkd_is_all_unit
if (! function_exists('sipkd_is_all_unit')) {
    function sipkd_is_all_unit()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('allunit');
        return  $ret;
    }
}

// sipkd_default_unit
if (! function_exists('sipkd_default_unit')) {
    function sipkd_default_unit()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('unitid');
        return  $ret;
    }
}

// sipkd_tahun_anggaran
if (! function_exists('sipkd_tahun_anggaran')) {
    function sipkd_tahun_anggaran()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('tahun_anggaran');
        return  $ret;
    }
}

// sipkd_step_kegiatan
if (! function_exists('sipkd_step_kegiatan')) {
    function sipkd_step_kegiatan()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('step_kegiatan');
        return  $ret;
    }
}

//sipkd_is_closing
if (! function_exists('sipkd_is_closing')) {
    function sipkd_is_closing()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('step_kegiatan');
        if ($ret == 'closing') {
            return  TRUE;
        } else {
            return FALSE;
        }
    }
}

// sipkd_user_id
if (! function_exists('sipkd_user_id')) {
    function sipkd_user_id()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('userid');
        return  $ret;
    }
}

// sipkd_user_name
if (! function_exists('sipkd_user_name')) {
    function sipkd_user_name()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('username');
        return  $ret;
    }
}

// sipkd_user_name
if ( ! function_exists('sipkd_user_login'))
{
    function sipkd_user_login()
    {
        $CI  =& get_instance();
        $ret =  $CI->session->userdata('userlogin');
        return  $ret;
    }
}

// sipkd_group_id
if (! function_exists('sipkd_group_id')) {
    function sipkd_group_id()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('groupid');
        return  $ret;
    }
}

// sipkd_group_name
if (! function_exists('sipkd_group_name')) {
    function sipkd_group_name()
    {
        $CI  = &get_instance();
        $ret =  $CI->session->userdata('groupname');
        return  $ret;
    }
}

// keymaker
if (! function_exists('keymaker')) {
    function keymaker($id = '')
    {
        //generate the secret key anyway you like. It could be a simple string like in this example or a database
        //look up of info unique to the user or id. It could include date/time to timeout keys.
        $secretkey = '1RuL1HutysK98UuuhDasdfafdCrackThisBeeeeaaaatchkHgjsheIHFH44fheo1FhHEfo2oe6fifhkhs';
        $key = md5($id . $secretkey);
        return $key;
    }
}

// last_query
if (! function_exists('last_query')) {
    function last_query()
    {
        $CI  = &get_instance();
        return $CI->db->last_query();
    }
}


if (! function_exists('ctword')) {
    // by irfani.firdausy.com
    function ctword($x)
    {
        $x      = abs($x);
        $number = array(
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas"
        );
        $temp   = "";

        if ($x < 12) {
            $temp = " " . $number[$x];
        } else if ($x < 20) {
            $temp = ctword($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = ctword($x / 10) . " puluh" . ctword($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . ctword($x - 100);
        } else if ($x < 1000) {
            $temp = ctword($x / 100) . " ratus" . ctword($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . ctword($x - 1000);
        } else if ($x < 1000000) {
            $temp = ctword($x / 1000) . " ribu" . ctword($x % 1000);
        } else if ($x < 1000000000) {
            $temp = ctword($x / 1000000) . " juta" . ctword($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = ctword($x / 1000000000) . " milyar" . ctword(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = ctword($x / 1000000000000) . " trilyun" . ctword(fmod($x, 1000000000000));
        }
        return $temp;
    }
}

if (! function_exists('terbilang')) {
    function terbilang($x, $style = 4, $strcomma = ',')
    {
        if ($x < 0) {
            $result = "minus " . trim(ctword($x));
        } else {
            $arrnum   = explode("$strcomma", $x);
            $arrcount = count($arrnum);
            if ($arrcount == 1) {
                $result = trim(ctword($x));
            } else if ($arrcount > 1) {
                $result = trim(ctword($arrnum[0])) . " koma " . trim(ctword($arrnum[1]));
            }
        }
        switch ($style) {
            case 1: //1=uppercase  dan
                $result = strtoupper($result);
                break;
            case 2: //2= lowercase
                $result = strtolower($result);
                break;
            case 3: //3= uppercase on first letter for each word
                $result = ucwords($result);
                break;
            default: //4= uppercase on first letter
                $result = ucfirst($result);
                break;
        }
        return $result;
    }
}

if (! function_exists('namabulan')) {
    function namabulan($id = 1)
    {

        switch ($id) {
            case 1:
                $result = 'Januari';
                break;
            case 2:
                $result = 'Pebruari';
                break;
            case 3:
                $result = 'Maret';
                break;
            case 4:
                $result = 'April';
                break;
            case 5:
                $result = 'Mei';
                break;
            case 6:
                $result = 'Juni';
                break;
            case 7:
                $result = 'Juli';
                break;
            case 8:
                $result = 'Agustus';
                break;
            case 9:
                $result = 'September';
                break;
            case 10;
                $result = 'Oktober';
                break;
            case 11:
                $result = 'Nopember';
                break;
            case 12:
                $result = 'Desember';
                break;
            default:
                $result = 'Salah Bulan';
                break;
        }
        return $result;
    }
}

if (! function_exists('cbobulan')) {
    function cbobulan($n = 'cbobulan', $d = 1)
    {
        $r = "<select id=\"$n\" name=\"$n\">";
        for ($i = 1; $i < 13; $i++) {
            if ($i = $d)
                $s = 'selected';
            else $s = '';
            $r .= "<option value=\"$i\" $s>" . namabulan($i) . "</option>\n";
        }

        $r .= "</select>";
        return $r;
    }
}


//-- ADd by tatang niy untuk renbang
if (! function_exists('date_validation')) {
    function date_validation($date_str)
    {
        if (strpos($date_str, '/') == FALSE && strpos($date_str, '-') == FALSE && strpos($date_str, '.') == FALSE) {
            if (strlen($date_str) == 6) {
                $date_str = substr($date_str, 0, 2) . '-' . substr($date_str, 2, 2) . '-' . substr($date_str, 4, 2);
            } elseif (strlen($date_str) == 8) {
                $date_str = substr($date_str, 0, 2) . '-' . substr($date_str, 2, 2) . '-' . substr($date_str, 4, 4);
            }
        }
        $date_regex = '%\A(\d{1}|\d{2})[-/.](\d{1}|\d{2})[-/.](\d{2}|\d{4})\z%';
        $hasil = '';
        $ret = '';
        if (preg_match($date_regex, $date_str, $hasil) == TRUE) {
            if (count($hasil) == 4) {
                if (strlen($hasil[3]) == 2) {
                    $hasil[3] = '20' . $hasil[3];
                }
                if (strlen($hasil[1]) == 1) {
                    $hasil[1] = '0' . $hasil[1];
                }
                if (strlen($hasil[2]) == 1) {
                    $hasil[2] = '0' . $hasil[2];
                }
                $ret = $hasil[3] . '-' . $hasil[2] . '-' . $hasil[1];
                if (checkdate($hasil[2], $hasil[1], $hasil[3])) {
                    return $ret;
                } else {
                    return '';
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
}

if (!function_exists('hit_hkpd_all')) {
    function hit_hkpd_all($pokok, $jth_tempo, $tgl, $jns)
    {
        /**  hkpd dibawa 2024 kena 2% diatas 2023 kena 1% **/
        /******************************************************************
        pokok  = nilai pokok yg akan dihitung
        jth_tempo = Tgl Jth Tempo       yyyy-mm-dd
        tgl = Tgl Dibayar               yyyy-mm-dd
        jns  = Jns yg di cari N=Nilai Denda B=Jml Bulan P=Persen(%)
         *******************************************************************/
        $max_bln = 24; // max bulan kena denda 24 bln
        $denda   = 0;
        $persen  = 0;
        $bulan   = 0;
        $pcn_old = 2; // 2 persen 
        $pcn_new = 1; // 1 persen
        $tgl_old = date_create('2023-12-31'); // tgl batas akhir undang undang lama
        /***************************************************************************/
        if (empty($pokok)) {
            $pokok = 0;
        }
        if (empty($jth_tempo)) {
            $jth_tempo = '2000-01-01';
        }
        if (empty($tgl)) {
            $tgl = date('Y-m-d');
        }
        if (empty($jns)) {
            $jns = "0";
        }
        //
        $tanggal = strtotime($tgl);
        $tanggal = date('Ymd', $tanggal);
        //
        $tempo = strtotime($jth_tempo);
        $tempo = date('Ymd', $tempo);
        // 
        if ($tempo >= $tanggal) {
            return 0;
        }
        //
        $jt_tempo = date_create($jth_tempo);
        $tg_bayar = date_create($tgl);
        //
        $interval = date_diff($jt_tempo, $tg_bayar);
        //
        $thn  = $interval->format('%y');
        $bln  = $interval->format('%m');
        $hari_new = $interval->format('%d');
        //
        $tbln_new = $bln + ($thn * 12);
        if ($hari_new > 0) {
            $tbln_new = $tbln_new + 1;
        }
        //****************************************************************
        if (date_format($jt_tempo, "Y") > 2023) {
            if ($tbln_new >= $max_bln) {
                $bulan  = $max_bln;
                $persen = ($max_bln * $pcn_new);
                $denda  = round(($persen / 100.0) * $pokok);
            } else {
                $bulan  = $tbln_new;
                $persen = ($tbln_new * $pcn_new);
                $denda  = round(($persen / 100.0) * $pokok);
            }
        } else if (date_format($tg_bayar, "Y") < 2024) {
            if ($tbln_new >= $max_bln) {
                $bulan  = $max_bln;
                $persen = ($max_bln * $pcn_old);
                $denda  = round(($persen / 100.0) * $pokok);
            } else {
                $bulan  = $tbln_new;
                $persen = ($tbln_new * $pcn_old);
                $denda  = round(($persen / 100.0) * $pokok);
            }
        } else {
            /* jt tempo dibawa 2024 */
            //****************************************************/
            //
            $interval = date_diff($jt_tempo, $tgl_old);
            //
            $thn = $interval->format('%y');
            $tbl = $interval->format('%m');
            $hari_old = $interval->format('%d');
            //
            $tbln_old = $tbl + ($thn * 12);

            if ($hari_old > 0) {
                $tbln_old = $tbln_old + 1;
            }
            //****************************************************/

            if ($tbln_old >= $max_bln) {
                $bulan  = $max_bln;
                $persen = ($max_bln * $pcn_old);
                $denda  = round(($persen / 100.0) * $pokok);
            } else {
                $sisa_bln    = $max_bln - $tbln_old;  //  24 bln dikurangi yg terpakai di bawa thn 2024
                $selisih_bln = $tbln_new - $tbln_old; // cari selisih dari total bln - yg terpakai         

                // dibawa thn 2024
                $bulan  = $tbln_old;
                $persen = ($tbln_old * $pcn_old);

                /* diatas tahun 2023 */
                if ($sisa_bln >= $selisih_bln) {
                    $bulan  = $bulan  + $selisih_bln;
                    $persen = $persen + ($selisih_bln * $pcn_new);
                } else {
                    $bulan  = $bulan + $sisa_bln;
                    $persen = $persen + ($sisa_bln * $pcn_new);
                }

                $denda = round(($persen / 100.0) * $pokok);
            }
        }

        if (strtolower($jns) == 'n') {
            return $denda;
        } else if (strtolower($jns) == 'b') {
            return $bulan;
        } else if (strtolower($jns) == 'p') {
            return $persen;
        } else {
            return 0;
        }
    }
}


// sipkd_user_nip
if ( ! function_exists('sipkd_user_nip'))
{
    function sipkd_user_nip()
    {
        $CI  =& get_instance();
        $ret =  $CI->session->userdata('nip');
        return  $ret;
    }
}

