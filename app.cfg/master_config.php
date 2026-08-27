<?php
/*
| -------------------------------------------------------------------
| MASTER CONFIGURATION
| -------------------------------------------------------------------
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

// -- App Info
define('APP_TITLE', 'BADAN PENGELOLAAN PENDAPATAN DAERAH KABUPATEN BOGOR');
define('APP_NAME', 'main_app_bgr'); //no space please
define('APP_CORP', 'PSI Bappenda Kab Bogor');
define('APP_VERSION', '0.1');
define('APP_YEAR', '2025');
define('LICENSE_TO', 'KABUPATEN BOGOR');
define('LICENSE_TO_SUB', 'BADAN PENGELOLAAN PENDAPATAN DAERAH');

//define('STTS1', 'vstts1_dpk');    //Draft Single 1 (3 potongan)  1a (4 potong) (kota tangerang)
define('STTS2', 'vstts2_dpk'); //Draft Masal 2 (3 potongan)  2a (4 potong) (kota tangerang)
//define('STTS3', 'vstts3'); //Bank Single 3 (1 kwarto 2 stts)  1a (1kwarto 3 stts) (plratu)
define('STTS4', 'vstts4'); //Bank Masal 4 (1 kwarto 2 stts)  4a (1kwarto 3 stts) (plratu)

define('STTS1','stts1av'); //Draft Single 1 (3 potongan)  1a (4 potong) (kota tangerang)
//define('STTS2','stts2av'); //Draft Masal 2 (3 potongan)  2a (4 potong) (kota tangerang)
define('STTS3','stts3v'); //Bank Single 3 (1 kwarto 2 stts)  1a (1kwarto 3 stts) (plratu)
//define('STTS4','stts4v'); //Bank Masal 4 (1 kwarto 2 stts)  4a (1kwarto 3 stts) (plratu)

// -- Module
define('DEF_MODULE', 1); // 1. perencanaan 2.etc  ref => apps table
define('SELECT_MODULE', TRUE);

// -- Environment (development testing production)
// define('MY_ENV', 'development');
define('MY_ENV', 'production');

// -- System & Application
// define('MY_SYS', 'sys213');
define('MY_SYS', 'sistems');
define('MY_APP', 'app213');
define('MY_DEFAULT_CONTROLLER', 'root');
define('MY_MODULES_LOCATIONS', '../modules/');

// DATABASE ORACLE MAIN
$db_debug =  (MY_ENV == 'development') ? true : false;
define('DB_DBUG', $db_debug);
define('DB_TYPE', 'orcl');
define('DB_HOST', '192.168.1.114');
// define('DB_HOST', '192.168.1.121');
// define('DB_HOST', '192.168.1.51');
define('DB_PORT', '1521');
// define('DB_USER', 'PBB_WPBGR');
define('DB_USER', 'PBB');
define('DB_PASS', 'Z2184NDSHGF8112RT58');
define('DB_NAME', 'SIMPBB');
define('DB_DRIVER', 'oci8');
define('DB_PCONNECT', false);
define('DB_CACHEDIR', '');
define('DB_CHAR_SET', 'utf8');
define('DB_COLLAT', 'utf8_general_ci');
define('DB_SWAP_PRE', '');
define('DB_AUTOINIT', true);
define('DB_STRICTON', false);
// define('OCI_COMMIT_ON_SUCCESS', false);
define('DB_PBB_USER', 'PBB');
define('DB_PBB_PASS', 'Z2184NDSHGF8112RT58');
// define('SCHEMA_PBB', 'PBB'); // NAMA SCHEMA DB PBB SISMIOP

// // VA QRIS        
define('DB_HOST_VQ', '192.168.1.98');
define('DB_PORT_VQ', '5432');
define('DB_TYPE_VQ', 'postgre');  //mysql postgre
define('DB_USER_VQ', 'postgres');
define('DB_PASS_VQ', '@dminP51');
define('DB_NAME_VQ', 'online_payment');
define('DB_DRVR_VQ', 'oci8');

//// BPHTB
define('DB_TYPE_BPHTB', 'sqlsrv');  //mysql postgre
define('DB_HOST_BPHTB', '192.168.1.53');
define('DB_PORT_BPHTB', '');
define('DB_USER_BPHTB', 'sa');
define('DB_PASS_BPHTB', 'Sa511');
define('DB_NAME_BPHTB', 'BPHTB');
define('DB_DRIVER_BPHTB','sqlsrv');
define('DB_VERSISQL_BPHTB','2012');

// DATABASE ORACLE MAIN
// $db_debug =  (MY_ENV == 'development') ? TRUE : FALSE;
// define('DB_DBUG', $db_debug);
// define('DB_TYPE', 'orcl');
// define('DB_HOST', '192.168.1.200');
// define('DB_PORT', '1521');
// define('DB_USER', 'POSPBB_BGR');
// define('DB_PASS', 'POSPBB123');
// define('DB_NAME', 'ORCL');
// define('DB_DRIVER', 'oci8');
// define('DB_PCONNECT', FALSE);
// define('DB_CACHEDIR', '');
// define('DB_CHAR_SET', 'utf8');
// define('DB_COLLAT', 'utf8_general_ci');
// define('DB_SWAP_PRE', '');
// define('DB_AUTOINIT', TRUE);
// define('DB_STRICTON', false);
//define('OCI_COMMIT_ON_SUCCESS',FALSE);
/*
define('DB_DBUG', $db_debug);
define('DB_TYPE', 'orcl');  
define('DB_HOST', '192.168.1.210');
define('DB_PORT', '1521');
define('DB_USER', 'POSPST_CIMAHI');
define('DB_PASS', 'POS123');
define('DB_NAME', 'ORCL');
define('DB_DRIVER','oci8');
define('DB_PCONNECT',FALSE);
define('DB_CACHEDIR','');
define('DB_CHAR_SET','utf8');
define('DB_COLLAT','utf8_general_ci');
define('DB_SWAP_PRE','');
define('DB_AUTOINIT',TRUE);
define('DB_STRICTON',false);
//define('OCI_COMMIT_ON_SUCCESS',FALSE);
*/

