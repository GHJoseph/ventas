<?php
  
 header('Content-Type: text/html; charset=UTF-8');
  include('../conexion.php');
 


  $sql="CALL USP_SEEK_VENTAS_BOLETAS_SUNAT('01','01') ";
  $List_Result=mysqli_query($conexion,$sql);

echo "Error : Sunat ";
/*
if (mysqli_num_rows($List_Result) > 0) {
  
   while($row = mysqli_fetch_array($List_Result)) {
     
     
     
    $cPeriodo =date("Y-m-d");
    echo $cNumVnt=$row["Num_Vnt"];
    $cCodDoc=$row["Cod_Doc"];
    $cTipDoc=$row["Tip_Doc"];
    $cSerDoc=$row["Ser_Doc"];
    $cNumDoc=$row["Num_Doc"];
    $cFecDoc=$row["Fec_Doc"];
     
     // Documento que Modifica - Referencia - Es una Boleta
     $cCodDocRef=$row["Cod_Doc_Ref"];
     $cTipDocRef=$row["Tip_Doc_Ref"];
     $cSerDocRef=$row["Ser_Doc_Ref"];
     
     if($row["Num_Doc_Ref"]!=""){
       $cNumDocRef=$row["Num_Doc_Ref"];
     }else{
       $cNumDocRef="";
     }
     
     $cFecDocRef=$row["Fec_Doc_Ref"];
      $cUsuario=$row["Usuario"];
      $cTipDocCP=$row["Tip_Doc_CP"];
      $cNumDocCP=$row["Num_Doc_CP"];
      $cNomCP=$row["Nom_CP"];
      
       $cRucEmp=$row["RUC_EMP"];
      $cNomEmp=$row["Nom_Emp"];
        $cDirEmp=$row["DIR_EMP"]; /// error de progrma 
      $cCodDisEmp=$row["COD_DIS_EMP"];
      $cNomDisEmp=$row["NOM_DIS_EMP"];
      $cCodProEmp=$row["COD_PRO_EMP"];
      $cNomProEmp=$row["NOM_PRO_EMP"];
      $cCodDepEmp=$row["COD_DEP_EMP"];
      $cNomDepEmp=$row["NOM_DEP_EMP"];
      $cCodPaisEmp=$row["COD_PAIS_EMP"];
      $cNomPaisEmp=$row["NOM_PAIS_EMP"];
     
      
   }
  
  
  
  
  
}
*/
?>
  <?php
 /*$j=1;
    while(file_exists($ruta.'20532710066-RC-'.date('Ymd').'-'.$j.'.xml')){
        $j++;
        // el valor de i es el actual que se va crear
    }
   $xml = new DomDocument('1.0', 'ISO-8859-1');
    $xml->standalone         = false;
    $xml->preserveWhiteSpace = false;
    $Invoice = $xml->createElement('SummaryDocuments'); 
    $Invoice = $xml->appendChild($Invoice);
    $Invoice->setAttribute('xmlns',"urn:sunat:names:specification:ubl:peru:schema:xsd:SummaryDocuments-1");
    $Invoice->setAttribute('xmlns:cac',"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
    $Invoice->setAttribute('xmlns:cbc',"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
   $Invoice->setAttribute('xmlns:ds',"http://www.w3.org/2000/09/xmldsig#");
    $Invoice->setAttribute('xmlns:ext',"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
    $Invoice->setAttribute('xmlns:sac',"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
    $Invoice->setAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance");
        //$Invoice->setAttribute('xsi:schemaLocation','urn:sunat:names:specification:ubl:peru:schema:xsd:InvoiceSummary-1 D:\UBL_SUNAT\SUNAT_xml_20110112\20110112\xsd\maindoc\UBLPE-InvoiceSummary-1.0.xsd');
    $UBLExtension = $xml->createElement('ext:UBLExtensions'); 
    $UBLExtension = $Invoice->appendChild($UBLExtension);
    $ext = $xml->createElement('ext:UBLExtension'); 
    $ext = $UBLExtension->appendChild($ext);
    $contents = $xml->createElement('ext:ExtensionContent');
    $contents = $ext->appendChild($contents);

    $cbc = $xml->createElement('cbc:UBLVersionID', '2.0'); 
    $cbc = $Invoice->appendChild($cbc);
    $cbc = $xml->createElement('cbc:CustomizationID', '1.0'); 
    $cbc = $Invoice->appendChild($cbc);
    $cbc = $xml->createElement('cbc:ID', 'RC-'.date('Ymd').'-'.'1');//$j 1 
    $cbc = $Invoice->appendChild($cbc);
    $cbc = $xml->createElement('cbc:ReferenceDate', '12/07/2018'); //$_GET['fecha']
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
     $cac = $xml->createElement('cac:ExternalReference'); $cac = $cac_digital->appendChild($cac);
     $cbc = $xml->createElement('cbc:URI', '#signatureKG'); $cbc = $cac->appendChild($cbc);


        // Datos Surmotriz
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


       //foreach ($boletas as $index => $bol){

            $SummaryDocumentsLine = $xml->createElement('sac:SummaryDocumentsLine');
            $SummaryDocumentsLine = $Invoice->appendChild($SummaryDocumentsLine);
            $cbc = $xml->createElement('cbc:LineID',1+1);
            $cbc = $SummaryDocumentsLine->appendChild($cbc);

            $cbc = $xml->createElement('cbc:DocumentTypeCode','serie_tipo');
            $cbc = $SummaryDocumentsLine->appendChild($cbc);

            $sac = $xml->createElement('sac:DocumentSerialID','serie');
            $sac = $SummaryDocumentsLine->appendChild($sac);

            $sac = $xml->createElement('sac:StartDocumentNumberID','first'); 
            $sac = $SummaryDocumentsLine->appendChild($sac);

            $sac = $xml->createElement('sac:EndDocumentNumberID','last');
            $sac = $SummaryDocumentsLine->appendChild($sac);

            $sac = $xml->createElement('sac:TotalAmount', 'total'); 
            $sac = $SummaryDocumentsLine->appendChild($sac); 
            $sac->setAttribute('currencyID',"PEN");
 
            // Gravado
            $sac = $xml->createElement('sac:BillingPayment'); 
            $sac = $SummaryDocumentsLine->appendChild($sac);

            $cbc = $xml->createElement('cbc:PaidAmount', 'gravadas'); 
            $cbc = $sac->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");
            $cbc = $xml->createElement('cbc:InstructionID','01'); 
            $cbc = $sac->appendChild($cbc);
           

        // Exonerado
            $sac = $xml->createElement('sac:BillingPayment');
            $sac = $SummaryDocumentsLine->appendChild($sac);
            $cbc = $xml->createElement('cbc:PaidAmount','0.00'); 
            $cbc = $sac->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");
            $cbc = $xml->createElement('cbc:InstructionID','02'); 
            $cbc = $sac->appendChild($cbc);
            
    // Inafecto
            $sac = $xml->createElement('sac:BillingPayment'); 
            $sac = $SummaryDocumentsLine->appendChild($sac);
            $cbc = $xml->createElement('cbc:PaidAmount','0.00');
            $cbc = $sac->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");
            $cbc = $xml->createElement('cbc:InstructionID','03');
            $cbc = $sac->appendChild($cbc);

            // otros cargos
            $cac = $xml->createElement('cac:AllowanceCharge'); 
            $cac = $SummaryDocumentsLine->appendChild($cac);
            $cbc = $xml->createElement('cbc:ChargeIndicator','true');
            $cbc = $cac->appendChild($cbc);
            $cbc = $xml->createElement('cbc:Amount','0.00'); 
            $cbc = $cac->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");

            // Total ISC
            $TaxTotal = $xml->createElement('cac:TaxTotal');
            $TaxTotal =  $SummaryDocumentsLine->appendChild($TaxTotal);
            $cbc = $xml->createElement('cbc:TaxAmount','0.00'); 
            $cbc = $TaxTotal->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");

            $cac = $xml->createElement('cac:TaxSubtotal'); 
            $cac = $TaxTotal->appendChild($cac);
            $cbc = $xml->createElement('cbc:TaxAmount','0.00'); 
            $cbc = $cac->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");

            $TaxCategory = $xml->createElement('cac:TaxCategory'); 
            $TaxCategory = $cac->appendChild($TaxCategory);

            $TaxScheme = $xml->createElement('cac:TaxScheme');
            $TaxScheme = $TaxCategory->appendChild($TaxScheme);

            $cbc = $xml->createElement('cbc:ID','2000'); 
            $cbc = $TaxScheme->appendChild($cbc);

            $cbc = $xml->createElement('cbc:Name','ISC'); 
            $cbc = $TaxScheme->appendChild($cbc);
            $cbc = $xml->createElement('cbc:TaxTypeCode','EXC');
            $cbc = $TaxScheme->appendChild($cbc);
            
          // Total IGV
            $TaxTotal = $xml->createElement('cac:TaxTotal'); 
            $TaxTotal =  $SummaryDocumentsLine->appendChild($TaxTotal);
 
            $cbc = $xml->createElement('cbc:TaxAmount', 'igv'); 
            $cbc = $TaxTotal->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");

            $cac = $xml->createElement('cac:TaxSubtotal'); 
            $cac = $TaxTotal->appendChild($cac);

            $cbc = $xml->createElement('cbc:TaxAmount', 'igv'); 
            $cbc = $cac->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");

            $TaxCategory = $xml->createElement('cac:TaxCategory');
            $TaxCategory = $cac->appendChild($TaxCategory);

            $TaxScheme = $xml->createElement('cac:TaxScheme'); 
            $TaxScheme = $TaxCategory->appendChild($TaxScheme);

            $cbc = $xml->createElement('cbc:ID','1000');
            $cbc = $TaxScheme->appendChild($cbc);

            $cbc = $xml->createElement('cbc:Name','IGV'); 
            $cbc = $TaxScheme->appendChild($cbc);

            $cbc = $xml->createElement('cbc:TaxTypeCode','VAT');
            $cbc = $TaxScheme->appendChild($cbc);

            // Total Otros tributos
            $TaxTotal = $xml->createElement('cac:TaxTotal');
            $TaxTotal =  $SummaryDocumentsLine->appendChild($TaxTotal);

            $cbc = $xml->createElement('cbc:TaxAmount','0.00'); 
            $cbc = $TaxTotal->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");

            $cac = $xml->createElement('cac:TaxSubtotal'); 
            $cac = $TaxTotal->appendChild($cac);

            $cbc = $xml->createElement('cbc:TaxAmount','0.00');
            $cbc = $cac->appendChild($cbc); $cbc->setAttribute('currencyID',"PEN");

            $TaxCategory = $xml->createElement('cac:TaxCategory');
            $TaxCategory = $cac->appendChild($TaxCategory);

            $TaxScheme = $xml->createElement('cac:TaxScheme'); 
            $TaxScheme = $TaxCategory->appendChild($TaxScheme);

            $cbc = $xml->createElement('cbc:ID','9999'); 
            $cbc = $TaxScheme->appendChild($cbc);

            $cbc = $xml->createElement('cbc:Name','OTROS'); 
            $cbc = $TaxScheme->appendChild($cbc);

            $cbc = $xml->createElement('cbc:TaxTypeCode','OTH'); 
            $cbc = $TaxScheme->appendChild($cbc);

        /* }

    $xml->formatOutput = true;
    $strings_xml = $xml->saveXML();
    $xml->save('20532710066-RC-'.date('Ymd').'-'.'1'.'.xml');
*/?>