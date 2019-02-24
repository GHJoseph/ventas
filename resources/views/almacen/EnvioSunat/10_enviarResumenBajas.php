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
    // 3.- Enviar documento xml y obtener respuesta
    // ============================================
    require('lib/pclzip.lib.php'); // Librería que comprime archivos en .ZIP
    ## Creación del archivo .ZIP
    $NomArch='20109065472-RA-20180717-1';

    echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-bottom: 10px;">';
    echo 'Archivo .XML (factura electrónica) a comprimir.<br>';
    echo '<span style="color: #000000;">'.$NomArch.'.xml</span>';
    echo '</div>';
    
    echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-bottom: 10px;">';
    echo 'Archivo .ZIP (conteniendo el doc. electrónico) a enviar al servidor de SUNAT.<br>';
    echo '<span style="color: #000000;">'.$NomArch.'.zip</span>';
    echo '</div>';

    $zip = new PclZip($NomArch.'.zip');
    $zip->create($NomArch.'.xml',PCLZIP_OPT_REMOVE_ALL_PATH);
    chmod($NomArch.'.zip', 0777);

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
      <ser:sendSummary>
        <fileName>'.$NomArch.'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($NomArch.'.zip')) . '</contentFile>
      </ser:sendSummary>
    </soapenv:Body>
  </soapenv:Envelope>';
   $resul = soapCall($wsdlURL, $callFunction = "sendSummary", $XMLString); 
   echo $resul;
   
   echo '
  <div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099;">';
   echo 'SOAP de envío al servidor de SUNAT con el método sendBill.'; 
   echo '</div>'; /*========================================================================================================================*/ 
   preg_match_all('/<ticket>(.*?)<\/ticket>/is', soapCall($wsdlURL, $callFunction = "sendSummary", $XMLString), $ticket);
    $ticket= $ticket[1][0];
     echo 'Ticket'. $ticket.'<br>';
      sleep(20); echo 'hola'; /*$ticketEnviado='201802473988891'; //echo 'Ticket Enviado.$ticketEnviado. ;*/ $XMLString2 = '
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
          <ser:getStatus>
            <ticket>'.$ticket.'</ticket>
          </ser:getStatus>
        </soapenv:Body>
      </soapenv:Envelope>'; echo $XMLString2.'
      <br>'; 
      preg_match_all('/<statusCode>(.*?)<\/statusCode>/is',soapCall($wsdlURL, $callFunction = "getStatus", $XMLString2) , $codigo); 
      $codigo = $codigo[1][0]; echo 'CODIGO'.':'. $codigo; ?>