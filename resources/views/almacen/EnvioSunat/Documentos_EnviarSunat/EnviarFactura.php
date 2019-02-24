<label></label>
<?php
include('../../conexion.php');
header('Content-Type: text/html; charset=UTF-8');
require('../lib/pclzip.lib.php'); // Librería que comprime archivos en .ZIP

$Nombre= $_GET['Nombre'];

// NOMBRE DE ARCHIVO A PROCESAR.
$NomArch=$Nombre;

echo $CodDoc=substr($NomArch, 12, 2);
echo $SerDoc=substr($NomArch, 15, 4);
echo $NumDoc=substr($NomArch, 20, 6);


## =============================================================================
## Creación del archivo .ZIP

echo '<label>Archivo .XML (factura electrónica) a comprimir.</label><br>';
echo '<span style="color: #000000;">'.$NomArch.'.xml</span> <br>';



echo '<label>Archivo .ZIP (conteniendo el doc. electrónico) a enviar al servidor de SUNAT.</label><br>';
echo '<span style="color: #000000;">'.$NomArch.'.zip</span><br>';


$zip = new PclZip($NomArch.".zip");
$zip->create($NomArch.".xml");
chmod($NomArch.".zip", 0777);

       



# ==============================================================================
# Procedimiento para enviar comprobante a la SUNAT
class feedSoap extends SoapClient{

    public $XMLStr = "";

    public function setXMLStr($value)
    {
        $this->XMLStr = $value;
    }

    public function getXMLStr()
    {
        return $this->XMLStr;
    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        $request = $this->XMLStr;

        $dom = new DOMDocument('1.0');

        try
        {
            $dom->loadXML($request);
        } catch (DOMException $e) {
            die($e->code);
        }

        $request = $dom->saveXML();

        //Solicitud
        return parent::__doRequest($request, $location, $action, $version, $one_way = 0);
    }

    public function SoapClientCall($SOAPXML)
    {
        return $this->setXMLStr($SOAPXML);
    }
}
function soapCall($wsdlURL, $callFunction = "", $XMLString)
{
    $client = new feedSoap($wsdlURL, array('trace' => true));
    $reply  = $client->SoapClientCall($XMLString);

    //echo "REQUEST:\n" . $client->__getFunctions() . "\n";
    $client->__call("$callFunction", array(), array());
    //$request = prettyXml($client->__getLastRequest());
    //echo highlight_string($request, true) . "<br/>\n";
    return $client->__getLastResponse();
}


//URL para enviar las solicitudes a SUNAT
$wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';


echo '<label>URL Beta de SUNAT:</label><br>';
echo '<span style="color: #000000;">'.$wsdlURL.'</span> <br>';

//Estructura del XML para la conexión
$XMLString = '<?xml version="1.0" encoding="UTF-8"?>
  <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
    <soapenv:Header>
      <wsse:Security>
        <wsse:UsernameToken Id="ABC-123">
          <wsse:Username>20532710066MODDATOS</wsse:Username>
          <wsse:Password>MODDATOS</wsse:Password>
        </wsse:UsernameToken>
      </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
      <ser:sendBill>
        <fileName>'.$NomArch.'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($NomArch.'.zip')) . '</contentFile>
      </ser:sendBill>
    </soapenv:Body>
  </soapenv:Envelope>'; /*=========================================================================================================================================*/ /*=================================================================================*/ echo '
  <label>SOAP de envío al servidor de SUNAT con el método sendBill.</label>
  <br>'; /*echo $XMLString; *//*Realizamos la llamada a nuestra función*/ $result = soapCall($wsdlURL, $callFunction = "sendBill", $XMLString); preg_match_all('/
  <applicationResponse>(.*?)
    <\/applicationResponse>/is', $result, $matches); echo '
      <label>Respuesta del servidor de SUNAT:</label>
      <br>'; echo '<span style="color: #000000;">'.$result.'</span>'; /*Descargamos el Archivo Response*/ $archivo = fopen($NomArch.'.xml','w+'); fputs($archivo,$result); fclose($archivo); /*LEEMOS EL ARCHIVO XML*/ $xml = simplexml_load_file($NomArch.'.xml'); foreach ($xml->xpath('//applicationResponse') as $response){ } /*AQUI DESCARGAMOS EL ARCHIVO CDR(CONSTANCIA DE RECEPCIÓN)*/ $cdr=base64_decode($response); $archivo = fopen('R-'.$NomArch.'.zip','w+'); fputs($archivo,$cdr); fclose($archivo); chmod('R-'.$NomArch.'.zip', 0777); echo '
      <label>Archivo .ZIP recibido.</label>
      <br>'; echo '<span style="color: #000000;">R-'.$NomArch.'.zip</span>
      <br>'; $archive = new PclZip('R-'.$NomArch.'.zip'); if ($archive->extract()==0) { die("Error : ".$archive->errorInfo(true)); } else{ chmod('R-'.$NomArch.'.xml', 0777); /*=========================================Actualizar tabla ============================================================================== */$consulta="UPDATE ventas_resumen set Estado='C',Imprimir='E' WHERE Cod_Doc='$CodDoc' and Ser_Doc='$SerDoc' and Num_Doc='$NumDoc'"; if (mysqli_query($conexion, $consulta)) { echo "Accion Corecta"; } else { echo "Error: " . $consulta . "
      <br>" . mysqli_error($conexion); }/* =================================================================================*/ } echo '
      <label>Archivo .XML constancia de recepción (CRD) ya descomprimido.</label>
      <br>'; echo '<span style="color: #A70202;">R-'.$NomArch.'.xml</span>'; /*Eliminamos el Archivo Response*/ unlink($NomArch.'.xml');