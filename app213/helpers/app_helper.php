<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('app_get_role_akses')) 
{
    function app_get_role_akses($kd_menu='',$modul_menu='') {

        $result = FALSE;
        $CI = get_instance();
        $CI->load->model('apps_model');
        //
        if($modul_menu == 'T'){
            $result = $CI->apps_model->get_app_role_tran_01($kd_menu); 
        }
        else if($modul_menu == 'M'){
            $result = $CI->apps_model->get_app_role_menu_01($kd_menu);  
        }
        else if($modul_menu == 'S'){
            $result = $CI->apps_model->get_app_role_menu_01($kd_menu);  
        }        
        return $result;         
    }
}

// app_img_logo
if ( ! function_exists('app_img_logo'))
{
    function app_img_logo($img_url = 'assets/img/img_logo.png')
    {
        if(file_exists('assets/img/app/img_logo_'.active_module().'.png'))
            $ret = base_url('assets/img/app/img_logo_'.active_module().'.png');
        else
            $ret = base_url($img_url);
            
		return  $ret;
    }
}

// app_img_header
if ( ! function_exists('app_img_header'))
{
    function app_img_header($img_url = 'assets/img/img_header.png')
    {
        if(file_exists('assets/img/app/img_header_'.active_module().'.png'))
            $ret = base_url('assets/img/app/img_header_'.active_module().'.png');
        else
            $ret = base_url($img_url);
            
		return  $ret;
    }
}

// get_string
if (!function_exists('get_string')){
    function get_string($value = NULL) {
        $value = rtrim($value);
        return (isset($value) && $value != '') ? $value : NULL;
    }
}

// active_module
if ( ! function_exists('active_module'))
{
    function active_module()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('active_module');
		return  $ret;
    }
}

// active_module_url
if ( ! function_exists('active_module_url'))
{
    function active_module_url($uri = '')
    {
		$CI  =& get_instance();
		if ($uri == '') {
			$ret =  base_url().$CI->session->userdata('active_module').'/';
		} else {
			$ret =  base_url().$CI->session->userdata('active_module').'/'.$uri.'/';
		}
		return  $ret;
    }
}

// is_login
if ( ! function_exists('is_login'))
{
    function is_login()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('login');
		return  $ret;
    }
}

// is_super_admin
if ( ! function_exists('is_super_admin'))
{
    function is_super_admin()
    {
		$CI  =& get_instance();
		if($CI->session->userdata('groupname')=='Sys Admin') {
			return true;
		} else {
			return  false;
		}
    }
}

// is_admin
if ( ! function_exists('is_admin'))
{
    function is_admin()
    {
		$CI  =& get_instance();
		if($CI->session->userdata('groupname')=='Administrator') {
			return true;
		} else {
			return  false;
		}
    }
}

// lda_app_id
if ( ! function_exists('lda_app_id'))
{
    function lda_app_id()
    {
        $CI  =& get_instance();
        $ret =  $CI->session->userdata('app_id');
        return  $ret;
    }
}

// lda_user_login
if ( ! function_exists('lda_user_login'))
{
    function lda_user_login()
    {
        $CI  =& get_instance();
        $ret =  $CI->session->userdata('userlogin');
        return  $ret;
    }
}

// lda_is_all_unit
if ( ! function_exists('lda_is_all_unit'))
{
    function lda_is_all_unit()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('allunit');
		return  $ret;
    }
}

// lda_default_unit
if ( ! function_exists('lda_default_unit'))
{
    function lda_default_unit()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('unitid');
		return  $ret;
    }
}

// lda_tahun_anggaran
if ( ! function_exists('lda_tahun_anggaran'))
{
    function lda_tahun_anggaran()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('tahun_anggaran');
		return  $ret;
    }
}

// lda_step_kegiatan
if ( ! function_exists('lda_step_kegiatan'))
{
    function lda_step_kegiatan()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('step_kegiatan');
		return  $ret;
    }
}

//lda_is_closing
if ( ! function_exists('lda_is_closing'))
{
    function lda_is_closing()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('step_kegiatan');
		if ($ret=='closing') {
			return  TRUE;
		} else {
			return FALSE;
		}
    }
}

// lda_user_id
if ( ! function_exists('lda_user_id'))
{
    function lda_user_id()
    {
        $CI  =& get_instance();
        $ret =  $CI->session->userdata('userid');
        return  $ret;
    }
}

