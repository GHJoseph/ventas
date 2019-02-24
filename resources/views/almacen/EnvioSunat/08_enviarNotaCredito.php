<?php 



class feedSoap extends SoapClient{
    public $XMLStr = "";
    public function setXMLStr($value){
        $this->XMLStr = $value;
    }
    public function getXMLStr(){
        return $this->XMLStr;
    }
    public function __doRequest($request, $location, $action, $version, $one_way = 0){
        $request = $this->XMLStr;
        $dom = new DOMDocument('1.0');
        try{
            $dom->loadXML($request);
        } catch (DOMException $e) {
            die($e->code);
        }
        $request = $dom->saveXML();
        //Solicitud
        return parent::__doRequest($request, $location, $action, $version, $one_way = 0);
    }
    public function SoapClientCall($SOAPXML){
        return $this->setXMLStr($SOAPXML);
    }
}
function soapCall($wsdlURL, $callFunction = "", $XMLString){
    $client = new feedSoap($wsdlURL, array('trace' => true));
    $reply  = $client->SoapClientCall($XMLString);
    //echo "REQUEST:\n" . $client->__getFunctions() . "\n";
    $client->__call("$callFunction", array(), array());
    //$request = prettyXml($client->__getLastRequest());
    //echo highlight_string($request, true) . "<br/>\n";
    return $client->__getLastResponse();
    //print_r($client);
}

require('lib/pclzip.lib.php');
$nom='20265835270-07-F002-11';
 ## Creación del archivo .ZIP
 /*$zip = new ZipArchive;
 $res = $zip->open($nom.'.zip', ZipArchive::CREATE);
 $zip->addFromString($nom.'.xml', $strings_xml);
 $zip->close(); 
*/
 $zip = new PclZip($nom.'.zip');
$zip->create($nom.".xml",PCLZIP_OPT_REMOVE_ALL_PATH);
chmod($nom.".zip", 0777);


 //$wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
 // 20532710066SURMOTR1 TOYOTA2051
 $wsdlURL = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl";
 $XMLString = '<?xml version="1.0" encoding="UTF-8"?>
     <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
      <soapenv:Header>
          <wsse:Security>
              <wsse:UsernameToken>
                  <wsse:Username>20532710066SURMOTR1</wsse:Username>
                  <wsse:Password>TOYOTA2051</wsse:Password>
              </wsse:UsernameToken>
          </wsse:Security>
      </soapenv:Header>
      <soapenv:Body>
          <ser:sendBill>
             <fileName>'.$nom.'.zip</fileName>
             <contentFile>'.base64_encode(file_get_contents($nom.'.zip')).'</contentFile>
          </ser:sendBill>
      </soapenv:Body>
     </soapenv:Envelope>';

 $result = soapCall($wsdlURL, $callFunction = "sendBill", $XMLString);
 preg_match_all('/<applicationResponse>(.*?)<\/applicationResponse>/is', $result, $matches);
 $archivo = fopen('R-'.$nom.'.zip', 'w+');
 fputs($archivo, base64_decode($matches[1][0]));
 fclose($archivo);
 chmod('R-'.$nom.'.zip', 0777);

 $archive = new PclZip('R-'.$nom.'.zip'); 
 if ($archive->extract()==0) {
      die("Error : ".$archive->errorInfo(true));
     }else{ chmod('R-'.$nom.'.xml', 0777); }
 


 sleep(2);
 //header('Location: comprobar.php?gen='.$gen.'&emp='.$emp.'&tip='.$cab_doc_gen['CDG_TIP_DOC'].'&num='.$cab_doc_gen['CDG_NUM_DOC'].'');
 echo '<div style="text-align: center"><img src="images/ok.png"><br>El documento fue enviado Exitosamente..!</div>';


?>