define('SCHEMA_PBB', 'PBB_BGR'); // NAMA SCHEMA DB PBB SISMIOP   

// -- Url
$PROTOCOL = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
$SERVER   = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
$SERVER   = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $SERVER;
$BASE_URL = $PROTOCOL . $SERVER . str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
define('MY_BASE_URL', $BASE_URL);
define('MY_INDEX_PAGE', '');

// -- Hook
define('MY_ENABLE_HOOKS', FALSE);

// -- Compress Output
define('MY_COMPRESS_OUTPUT', FALSE);

// -- Cache n minutes
define('MY_CACHE', 0);
define('MY_CACHE_PATH', 'cache/');

// -- Error Logging Threshold 0-4
$err_log = (MY_ENV == 'development') ? 4 : 0;
// $err_log = 4;
define('MY_LOG_THRESHOLD', $err_log);

// -- Encrypt & Security
define('MY_ENCRYPTION_KEY', 'mr34n1k');
define('MY_GLOBAL_XSS_FILTERING', TRUE);
define('MY_CSRF_PROTECTION', FALSE);
define('MY_CSRF_TOKEN_NAME', APP_NAME . '_csrf_test');
define('MY_CSRF_COOKIE_NAME', APP_NAME . '_cookie_name');
define('MY_CSRF_EXPIRE', 150);
define('MY_SESS_COOKIE_NAME', APP_NAME . '_session');
define('MY_SESS_TABLE_NAME', APP_NAME . '_session');

// -- Etc
define('ADMIN_NAME', 'Administrator');
define('ADMIN_EMAIL', 'asd@ajetjet.com');
define('ADMIN_DATE_FORMAT', '%D, %d %M %Y %H:%i');
define('ADMIN_DATE_TIME_FORMAT', 'd/m/y H:i');
define('EMAIL_POSTF', '@ajetjet.com');
define('LOGIN_ATTEMPT', 3);
define('LOGIN_ATTEMPT_EXPIRE', 20); //60*60*24);


/*
| -------------------------------------------------------------------
| SETING PER APLIKASI
| -------------------------------------------------------------------
*/

// -- eSPTPD
/*
define('ESPTPD_DB_TYPE', 'postgre');  //mysql postgre
define('ESPTPD_DB_HOST', 'localhost');
define('ESPTPD_DB_PORT', '5432');
define('ESPTPD_DB_USER', 'postgres');
define('ESPTPD_DB_PASS', 'root');
define('ESPTPD_DB_NAME', 'pospst_bogor');
*/

// -- PBB-BPHTB Bogor
define('KD_PROPINSI', '32');
define('KD_DATI2', '03'); // 03

define('BPHTB_NEED_APPROVAL', FALSE);
define('BPHTB_BANJAR', FALSE);

define('INTEGRASI_PBB_BPHTB', 0);

//app_id buat filter tampilan modul aplikasi yg digunakan di sini  arig 2023-09-16
define('SEC_APPS_KD', "('eadm_bogor', 'penagihan', 'tool_pbb', 'pospbb', 'pospbb_ora', 'pospst_ora', 'pbbm_new')"); 

// -- POS PBB
// u/ kebutuhan report stts yg berbeda, diisi dengan nama daerah yg disesuaikan dlm folder pospbb/reports
define('POS_WIL', 'versi1');
define('DEF_POS_TYPE', 1);

