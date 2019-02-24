<?php 
require 'robrichards/src/xmlseclibs.php';
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;    
date_default_timezone_set('America/Lima');
//$xml->formatOutput = true;

$nom = '20265835270-07-F002-11';
$docu = new DOMDocument();
$docu->load('factura-sin-firmar/20265835270-07-F002-11.xml');
$objDSig = new XMLSecurityDSig();
$objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
$objDSig->addReference(
    $docu,
    XMLSecurityDSig::SHA1,
    array('http://www.w3.org/2000/09/xmldsig#enveloped-signature'),
    array('force_uri' => true)
);
$objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type' => 'private'));
$objKey->loadKey('archivos_pem/private_key.pem', true);
$objDSig->sign($objKey);
$objDSig->add509Cert(file_get_contents('archivos_pem/public_key.pem'), true, false, array('subjectName' => true));
$objDSig->appendSignature($docu->getElementsByTagName('ExtensionContent')->item(1));
$strings_xml = $docu->saveXML();

$docu->save($nom.'.xml');
chmod($nom.'.xml', 0777);




?>