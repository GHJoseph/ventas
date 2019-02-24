<?php
header('Content-Type: text/html; charset=UTF-8');
echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16pt; color: #000000; margin-bottom: 10px;">';
echo 'SUNAT. Facturación electrónica Perú.<br>';
echo '<span style="color: #000099; font-size: 15pt;">Crear archivo .XML correspondiente a la factura electrónica.</span>';
echo '<hr width="100%"></div>';

$xml = new DomDocument('1.0', 'ISO-8859-1');

$xml->standalone = false;
$xml->preserveWhiteSpace = false;

$summary = $xml->createElement('SummaryDocuments');
$summary = $xml->appendChild($summary);
// Set the attributes.
$summary->setAttribute('xmlns', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SummaryDocuments-1');
$summary->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$summary->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$summary->setAttribute('xmlns:ds', "http://www.w3.org/2000/09/xmldsig#");
$summary->setAttribute('xmlns:ext', "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
$summary->setAttribute('xmlns:sac', "urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
$summary->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");

$UBLExtensions = $xml->createElement('ext:UBLExtensions');
$UBLExtensions = $summary->appendChild($UBLExtensions);

$UBLExtension = $xml->createElement('ext:UBLExtension');
$UBLExtension = $UBLExtensions->appendChild($UBLExtension);

$ExtensionContent = $xml->createElement('ext:ExtensionContent');
$ExtensionContent = $UBLExtension->appendChild($ExtensionContent);

$UBLVersionID = $xml->createElement('cbc:UBLVersionID', '2.0');
$UBLVersionID = $summary->appendChild($UBLVersionID);

$CustomizationID = $xml->createElement('cbc:CustomizationID', '1.1');
$CustomizationID = $summary->appendChild($CustomizationID);

$ID = $xml->createElement('cbc:ID', 'RC-' . date("Ymd", strtotime($fecha)) . '-' . (intval($correlativo->Num_Doc) + 1));
$ID = $summary->appendChild($ID);

$ReferenceDate = $xml->createElement('cbc:ReferenceDate', $fecha);
$ReferenceDate = $summary->appendChild($ReferenceDate);

$IssueDate = $xml->createElement('cbc:IssueDate', $fecha);
$IssueDate = $summary->appendChild($IssueDate);

//Inicio Signature
$Signature = $xml->createElement('cac:Signature');
$Signature = $summary->appendChild($Signature);

$ID = $xml->createElement('cbc:ID', $resumen[0]->RUC_EMP);
$ID = $Signature->appendChild($ID);
//Inicio SignatoryParty
$SignatoryParty = $xml->createElement('cac:SignatoryParty');
$SignatoryParty = $Signature->appendChild($SignatoryParty);

$PartyIdentification = $xml->createElement('cac:PartyIdentification');
$PartyIdentification = $SignatoryParty->appendChild($PartyIdentification);

$ID = $xml->createElement('cbc:ID', $resumen[0]->RUC_EMP);
$ID = $PartyIdentification->appendChild($ID);

$PartyName = $xml->createElement('cac:PartyName');
$PartyName = $SignatoryParty->appendChild($PartyName);

$Name = $xml->createElement('cbc:Name', $resumen[0]->Nom_Emp);
$Name = $PartyName->appendChild($Name);
//Fin SignatoryParty

//Inicio DigitalSignatureAttachment
$DigitalSignatureAttachment = $xml->createElement('cac:DigitalSignatureAttachment');
$DigitalSignatureAttachment = $Signature->appendChild($DigitalSignatureAttachment);

$ExternalReference = $xml->createElement('cac:ExternalReference');
$ExternalReference = $DigitalSignatureAttachment->appendChild($ExternalReference);

$URI = $xml->createElement('cbc:URI', $resumen[0]->RUC_EMP);
$URI = $ExternalReference->appendChild($URI);
//Fin DigitalSignatureAttachment
//Fin Signature

//Inicio AccountingSupplierParty
$AccountingSupplierParty = $xml->createElement('cac:AccountingSupplierParty');
$AccountingSupplierParty = $summary->appendChild($AccountingSupplierParty);

$CustomerAssignedAccountID = $xml->createElement('cbc:CustomerAssignedAccountID', $resumen[0]->RUC_EMP);
$CustomerAssignedAccountID = $AccountingSupplierParty->appendChild($CustomerAssignedAccountID);

$AdditionalAccountID = $xml->createElement('cbc:AdditionalAccountID', '6');
$AdditionalAccountID = $AccountingSupplierParty->appendChild($AdditionalAccountID);

//Inicio Party
$Party = $xml->createElement('cac:Party');
$Party = $AccountingSupplierParty->appendChild($Party);

$PartyLegalEntity = $xml->createElement('cac:PartyLegalEntity');
$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);

$RegistrationName = $xml->createElement('cbc:RegistrationName', $resumen[0]->Nom_Emp);
$RegistrationName = $PartyLegalEntity->appendChild($RegistrationName);
//Fin Party
//Fin AccountingSupplierParty
foreach ($resumen as $i => $boleta) {
//Inicio SummaryDocumentsLine
    if ($i !== 1) {
        $SummaryDocumentsLine = $xml->createElement('sac:SummaryDocumentsLine');
        $SummaryDocumentsLine = $summary->appendChild($SummaryDocumentsLine);

        $LineID = $xml->createElement('cbc:LineID', $i + 1);
        $LineID = $SummaryDocumentsLine->appendChild($LineID);

        $DocumentTypeCode = $xml->createElement('cbc:DocumentTypeCode', $boleta->Cod_Doc);
        $DocumentTypeCode = $SummaryDocumentsLine->appendChild($DocumentTypeCode);

        $ID = $xml->createElement('cbc:ID', $boleta->Ser_Doc . '-' . substr($boleta->Num_Doc, -6));
        $ID = $SummaryDocumentsLine->appendChild($ID);

//Inicio AccountingCustomerParty
        $AccountingCustomerParty = $xml->createElement('cac:AccountingCustomerParty');
        $AccountingCustomerParty = $SummaryDocumentsLine->appendChild($AccountingCustomerParty);

        $CustomerAssignedAccountID = $xml->createElement('cbc:CustomerAssignedAccountID', $boleta->Num_Doc_CP);
        $CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);

        $AdditionalAccountID = $xml->createElement('cbc:AdditionalAccountID', $boleta->Cod_Doc_CP);
        $AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);
//Fin AccountingCustomerParty

//Inicio Status
        $Status = $xml->createElement('cac:Status');
        $Status = $SummaryDocumentsLine->appendChild($Status);
        if ($boleta->Estado == 'P') {
            $estado = '1';
        } elseif ($boleta->Estado == 'A') {
            $estado = '3';
        }
        $ConditionCode = $xml->createElement('cbc:ConditionCode', $estado);
        $ConditionCode = $Status->appendChild($ConditionCode);
//Fin Status

        $TotalAmount = $xml->createElement('sac:TotalAmount', $boleta->Tot_Vta_MN);
        $TotalAmount = $SummaryDocumentsLine->appendChild($TotalAmount);
        $TotalAmount->setAttribute('currencyID', "PEN");

//Inicio BillingPayment
        $BillingPayment = $xml->createElement('sac:BillingPayment');
        $BillingPayment = $SummaryDocumentsLine->appendChild($BillingPayment);

        $PaidAmount = $xml->createElement('cbc:PaidAmount', $boleta->Val_Vta_MN);
        $PaidAmount = $BillingPayment->appendChild($PaidAmount);
        $PaidAmount->setAttribute('currencyID', "PEN");

        $InstructionID = $xml->createElement('cbc:InstructionID', '01');
        $InstructionID = $BillingPayment->appendChild($InstructionID);
//Fin BillingPayment

//Inicio TaxTotal
        $TaxTotal = $xml->createElement('cac:TaxTotal');
        $TaxTotal = $SummaryDocumentsLine->appendChild($TaxTotal);

        $TaxAmount = $xml->createElement('cbc:TaxAmount', $boleta->Igv_Vta_MN);
        $TaxAmount = $TaxTotal->appendChild($TaxAmount);
        $TaxAmount->setAttribute('currencyID', "PEN");

        $TaxSubtotal = $xml->createElement('cac:TaxSubtotal');
        $TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

        $TaxAmount = $xml->createElement('cbc:TaxAmount', $boleta->Igv_Vta_MN);
        $TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
        $TaxAmount->setAttribute('currencyID', "PEN");

        $TaxCategory = $xml->createElement('cac:TaxCategory');
        $TaxCategory = $TaxSubtotal->appendChild($TaxCategory);

        $TaxScheme = $xml->createElement('cac:TaxScheme');
        $TaxScheme = $TaxCategory->appendChild($TaxScheme);

        $ID = $xml->createElement('cbc:ID', '1000');
        $ID = $TaxScheme->appendChild($ID);

        $Name = $xml->createElement('cbc:Name', 'IGV');
        $Name = $TaxScheme->appendChild($Name);

        $TaxTypeCode = $xml->createElement('cbc:TaxTypeCode', 'VAT');
        $TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
    }
}
// Fin TaxScheme
// Fin TaxCategory
//Fin TaxSubtotal
//Fin TaxTotal
// Fin SummaryDocumentsLine

$xml->formatOutput = true;
$strings_xml = $xml->saveXML();
$nombre = $resumen[0]->RUC_EMP . '-RC-' . date("Ymd", strtotime($fecha)) . '-' . '1';
$estado = $xml->save('Documentos_Sin_Firma/' . $nombre . '.xml');
//chmod('Documentos_Sin_Firma/' . $nombre . '.xml', 0777);
echo '<span style="color: #015B01; font-size: 15pt;">Resumen de boletas creada:</span>&nbsp;';
echo '<span style="color: #B21919; font-size: 15pt;">' . $nombre . '.xml</span><br>';
include('05_FirmarBoleta.php');

    