if (DEF_POS_TYPE == 1) {
   define('POS_FIELD', 'kd_kanwil,kd_kantor,kd_tp'); //no_space
} else {
   //define('POS_FIELD', 'kd_bank_tunggal,kd_bank_persepsi,kd_kanwil_bank,kd_kppbb_bank,kd_tp'); //no_space
   define('POS_FIELD', 'kd_bank_tunggal,kd_bank_persepsi,kd_kanwil,kd_kantor,kd_tp');
}

//// CONSTANT
// $BASE_URL_EREG = $PROTOCOL . $SERVER . '/reg_sppt_bgr/';
$BASE_URL_EREG = 'http://bogorkab.net/reg_sppt_bgr/';

define('URL_EREG_PPT', $BASE_URL_EREG);
define('DOMAIN_SPPT', $BASE_URL_EREG);

// CONSTANTA

$URL_API_DISTRIBUSI = $PROTOCOL . $SERVER . '/distribusi_sppt_api/' ;

define('URL_API_DISTRIBUSI', $URL_API_DISTRIBUSI);

$URL_API_ANDROID = $PROTOCOL . $SERVER . '/pbb_api_android/' ;

define('URL_API_ANDROID', $URL_API_ANDROID);

$URL_API_SPPT_NEO = 'http://' . 'bogorkab.net/sppt_api_neo/pembatalan/' ;
$URL_API_SPPT_NEO_R = 'http://' . 'bogorkab.net/sppt_api_neo/' ;

define('URL_API_SPPT_NEO', $URL_API_SPPT_NEO);
define('URL_API_SPPT_NEO_R', $URL_API_SPPT_NEO_R);


define('FOLDER_GUZZLE', 'guzzle_v6/autoload.php');
// define('IP_KOMINFO', 'https://api-dev.esign.bogorkab.go.id/');
define('IP_KOMINFO', 'https://api.esign.bogorkab.go.id/');
define('AUTH_USER_ESIGN', 'bapenda');
define('AUTH_PASS_ESIGN', 'Bapenda@2023');
define('FOLDER_QR', 'dokumen/img_qr/');
define('URL_SPPT_WPCETAK','eadm_pbb');
define('NIK_ESIGN_DEV','3271061001770021');
define('PASS_ESIGN_DEV','BappendaJuara1!');
define('FOLDER_DRAFT_ESIGN','dokumen/draft_esign/');
define('FOLDER_ESIGN','dokumen/esign/');
define('SIGNED_MARK', '_signed');
$BASE_URL_EREG = $PROTOCOL . $SERVER . '/reg_sppt_bgr/';

// //// CONFIG SMTP GOOGLE
// define('SMTP_PROTOCOL', 'smtp');
// // define('SMTP_HOST', 'ssl://smtp.googlemail.com');   // HOST GOOGLE
// define('SMTP_HOST', 'ssl://smtp.googlemail.com');   // HOST GOOGLE
// define('SMTP_PORT', 465);     // PORT GOOGLE
// define('SMTP_UNAME', 'REG ESPPT KABUPATEN BOGOR');
// define('SMTP_TYPE', 'html');
// define('SMTP_CHARSET', 'iso-8859-1');
// define('EMAIL_EADM','subbidpsi2022@gmail.com');
// define('PASSWD_EADM','pldvtoochjjxyhor');
// define('SMTP_USER','subbidpsi2022@gmail.com');
// define('SMTP_PASS','pldvtoochjjxyhor');

//// SMTP bogorkab
define('SMTP_PROTOCOL', 'smtp');
define('SMTP_HOST', 'mail.bogorkab.go.id');
define('SMTP_PORT', 587);
define('SMTP_UNAME', 'REG ESPPT KABUPATEN BOGOR');
define('SMTP_TYPE', 'html');
define('SMTP_CHARSET', 'iso-8859-1');
define('EMAIL_EADM','pbbonline@bogorkab.go.id');
define('PASSWD_EADM','36v%m6qQg8');
define('SMTP_USER','pbbonline@bogorkab.go.id');
define('SMTP_PASS','36v%m6qQg8');
define('SMTP_CRYPTO', 'tls');

//API
define('LOGIN_API','https://halo.bappenda.bogorkab.go.id/mail-service/v1/login');
define('SEND_EMAIL_API','https://halo.bappenda.bogorkab.go.id/mail-service/v1/send-mail');
define('CLIENT_ID_API','9b5dd209-f720-4a6f-a156-c2d65b87bf7d');
define('CLIENT_SECRET_API','8250d205-1721-4a4d-a567-8873816cb80f');
