<?php
require 'robrichards/src/xmlseclibs.php';
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;    
date_default_timezone_set('America/Lima');
//20109065472-RA-20180717-1
  $i=1;
  $nom = '20109065472-RA-'.date('Ymd').'-1';
    $doc = new DOMDocument();
    $doc->load('factura-sin-firmar/20109065472-RA-20180717-1.xml');
    $objDSig = new XMLSecurityDSig();
    $objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
    $objDSig->addReference(
        $doc,
        XMLSecurityDSig::SHA1,
        array('http://www.w3.org/2000/09/xmldsig#enveloped-signature'),
        array('force_uri' => true)
    );
    //Crear una nueva clave de seguridad (privada)
    $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type' => 'private'));

    //Cargamos la clave privada
    $objKey->loadKey('archivos_pem/private_key.pem', true);
    $objDSig->sign($objKey);

    // Agregue la clave pública asociada a la firma
    $objDSig->add509Cert(file_get_contents('archivos_pem/public_key.pem'), true, false, array('subjectName' => true)); // array('issuerSerial' => true, 'subjectName' => true));

    // Anexar la firma al XML
    $objDSig->appendSignature($doc->getElementsByTagName('ExtensionContent')->item(0));
    $strings_xml = $doc->saveXML();

$doc->save($nom.'.xml');
chmod($nom.'.xml', 0777);

    ## Creación del archivo .ZIP
   
?>