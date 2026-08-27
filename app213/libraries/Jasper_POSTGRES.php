<?php
/* Author : Ironman */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jasper {
    private $db;
    private $host;
    private $usr;
    private $pwd;
    private $port;

    public function __construct() {
        // postgres config
        $CI         =& get_instance();
        $this->db   = $CI->db->database;
        $this->host = $CI->db->hostname;
        $this->usr  = $CI->db->username;
        $this->pwd  = $CI->db->password;
        $this->port = empty($CI->db->port) ? '5432' : $CI->db->port;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

    /* see if the java extension was loaded. */
    function checkJavaExtension()
    {
        // pake pengecekan standar
        /*
        if (!extension_loaded('java')) {
            $sapi_type = php_sapi_name();
            $port      = (isset($_SERVER['SERVER_PORT']) && (($_SERVER['SERVER_PORT']) > 1024)) ? $_SERVER['SERVER_PORT'] : '8080';

            if ($sapi_type == "cgi" || $sapi_type == "cgi-fcgi" || $sapi_type == "cli") {
                if (!(PHP_SHLIB_SUFFIX == "so" && @dl('java.so')) && !(PHP_SHLIB_SUFFIX == "dll" && @dl('php_java.dll')) && !(@include_once("java/Java.inc")) && !(require_once("http://127.0.0.1:$port/java/Java.inc"))) {
                    return "java extension not installed.";
                }
            } else {
                if (!(@include_once("java/Java.inc"))) {
                    require_once("http://127.0.0.1:$port/java/Java.inc");
                }
            }
        }
        */

        // pake include dari http
        // $port = (isset($_SERVER['SERVER_PORT']) && (($_SERVER['SERVER_PORT'])>1024)) ? $_SERVER['SERVER_PORT'] : '8080';
        // require_once("http://127.0.0.1:$port/JavaBridge/java/Java.inc");

        // pake include lokal aja
        @include_once("java/Java.inc");

        if(!function_exists("java_get_server_name"))
            return "The loaded java extension is not the PHP/Java Bridge";
        return true;
    }

    /**
     * convert a php value to a java one...
     * @param string $value
     * @param string $className
     * @returns boolean success
     */
    function convertValue($value, $className)
    {
        // if we are a string, just use the normal conversion methods from the java extension...
        try {
            if ($className == 'java.lang.String') {
                $temp = new Java('java.lang.String', $value);
                return $temp;
            } else if ($className == 'java.lang.Boolean' || $className == 'java.lang.Integer' || $className == 'java.lang.Long' || $className == 'java.lang.Short' || $className == 'java.lang.Double' || $className == 'java.math.BigDecimal') {
                $temp = new Java($className, $value);
                return $temp;
            } else if ($className == 'java.sql.Timestamp' || $className == 'java.sql.Time') {
                $temp       = new Java($className);
                $javaObject = $temp->valueOf($value);
                return $javaObject;
            }
        }
        catch (Exception $err) {
            echo ('unable to convert value, ' . $value . ' could not be converted to ' . $className);
            return false;
        }

        echo ('unable to convert value, class name ' . $className . ' not recognised');
        return false;
    }

    function get_java() {
        return $this->get_java_properties();
    }

    function get_java_properties() {
        error_reporting(E_ALL);
        ini_set('display_errors','On');

        $checkJavaExt = $this->checkJavaExtension();
        if (!$checkJavaExt) return $checkJavaExt;

        $system = java("java.lang.System");
        return $system->getProperties();
    }

    function cetak($rpt, $param_data = array(), $type="pdf", $ignore_html_pg=TRUE) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');

        $checkJavaExt = $this->checkJavaExtension();
        if (!$checkJavaExt) return $checkJavaExt;

        // $rpt = 'simple';
        // $report     = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}.jasper";
        // $reportx    = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}.jrxml";
        $outputPath = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}";
        $reportx    = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}.jrxml";
        // $outputPath = sys_get_temp_dir()."//{$rpt}"; //buang ke tmp ajah

        if(!file_exists($reportx))
            return "File {$rpt}.jrxml tidak ditemukan!";

        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
        $report = $compileManager->compileReport($reportx);

        $params = new Java("java.util.HashMap");
        foreach ($param_data as $prm => $val) {
            $params->put($prm, $val);
        }

        // if ($type=="html") {
        if ($ignore_html_pg == TRUE) {
            $params->put("IS_IGNORE_PAGINATION", true);
        }

        java('java.lang.Class')->forName('org.postgresql.Driver');
        $conn = java('java.sql.DriverManager')->getConnection("jdbc:postgresql://{$this->host}:{$this->port}/{$this->db}?user={$this->usr}&password={$this->pwd}" );
        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $jasperPrint = $fillManager->fillReport($report, $params, $conn);

        /* */
        // bagus niy cm kayanya bakal tampil diserver.. hmmm nanti dah
        // $viewer = new JavaClass("net.sf.jasperreports.view.JasperViewer");
        // $viewer->viewReport($jasperPrint, false);
        // $conn->close();
        // die();
        /* */

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
        if ($type=="html") {
            $exportManager->exportReportToHtmlFile($jasperPrint, $outputPath);
            header("Content-type: text/html");
        } else {
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            header("Content-type: application/pdf");
            // paksa donlot ?
            // header('Content-Disposition: attachment;filename="' . $rpt . '.pdf"');
        }


//ekperimen sukses ke text
/*
    $exporter = new java("net.sf.jasperreports.engine.JRExporter");
    $outputPath = realpath(".") . "\\" . "report.txt";
    try {
        $exporter = new java("net.sf.jasperreports.engine.export.JRTextExporter");
        $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRTextExporterParameter")->PAGE_WIDTH, 180);
        $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRTextExporterParameter")->PAGE_HEIGHT, 180);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
    } catch (JavaException $ex) {
        print $ex;
    }
    header("Content-type: text/plain");
    $exporter->exportReport();
                // $outputPath = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}";
                $outputPath = realpath(".") . "\\" . "report.txt";

                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.JRTextExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRTextExporterParameter")->PAGE_WIDTH, 120);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRTextExporterParameter")->PAGE_HEIGHT, 60);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                    print $ex;
                }

                header("Content-type: text/plain");

                //header('Content-Disposition: attachment;filename="' . $rpt . '.txt"');


    $exporter->exportReport();
*/



        /* */
        // oh buat ngeprint...
        // $printManager = new JavaClass("net.sf.jasperreports.engine.JasperPrintManager");
        // $printManager->printPages($jasperPrint, 0,0, true);
        /* */

        readfile($outputPath);
        @unlink($outputPath);
        $conn->close();
    }

    // from cetak function coiiii
    function query_debug($rpt, $param_data = array()) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');

        $checkJavaExt = $this->checkJavaExtension();
        if (!$checkJavaExt) return $checkJavaExt;

        $outputPath = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}";
        $reportx    = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}.jrxml";

        if(!file_exists($reportx))
            return "File {$rpt}.jrxml tidak ditemukan!";

        $jasperxml = new java("net.sf.jasperreports.engine.xml.JRXmlLoader");
        $jasperDesign = $jasperxml->load($reportx);
        
        // $query = new java("net.sf.jasperreports.engine.design.JRDesignQuery");
        $query = $jasperDesign->getQuery();
        return $query->getText();
    }
}
?>