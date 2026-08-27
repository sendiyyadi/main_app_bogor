<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class download_client extends CI_Controller {
    
    function __construct(){
        parent::__construct();

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }
                
        //$this->load->helper(array('url','download'));  
        $this->load->helper(array('url_helper','download_helper'));             
    }
 
    public function index(){        
        $this->load->view('v_download');
    }
 
   function unduh_web2dm() {
 
        $path = 'app213/modules/pospbb_ora/web2dm/web2dm.sfx.exe'; // source data
        //$path = 'app213/modules/pospbb_ora/web2dm/baca.zip'; // source data
        $name = "web2dm.sfx.exe";     // target data
        //$name = "baca.zip"; // target data

        if(is_file($path))
        {
            // required for IE
            if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

            // get the file mime type using the file extension
            $this->load->helper('file');

            $mime = get_mime_by_extension($path);

            // Build the headers to push out the file properly.
            header('Pragma: public');     // required
            header('Expires: 0');         // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
            header('Cache-Control: private',false);
            header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
            header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($path)); // provide file size
            header('Connection: close');
            readfile($path); // push it out
            exit();
        }
    }

}