// lda_user_name
if ( ! function_exists('lda_user_name'))
{
    function lda_user_name()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('username');
		return  $ret;
    }
}

// lda_group_id
if ( ! function_exists('lda_group_id'))
{
    function lda_group_id()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('groupid');
		return  $ret;
    }
}

// lda_group_name
if ( ! function_exists('lda_group_name'))
{
    function lda_group_name()
    {
		$CI  =& get_instance();
		$ret =  $CI->session->userdata('groupname');
		return  $ret;
    }
}

// lda_app_nama
if ( ! function_exists('lda_app_nama'))
{
    function lda_app_nama()
    {
        $CI  =& get_instance();
        $ret =  $CI->session->userdata('app_name');
        return  $ret;
    }
}

// keymaker
if ( ! function_exists('keymaker'))
{
	function keymaker($id = ''){
		//generate the secret key anyway you like. It could be a simple string like in this example or a database
		//look up of info unique to the user or id. It could include date/time to timeout keys.
		$secretkey='1RuL1HutysK98UuuhDasdfafdCrackThisBeeeeaaaatchkHgjsheIHFH44fheo1FhHEfo2oe6fifhkhs';
		$key=md5($id.$secretkey);
		return $key;
	}
}

// last_query
if ( ! function_exists('last_query'))
{
    function last_query() {
		$CI  =& get_instance();
		return $CI->db->last_query();
	}
}

