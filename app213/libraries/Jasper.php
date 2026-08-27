<?php
/* Author :  */
/* Versi  : 2 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jasper {

    private $dbnm; // arig
    private $host;
    private $usr;
    private $pwd;
    private $port;
    private $dom;  // arig

    public function __construct() {
        // postgres config
        /*
        $CI         =& get_instance();
        $this->db   = $CI->db->database;
        $this->host = $CI->db->hostname;
        $this->usr  = $CI->db->username;
        $this->pwd  = $CI->db->password;
        $this->port = empty($CI->db->port) ? '5432' : $CI->db->port;
        */
        // oracle config
        $CI         =& get_instance();
        $this->dbnm = $CI->db->database;  // arig
        $this->host = $CI->db->hostname;
        $this->dom  = $CI->db->domain;   // arig
        $this->usr  = $CI->db->username;
        $this->pwd  = $CI->db->password;
        $this->port = empty($CI->db->port) ? '1521' : $CI->db->port;

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


    function cetak_ora($rpt, $param_data = array(), $type="pdf", $ignore_html_pg=TRUE) {

        error_reporting(E_ALL);
        ini_set('display_errors','On');
        
        $checkJavaExt = $this->checkJavaExtension();
        if (!$checkJavaExt) return $checkJavaExt;

        $outputPath = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}";
        $reportx    = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}.jrxml";
        // 
        if(!file_exists($reportx)){
            return "File {$rpt}.jrxml tidak ditemukan!";
            //return "File {$outputPath}.jrxml tidak ditemukan...xxxxxxxxxxx...........!";   
        }
        
        // die ($reportx);
        // digunakan Cetak oracle pake ref cursor plsql
        $jasperReport = new JavaClass("net.sf.jasperreports.engine.util.JRProperties");
        $jasperReport->setProperty("net.sf.jasperreports.query.executer.factory.plsql","com.jaspersoft.jrx.query.PlSqlQueryExecuterFactory");
        //
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

        java('java.lang.Class')->forName('oracle.jdbc.driver.OracleDriver');     

        /* $conn = java('java.sql.DriverManager')->getConnection("jdbc:oracle:thin:@192.168.1.200:1521/ORCL","SIMPAD","SIMPAD");  */
        $conn = java('java.sql.DriverManager')->getConnection("jdbc:oracle:thin:@{$this->dom}:{$this->port}/{$this->dbnm}","{$this->usr}","{$this->pwd}");
        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

        $jasperPrint = $fillManager->fillReport($report, $params, $conn);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");

        if ($type=="html") {
            $exportManager->exportReportToHtmlFile($jasperPrint, $outputPath);
            header("Content-type: text/html");
        } else {
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            header("Content-type: application/pdf");
        }
                
        readfile($outputPath);
        @unlink($outputPath);       
        $conn->close();
    }

    function export($rpt, $param_data = array(), $type="csv", $ignore_html_pg=TRUE) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');

        $checkJavaExt = $this->checkJavaExtension();
        if (!$checkJavaExt) return $checkJavaExt;

        $outputPath = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}";
        $reportx    = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}.jrxml";
        @chmod($outputPath, 0766);

        if(!file_exists($reportx))
            return "File {$rpt}.jrxml tidak ditemukan!";         
        
        $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
        $report = $compileManager->compileReport($reportx);

        $params = new Java("java.util.HashMap");
        foreach ($param_data as $prm => $val)
            $params->put($prm, $val);
        $params->put("IS_IGNORE_PAGINATION", $ignore_html_pg);

        java('java.lang.Class')->forName('org.postgresql.Driver');
        $conn = java('java.sql.DriverManager')->getConnection("jdbc:postgresql://{$this->host}:{$this->port}/{$this->db}?user={$this->usr}&password={$this->pwd}" );
        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $jasperPrint = $fillManager->fillReport($report, $params, $conn);

        //source: https://github.com/FraGoTe/JasperPHPlibrary/blob/master/generate.php
        $exporter = new java("net.sf.jasperreports.engine.JRExporter");
        set_time_limit(0);
        switch ($type) {
            case 'xls':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.JRXlsExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRXlsExporterParameter")->IS_ONE_PAGE_PER_SHEET, java("java.lang.Boolean")->FALSE);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRXlsExporterParameter")->IS_WHITE_PAGE_BACKGROUND, java("java.lang.Boolean")->FALSE);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRXlsExporterParameter")->IS_REMOVE_EMPTY_SPACE_BETWEEN_ROWS, java("java.lang.Boolean")->TRUE);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRXlsExporterParameter")->IS_DETECT_CELL_TYPE, java("java.lang.Boolean")->TRUE);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: application/vnd.ms-excel;");
                header("Content-Disposition: attachment; filename={$rpt}.xls");
                break;
            case 'csv':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.JRCsvExporter");
                    //$exporter->setParameter(java("net.sf.jasperreports.engine.export.JRCsvExporterParameter")->FIELD_DELIMITER, ",");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRCsvExporterParameter")->RECORD_DELIMITER, "\n");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRCsvExporterParameter")->CHARACTER_ENCODING, "UTF-8");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename={$rpt}.csv");
                break;
            case 'docx':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.ooxml.JRDocxExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment; filename={$rpt}.docx");
                break;
            case 'html':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.JRHtmlExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                break;
            case 'pdf':
                try {
                $exporter = new java("net.sf.jasperreports.engine.export.JRPdfExporter");
                $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename={$rpt}.pdf");
                header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT', true, 200);
                header("Expires: -1");
                break;
            case 'ods':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.oasis.JROdsExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: application/vnd.oasis.opendocument.spreadsheet");
                header("Content-Disposition: attachment; filename={$rpt}.ods");
                break;
            case 'odt':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.oasis.JROdtExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: application/vnd.oasis.opendocument.text");
                header("Content-Disposition: attachment; filename={$rpt}.odt");
                break;
            case 'txt':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.JRTextExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRTextExporterParameter")->PAGE_WIDTH, 120);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.export.JRTextExporterParameter")->PAGE_HEIGHT, 60);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: text/plain");
                break;
            case 'rtf':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.JRRtfExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: application/rtf");
                header("Content-Disposition: attachment; filename={$rpt}.rtf");
                break;
            case 'pptx':
                try {
                    $exporter = new java("net.sf.jasperreports.engine.export.ooxml.JRPptxExporter");
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
                    $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
                } catch (JavaException $ex) {
                        echo $ex;
                }
                header("Content-type: application/vnd.ms-powerpoint");
                header("Content-Disposition: attachment; filename={$rpt}.pptx");
                break;
        }
        $exporter->exportReport();

        readfile($outputPath);
        @unlink($outputPath);
        $conn->close();
    }

    function export_jasper2pdf($rpt, $param_data = array(), $type="pdf", $ignore_html_pg=TRUE, $folder_export=NULL, $pdf_exp="xyz") {

        error_reporting(E_ALL);
        ini_set('display_errors','On');

        $checkJavaExt = $this->checkJavaExtension();
        if (!$checkJavaExt) return $checkJavaExt;

        //$outputPath = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$pdf_exp}.pdf";
        //$outputPath = dirname(__FILE__)."//..//modules//".active_module()."//{$folder_exp}//{$pdf_exp}.pdf";
        // log_message('info', "EEEEEEEEEEEEEEEEEEEE  reportx : ". $reportx); 

        // jika kosong default
        if(empty($folder_export)){ $folder_export = FOLDER_DOKUMEN;}

        //$root_path = str_replace(SYSDIR."/", '', BASEPATH).FOLDER_DOK_APPROVED;
        $root_path = str_replace(SYSDIR."/", '', BASEPATH).$folder_export;
        $outputPath = $root_path."{$pdf_exp}.pdf";

        // kalo langsung begini ok
        //$outputPath = "C:/inetpub/wwwroot/siapkompak/dokumen/approved/tes.pdf";

        $reportx    = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}.jasper";
        @chmod($outputPath, 0766);

        if(!file_exists($reportx)){return "     File {$rpt}.jasper tidak ditemukan!"; }

        //log_message('info', "FFFFFFFFFFFFFFFFFFFF  outputPath : ". $outputPath); 
        // SYSDIR = sys213
        // C:/inetpub/wwwroot/siapkompak/sys213/

        //$compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
        //$compileManager->compileReport($reportx);
        $report = $reportx; 

        $params = new Java("java.util.HashMap");
        foreach ($param_data as $prm => $val){
            $params->put($prm, $val);
        }
        $params->put("IS_IGNORE_PAGINATION", $ignore_html_pg);

        java('java.lang.Class')->forName('oracle.jdbc.driver.OracleDriver');        
        $conn = java('java.sql.DriverManager')->getConnection("jdbc:oracle:thin:@{$this->dom}:{$this->port}/{$this->dbnm}","{$this->usr}","{$this->pwd}");
        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");
        //
        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $jasperPrint = $fillManager->fillReport($report, $params, $conn);

        //source: https://github.com/FraGoTe/JasperPHPlibrary/blob/master/generate.php
        $exporter = new java("net.sf.jasperreports.engine.JRExporter");
        set_time_limit(0);
       
        try {
        $exporter = new java("net.sf.jasperreports.engine.export.JRPdfExporter");
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->JASPER_PRINT, $jasperPrint);
        $exporter->setParameter(java("net.sf.jasperreports.engine.JRExporterParameter")->OUTPUT_FILE_NAME, $outputPath);
        } catch (JavaException $ex) {
                echo $ex;
        }
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename={$pdf_exp}.pdf");
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT', true, 200);
        header("Expires: -1");

        $exporter->exportReport();
       // readfile($outputPath);
       // @unlink($outputPath);
        $conn->close();
    }

    function cetak_byjasper($rpt, $param_data = array(), $type="pdf", $ignore_html_pg=TRUE) {

        error_reporting(E_ALL);
        ini_set('display_errors','On');

        $checkJavaExt = $this->checkJavaExtension();
        if (!$checkJavaExt) return $checkJavaExt;

        $outputPath = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}";
        $reportx    = dirname(__FILE__)."//..//modules//".active_module()."//reports//{$rpt}.jasper"; // extension sdh jasper

        if(!file_exists($reportx)){return "            File {$rpt} tidak ditemukan!";}

        $report = $reportx;

        $params = new Java("java.util.HashMap");
        foreach ($param_data as $prm => $val) {
            $params->put($prm, $val);
        }

        // if ($type=="html") {
        if ($ignore_html_pg == TRUE) {
            $params->put("IS_IGNORE_PAGINATION", true);
        }

        java('java.lang.Class')->forName('oracle.jdbc.driver.OracleDriver');        
        $conn = java('java.sql.DriverManager')->getConnection("jdbc:oracle:thin:@{$this->dom}:{$this->port}/{$this->dbnm}","{$this->usr}","{$this->pwd}");
        $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");
        //
        //parameters.put("REPORT_CONNECTION",conn);// conn is a java.sql.Connection object
        // $params->put("REPORT_CONNECTION", $conn);

        $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");
        $jasperPrint = $fillManager->fillReport($report, $params, $conn);

        $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
        if ($type=="html") {
            $exportManager->exportReportToHtmlFile($jasperPrint, $outputPath);
            header("Content-type: text/html");
        } else {
            $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            header("Content-type: application/pdf");
        }
                
        readfile($outputPath);
        @unlink($outputPath);       
        $conn->close(); 

    }

    // from cetak function  
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
