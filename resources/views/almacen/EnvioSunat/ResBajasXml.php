<?php
    $xml = new DomDocument('1.0', 'ISO-8859-1');
    $xml->standalone = false; 
    $xml->preserveWhiteSpace = false;
    $Invoice = $xml->createElement('VoidedDocuments');
    $Invoice = $xml->appendChild($Invoice);
    $Invoice->setAttribute('xmlns',"urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1");
    $Invoice->setAttribute('xmlns:cac',"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
    $Invoice->setAttribute('xmlns:cbc',"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
    $Invoice->setAttribute('xmlns:ds',"http://www.w3.org/2000/09/xmldsig#");
    $Invoice->setAttribute('xmlns:ext',"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
    $Invoice->setAttribute('xmlns:sac',"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
    $Invoice->setAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance");
    
    
    $UBLExtension = $xml->createElement('ext:UBLExtensions'); 
    $UBLExtension = $Invoice->appendChild($UBLExtension);

    $ext = $xml->createElement('ext:UBLExtension');
    $ext = $UBLExtension->appendChild($ext);

    $contents = $xml->createElement('ext:ExtensionContent',' '); 
    $contents = $ext->appendChild($contents);


    $cbc = $xml->createElement('cbc:UBLVersionID', '2.0'); 
    $cbc = $Invoice->appendChild($cbc);

    $cbc = $xml->createElement('cbc:CustomizationID', '1.0');
    $cbc = $Invoice->appendChild($cbc);
    $cbc = $xml->createElement('cbc:ID', 'RA-'.date('Ymd').'-1');
    $cbc = $Invoice->appendChild($cbc);

    $cbc = $xml->createElement('cbc:ReferenceDate', $fecha = date("Y-m-d")); 
    $cbc = $Invoice->appendChild($cbc);

    $cbc = $xml->createElement('cbc:IssueDate', date('Y-m-d')); 
    $cbc = $Invoice->appendChild($cbc);


    // signature
    $cac_signature = $xml->createElement('cac:Signature');
    $cac_signature = $Invoice->appendChild($cac_signature);

    $cbc = $xml->createElement('cbc:ID', 'IDSignKG'); 
    $cbc = $cac_signature->appendChild($cbc);

    $cac_signatory = $xml->createElement('cac:SignatoryParty'); 
    $cac_signatory = $cac_signature->appendChild($cac_signatory);

    $cac = $xml->createElement('cac:PartyIdentification');
    $cac = $cac_signatory->appendChild($cac);

    $cbc = $xml->createElement('cbc:ID', '20532710066'); 
    $cbc = $cac->appendChild($cbc);

    $cac = $xml->createElement('cac:PartyName'); 
    $cac = $cac_signatory->appendChild($cac);

    $cbc = $xml->createElement('cbc:Name', 'DESARROLLO DE SISTEMAS INTEGRADOS DE GESTION');
    $cbc = $cac->appendChild($cbc);

    $cac_digital = $xml->createElement('cac:DigitalSignatureAttachment'); 
    $cac_digital = $cac_signature->appendChild($cac_digital);

    $cac = $xml->createElement('cac:ExternalReference'); 
    $cac = $cac_digital->appendChild($cac);

    $cbc = $xml->createElement('cbc:URI', '#signatureKG');
    $cbc = $cac->appendChild($cbc);


    // Datos del emisor de la factura
    $cac_accounting = $xml->createElement('cac:AccountingSupplierParty');
    $cac_accounting = $Invoice->appendChild($cac_accounting);

    $cbc = $xml->createElement('cbc:CustomerAssignedAccountID', '20532710066'); 
    $cbc = $cac_accounting->appendChild($cbc);

    $cbc = $xml->createElement('cbc:AdditionalAccountID', '6'); 
    $cbc = $cac_accounting->appendChild($cbc);

    $cac_party = $xml->createElement('cac:Party'); 
    $cac_party = $cac_accounting->appendChild($cac_party);

    $cac = $xml->createElement('cac:PartyName'); 
    $cac = $cac_party->appendChild($cac);

    $cbc = $xml->createElement('cbc:Name', 'TOYOTA SURMOTRIZ'); 
    $cbc = $cac->appendChild($cbc);

    $legal = $xml->createElement('cac:PartyLegalEntity'); 
    $legal = $cac_party->appendChild($legal);

    $cbc = $xml->createElement('cbc:RegistrationName', 'SURMOTRIZ S.R.L.');
    $cbc = $legal->appendChild($cbc);


    $VoidedDocumentsLine = $xml->createElement('sac:VoidedDocumentsLine'); 
    $VoidedDocumentsLine = $Invoice->appendChild($VoidedDocumentsLine);

    $cbc = $xml->createElement('cbc:LineID','1'); 
    $cbc = $VoidedDocumentsLine->appendChild($cbc);

    $cbc = $xml->createElement('cbc:DocumentTypeCode','$doc'); 
    $cbc = $VoidedDocumentsLine->appendChild($cbc);

    $sac = $xml->createElement('sac:DocumentSerialID','$serie'); 
    $sac = $VoidedDocumentsLine->appendChild($sac);

    $sac = $xml->createElement('sac:DocumentNumberID','$cab_doc_gen[CDG_NUM_DOC]'); 
    $sac = $VoidedDocumentsLine->appendChild($sac);

    $sac = $xml->createElement('sac:VoidReasonDescription','Error Sistema'); 
    $sac = $VoidedDocumentsLine->appendChild($sac);


    $xml->formatOutput = true;
    $strings_xml = $xml->saveXML();
    $xml->save('20532710066-RA-'.date('Ymd').'-'.(1).'.xml');
?>