if ( ! function_exists('ctword'))
{
  // by irfani.firdausy.com
  function ctword($x) {
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

if ( ! function_exists('terbilang'))
{
	function terbilang($x,$style=4,$strcomma=',') {
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

if ( ! function_exists('namabulan'))
{
  function namabulan($id=1) {

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

if ( ! function_exists('cbobulan'))
{
  function cbobulan($n='cbobulan',$d=1) {
    $r="<select id=\"$n\" name=\"$n\">";
    for ($i=1;$i<13;$i++){
      if ($i=$d) 
          $s='selected';
      else $s='';
      $r.="<option value=\"$i\" $s>".namabulan($i)."</option>\n";}
      
      $r.="</select>";
    return $r;
  }

}


//-- ADd by tatang niy untuk renbang
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

// current_time
if ( ! function_exists('current_time'))
{
    function current_time()
    {
        $today = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $today = $today->format('Y-m-d H:i:s');    // for mssql / postgress
        // $today = $today->format('d-m-Y H:i:s');   // for oracle
        return  $today;
    }
}

// current_time_ora
if ( ! function_exists('current_time_ora'))
{
    function current_time_ora()
    {
        // return date('Y-m-d H:i:s');
        // return strtoupper(date('d-M-y H:i:s'));

        $bulan = array(
            'JAN' => 'JAN',
            'FEB' => 'FEB',
            'MAR' => 'MAR',
            'APR' => 'APR',
            'MAY' => 'MEI',
            'JUN' => 'JUN',
            'JUL' => 'JUL',
            'AUG' => 'AGT',
            'SEP' => 'SEP',
            'OCT' => 'OKT',
            'NOV' => 'NOV',
            'DEC' => 'DES',
        );

        return date('d-') . $bulan[strtoupper(date('M'))] . date('-y H:i:s');
    }
}

// current_date_ora
if ( ! function_exists('current_date_ora'))
{
    function current_date_ora()
    {
        // return date('Y-m-d H:i:s');
        return strtoupper(date('d-M-y'));
    }
}

// current_date
if ( ! function_exists('current_date'))
{
    function current_date()
    {
        $today = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $today = $today->format('Y-m-d');    // for mssql / postgress
        // $today = $today->format('d-m-Y H:i:s');   // for oracle
        return  $today;
    }
}

// pos_kolom arig 2021-02-08
if ( ! function_exists('pos_kolom')) {
    function pos_kolom($fx)
    {
        if (DEF_POS_TYPE==1){
            $kolom = "{$fx}.KD_KANWIL,{$fx}.KD_KANTOR,{$fx}.KD_TP"; 
        }
        else{
            $kolom = "{$fx}.KD_BANK_TUNGGAL,{$fx}.KD_BANK_PERSEPSI,{$fx}.KD_KANWIL,{$fx}.KD_KANTOR,{$fx}.KD_TP"; 
        }
        return $kolom;
    }
}

// pos_kolom arig 2021-02-08
if ( ! function_exists('pos_klm')) {
    function pos_klm()
    {
        if (DEF_POS_TYPE==1){
            $kolom = "KD_KANWIL, KD_KANTOR, KD_TP"; 
        }
        else{
            $kolom = "KD_BANK_TUNGGAL, KD_BANK_PERSEPSI, KD_KANWIL, KD_KANTOR, KD_TP"; 
        }
        return $kolom;
    }
}

// pos_join arig 2021-02-08
if ( ! function_exists('pos_join')) {
    function pos_join($f1,$f2)
    {
        if (DEF_POS_TYPE==1){
            $filter   = "{$f1}.KD_KANWIL={$f2}.KD_KANWIL and {$f1}.KD_KANTOR={$f2}.KD_KANTOR and {$f1}.KD_TP={$f2}.KD_TP"; 
        }
        else{
            $filter   = "{$f1}.KD_BANK_TUNGGAL={$f2}.KD_BANK_TUNGGAL and {$f1}.KD_BANK_PERSEPSI={$f2}.KD_BANK_PERSEPSI ";
            $filter  .= " and {$f1}.KD_KANWIL={$f2}.KD_KANWIL and {$f1}.KD_KANTOR={$f2}.KD_KANTOR and {$f1}.KD_TP={$f2}.KD_TP "; 
        }
        return $filter;
    }
}

// post_decimal
if ( ! function_exists('post_decimal'))
{
    function post_decimal($value)
    {
        $val = trim($value);
        $val = str_replace(".", "", $val);
        $val = str_replace(",", ".", $val);
        return (empty($val) ? 0 :  ($val == '.' ? 0 : ($val == ',' ? 0 : $val) ) );
    }
}

// post_string
if (!function_exists('post_string')){
    function post_string($value = NULL) {
        $value = rtrim($value);
        return (isset($value) && $value != '') ? $value : NULL;
    }
}

// post_date format : dd-mm-yyyy
if (!function_exists('post_date')){
    function post_date($tgl = NULL) {
        return empty($tgl) ? NULL : date('d-m-Y', strtotime($tgl));
    }
}

// post_time format yyyy-mm-dd hh:mm:ss for mssql / postgress // oracle
if (!function_exists('post_time')) {
    function post_time($jam = NULL) {
        return  empty($jam) ? NULL : date('Y-m-d H:i:s', strtotime($jam));
    }
}


// empty_string
if (!function_exists('empty_string')){
    function empty_string($value = NULL) {
        $value = rtrim($value);
        return (isset($value) && $value != '' && $value != ' ') ? FALSE : TRUE;
    }
}

// app_string
if (!function_exists('app_string')){
    function app_string($value = NULL) {
        $value = rtrim($value);
        return (isset($value) && $value != '') ? $value : NULL;
    }
}

// app_string_notnull
if (!function_exists('app_string_notnull')){
    function app_string_notnull($value = NULL) {
        $value = rtrim($value);
        return (isset($value) && $value != '') ? $value : ' ';
    }
}

// app_decimal
if (!function_exists('app_decimal')){
    function app_decimal($value = NULL) {
        $value = trim($value);
        return empty($value) ? 0 : $value;
    }
}

// app_date format yyyy-mm-dd
if (!function_exists('app_date')){
    function app_date($value = NULL) {
        $value = trim($value);
        return empty($value) ? NULL : date('Y-m-d', strtotime($value));
    }
}

// get_decimal
if (!function_exists('get_decimal')){
    function get_decimal($value = NULL) {
        $value = trim($value);
        return empty($value) ? 0 : $value;
    }
}

// get_string
if (!function_exists('get_string')){
    function get_string($value = NULL) {
        $value = rtrim($value);
        return (isset($value) && $value != '') ? $value : NULL;
    }
}

// get_date format dd-m-yyyy
if (!function_exists('get_date')){
    function get_date($tgl = NULL) {
        return empty($tgl) ? NULL : date('d-m-Y', strtotime($tgl));
    }
}

// get_encript
if (!function_exists('get_encript')){
    function get_encript($string = NULL) {
        //https://gist.github.com/joashp/a1ae9cb30fa533f4ad94
        $output = false;
        //$encrypt_method = "AES-256-CBC";
        $encrypt_method = "AES-128-CBC";
        $secret_key     = 'eon';
        $secret_iv      = 'eoniv';
        // hash
        //$key    = hash('sha256', $secret_key);  
        $key    = hash('sha1', $secret_key);  
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv     = substr(hash('sha1', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        // log_message('info', "eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee: tes ");
        return $output;
    }
}

// get_decript
if (!function_exists('get_decript')){
    function get_decript($string = NULL) {
        //https://gist.github.com/joashp/a1ae9cb30fa533f4ad94
        $output = false;
        //$encrypt_method = "AES-256-CBC";
        $encrypt_method = "AES-128-CBC";
        $secret_key     = 'eon';
        $secret_iv      = 'eoniv';
        // hash
        //$key    = hash('sha256', $secret_key);  
        $key    = hash('sha1', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv     = substr(hash('sha1', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;

    }
}

if (!function_exists('set_msg_db_error')){
    function set_msg_db_error($string = NULL) {

        //  session_start();
        $_SESSION['msg_db_error'] = $string;
    }
}

if (!function_exists('get_msg_db_error')){
    function get_msg_db_error($string = NULL) {

      //  session_start();
        $output = '';
        $ret    = '';
        if(isset($_SESSION['msg_db_error'])){
            $output = $_SESSION['msg_db_error'];
        }

        $_SESSION['msg_db_error'] = '';

        if(!empty($output)){
            $ret = '<div id="msg_helper" class="alert alert-error">';
            $ret.= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            $ret.= $output;
            $ret.= '</div>';
            return $ret;
        }

        //return $output;
    }    
}

// cek_injek
if (!function_exists('cek_injek')){
    function cek_injek($value = NULL) {

        $teks = " ".$value; // tambahkan 1 digit spasi supya pencarian dimulai digit 1 bukan 0
        // hasil stripos jika ketemu urutan kolom ke berapa
        // cek kata2 berbau injek
        // di php 5 cara ini tdk suport
        /*
        if(!empty(stripos($teks, "select "))){ return TRUE; }
        if(!empty(stripos($teks, "insert into"))){ return TRUE; }
        if(!empty(stripos($teks, "update"))){ return TRUE; }
        if(!empty(stripos($teks, "delete"))){ return TRUE; }
        if(!empty(stripos($teks, "drop"))){ return TRUE; }
        if(!empty(stripos($teks, ";"))){ return TRUE; }
        if(!empty(stripos($teks, "="))){ return TRUE; }
        if(!empty(stripos($teks, "rownum"))){ return TRUE; }
        if(!empty(stripos($teks, "limit "))){ return TRUE; }
        if(!empty(stripos($teks, " or "))){ return TRUE; }
        if(!empty(stripos($teks, ")or"))){ return TRUE; }
        if(!empty(stripos($teks, "or("))){ return TRUE; }
        if(!empty(stripos($teks, " and "))){ return TRUE; }
        if(!empty(stripos($teks, ")and"))){ return TRUE; }
        if(!empty(stripos($teks, "and("))){ return TRUE; }
        if(!empty(stripos($teks, "where "))){ return TRUE; }
        if(!empty(stripos($teks, "from "))){ return TRUE; }
        if(!empty(stripos($teks, "from("))){ return TRUE; }
        if(!empty(stripos($teks, "drop "))){ return TRUE; }
        if(!empty(stripos($teks, "exec "))){ return TRUE; }
        if(!empty(stripos($teks, "execute"))){ return TRUE; }
        if(!empty(stripos($teks, "truncate"))){ return TRUE; }
        if(!empty(stripos($teks, "--"))){ return TRUE; }
        if(!empty(stripos($teks, "table"))){ return TRUE; }
        if(!empty(stripos($teks, "values"))){ return TRUE; }
        if(!empty(stripos($teks, "cmdshell"))){ return TRUE; }
        */

        // cara ini php 5 dan 7 jln
        $kata = stripos($teks, "select "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "insert into"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "update"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "delete"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "drop"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, ";"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "="); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "rownum"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "limit "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, " or "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, ")or"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "or("); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, " and "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, ")and"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "and("); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "where "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "from "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "from("); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "drop "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "exec "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "execute"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "truncate"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "--"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "table"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "values"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "cmdshell"); if(!empty($kata)){ return TRUE; }
        //log_message('info', " gggggggggggggggggggggggggggggggg loaddata piutang_pbb KODE : "); 

        return FALSE;
    }
}

// cek spesial karakter spasi/koma/;/:
if (!function_exists('cek_ascii')){
    function cek_ascii($value = NULL) 
    {
        $teks = "x".$value; // tambahkan 1 digit spasi supya pencarian dimulai digit 1 bukan 0
        // cara ini php 5 dan 7 jln
        $kata = stripos($teks, " "); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "'"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, '"'); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, ","); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, ";"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, ":"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "`"); if(!empty($kata)){ return TRUE; }
        $kata = stripos($teks, "~"); if(!empty($kata)){ return TRUE; }
        //$kata = stripos($teks, "/"); if(!empty($kata)){ return TRUE; }
        //log_message('info', " gggggggggggggggggggggggggggggggg loaddata piutang_pbb KODE : "); 
        return FALSE;
    }
}

if (!function_exists('log_activity')){
    function log_activity($kode = 'act_',$string = NULL) {

        $_logfilename = "temp/activity_".date("Y-m-d").".log"; 
        $jam = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $jam = $jam->format('Y-m-d H:i:s');  
        //
        $nm_client = "";//gethostname(); 
        $ip_client =  getenv('HTTP_USER_AGENT') ;
        //log_message('info', "SSSSSSSSSSSSSSSSSSSSSSSSSSSS HTTP_USER_AGENT : ". getenv('HTTP_USER_AGENT')  );

        if(!file_exists($_logfilename)){
            $_logfilehandler = fopen($_logfilename,'w'); #buat file dengan akses tulis penuh
            fwrite($_logfilehandler, $jam."\n"); #tulis header untuk file log, jika perlu
            //fclose($_logfilehandler);
        }else{
            $_logfilehandler = fopen($_logfilename,'a'); #akses file dengan modus buka/tulis
        }
        fwrite($_logfilehandler, "\n".$jam." ".$kode." activity : ".$string . "  browser ". $ip_client);
        fclose($_logfilehandler);
    }
}


// fmt_number
if (!function_exists('fmt_number')){
    function fmt_number($value = NULL) {
        $value = trim($value);
        $value = (int)$value;
        return (isset($value) && $value != '') ? number_format($value,0,',','.') : 0;
    }
}

// trim_quotes arig 2023-03-24
if (!function_exists('trim_quotes')){
    function trim_quotes($value = NULL) {
        //$value = rtrim($value);
        $value = trim($value);
        if (!is_null($value)){$value = str_replace("'","",$value);} 
        //return (isset($value) && $value != '') ? $value : NULL;
        return (isset($value) && $value != '') ? $value : ''; // dioracle '' sama dgn NULL
    }
}

// bulan_romawi
if ( ! function_exists('bulan_romawi'))
{
    function bulan_romawi($p)
    {
        $romawi = '';
        switch ($p) {
            case '1':
                $romawi = 'I';
            break;
            case '2':
                $romawi = 'II';
            break;
            case '3':
                $romawi = 'III';
            break;
            case '4':
                $romawi = 'IV';
            break;
            case '5':
                $romawi = 'V';
            break;
            case '6':
                $romawi = 'VI';
            break;
            case '7':
                $romawi = 'VII';
            break;
            case '8':
                $romawi = 'VIII';
            break;
            case '9':
                $romawi = 'IX';
            break;
            case '10':
                $romawi = 'X';
            break;
            case '11':
                $romawi = 'XI';
            break;
            case '12':
                $romawi = 'XII';
            break;
            
        }
        return $romawi;
    }
}

function get_kec_kodes()
{
    $CI =& get_instance();
    $user_area = $CI->session->userdata('user_area');

    $kodes = false;
    if (count($user_area)>0) {
        for($i=0;$i<count($user_area);$i++) {
            $kd_kec = trunc_kec_kd($user_area[$i]);
            $kodes .= "'{$kd_kec}',";
        }
        $kodes = substr($kodes,0,strlen($kodes)-1);
    }
    return $kodes;
}

function get_kel_kodes()
{
    $CI =& get_instance();
    $user_area = $CI->session->userdata('user_area');

    $kodes = false;
    if (count($user_area)>0) {
        $last_kec = '';
        $kec_kel  = '';
        for($i=0;$i<count($user_area);$i++) {
            $kd_kec = trunc_kec_kd($user_area[$i]);
            $kd_kel = trunc_kel_kd($user_area[$i]);

            if($last_kec != $kd_kec) {
                $last_kec = $kd_kec;
                $kec_kel  = "'{$kd_kel}',";
            } else 
                $kec_kel .= "'{$kd_kel}',";

            $kodes[$last_kec] = $kec_kel;
        }

        foreach ($kodes as $key => $val)
            $kodes[$key] = substr($val,0,strlen($val)-1);;
    }
    return $kodes;
}
