<?php


class feedSoap extends SoapClient
{
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
        try {
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
    $reply = $client->SoapClientCall($XMLString);
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
$NomArch = $nombre;

echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-bottom: 10px;">';
echo 'Archivo .XML (factura electrónica) a comprimir.<br>';
echo '<span style="color: #000000;">' . $NomArch . '.xml</span>';
echo '</div>';

echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-bottom: 10px;">';
echo 'Archivo .ZIP (conteniendo el doc. electrónico) a enviar al servidor de SUNAT.<br>';
echo '<span style="color: #000000;">' . $NomArch . '.zip</span>';
echo '</div>';

$zip = new PclZip('Documentos_EnviarSunat/' . $NomArch . '.zip');
$zip->create('Documentos_EnviarSunat/' . $NomArch . '.xml', PCLZIP_OPT_REMOVE_PATH, "Documentos_EnviarSunat");
chmod('Documentos_EnviarSunat/' . $NomArch . '.zip', 0777);

$wsdlURL = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl";
$XMLString = '<?xml version="1.0" encoding="UTF-8"?>
        <soapenv:Envelope
        xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
         xmlns:ser="http://service.sunat.gob.pe"
         xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
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
        <fileName>' . $NomArch . '.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents('Documentos_EnviarSunat/' . $NomArch . '.zip')) . '</contentFile>
        </ser:sendSummary>
        </soapenv:Body>
        </soapenv:Envelope>';
$resul = soapCall($wsdlURL, $callFunction = "sendSummary", $XMLString);
echo $resul;
echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099;">';
echo 'SOAP de envío al servidor de SUNAT con el método sendBill.';
echo '</div>';
echo $XMLString;

preg_match_all('/<ticket>(.*?)<\/ticket>/is', soapCall($wsdlURL, $callFunction = "sendSummary", $XMLString), $ticket);
$ticket = $ticket[1][0];
echo 'Ticket' . $ticket . '<br>';
sleep(20);
echo 'hola';
//$ticketEnviado='201802473988891';
//echo 'Ticket Enviado'.$ticketEnviado.'<br>';
$XMLString2 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
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
        <ticket>' . $ticket . '</ticket>
        </ser:getStatus>
        </soapenv:Body>
        </soapenv:Envelope>';
echo $XMLString2 . '<br>';

preg_match_all('/<statusCode>(.*?)<\/statusCode>/is', soapCall($wsdlURL, $callFunction = "getStatus", $XMLString2), $codigo);
$codigo = $codigo[1][0];
echo 'CODIGO' . ':' . $codigo;

if ($codigo == '0' || $codigo == '0098') {
    // guarda las boletas y sus notas en cada uno de sus items
    if ($codigo == '0') {
        if (isset($boletas)) {
            foreach ($boletas as $boleta) {
                //para saber si es boleta o nota
                if ($boleta['serie'] == 'BN03' || $boleta['serie'] == 'BN04') {
                    $tip_doc = 'A';
                } else {
                    $tip_doc = 'B';
                }
                $update = "update cab_doc_gen SET cdg_sun_env='S', cdg_cod_snt='0001' WHERE cdg_num_doc >= '" . $boleta['first'] . "' and cdg_num_doc <= '" . $boleta['last'] . "' and cdg_ser_doc='" . $boleta['serie'][3] . "' and cdg_tip_doc='" . $tip_doc . "' and cdg_cod_emp='" . $emp . "'";
                $stmt = oci_parse($conn, $update);
                oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
                oci_free_statement($stmt);
            }
        }

    }
    // guarda en la tabla resumenes
    if (isset($boletas)) {

        foreach ($boletas as $bol) {

            // consulta los anteriores para los ticket
            $sql_anterior = "select * from resumenes where serie='" . $bol['serie'] . "' and  inicio='" . $bol['first'] . "' and emp='" . $emp . "' ";
            $sql_parse = oci_parse($conn, $sql_anterior);
            oci_execute($sql_parse);
            oci_fetch_all($sql_parse, $anteriores, null, null, OCI_FETCHSTATEMENT_BY_ROW);
            foreach ($anteriores as $anterior) {
                // eliminar los anteriores
                $sql_delete = "DELETE FROM resumenes WHERE ticket= '" . $anterior['TICKET'] . "' ";
                $stmt_delete = oci_parse($conn, $sql_delete);
                oci_execute($stmt_delete);
            }

            $sql_insert = "insert into resumenes (FECHA,TICKET,SERIE,INICIO,FINAL,SUBTOTAL,DESCUENTO,GRAVADA,IGV,TOTAL,CODIGO,EMP) values (to_date('" . $_GET['fecha'] . "','yyyy-mm-dd'),'" . $ticket . "','" . $bol['serie'] . "','" . $bol['first'] . "','" . $bol['last'] . "','" . $bol['sub'] . "','" . $bol['descuentos'] . "','" . $bol['gravadas'] . "','" . $bol['igv'] . "','" . $bol['total'] . "','" . $codigo . "','" . $emp . "')";
            $stmt_insert = oci_parse($conn, $sql_insert);
            oci_execute($stmt_insert);
        }
    }

    //print_r($bols);
    echo '<div style="text-align: center;">';
    echo '<img src="./images/ok.png"><br>';
    echo 'El Resumen existe y fue procesado correctamente Nro ' . $ticket;
    echo '</div>';
} else {
    echo '<div style="text-align: center;">';
    echo '<img src="./images/error.png"><br>';
    echo 'hubo un error al enviar el resumen intentelo mas tarde';
    echo '</div>';
}
?>