<?php
     header('Content-Type: text/html; charset=UTF-8');
  include('../conexion.php');
  $cSerDoc=$_GET['cCodDoc'];
  $cNumDoc=$_GET['cNumDoc'];


  $sql="Select	V.Num_Vnt,V.Fec_Vnt,V.Cod_Doc,V.Tip_Doc,
			V.Ser_Doc,V.Num_Doc,V.Fec_Doc,
			V.Ser_Guia,V.Num_Guia,V.Fec_Guia,
			V.Val_Vta_MN,V.Igv_Vta_MN,V.Tot_Vta_MN,
			V.Val_Vta_ME,V.Igv_Vta_ME,V.Tot_Vta_ME,
			V.Cod_Imp,V.Tas_Imp,V.Cod_Mon,V.Tip_Cam,V.Fec_Cam,
			V.Cod_CP,V.Tip_CP,V.Cod_Doc_CP,V.Tip_Doc_CP,V.Num_Doc_CP,
			V.Obs_Vnt,V.Tot_Vta_Letra,V.Cod_Lib,
			V.Estado,V.Imprimir,V.File_Zip,
			V.Cod_Hash,V.Cod_Error,V.Ticket,
			V.Usuario,V.Fecha,V.Operacion,
		
			DV.Item_Vnt, DV.Cod_Rub, DV.Cod_Art, DV.Nom_Art, DV.Can_Art,
			DV.Pre_Art_MN, DV.Val_Art_MN, DV.Igv_Art_MN, DV.Pre_Vnt_MN, DV.Vta_Art_MN,
			DV.Pre_Art_ME, DV.Val_Art_ME, DV.Igv_Art_ME, DV.Pre_Vnt_ME, DV.Vta_Art_ME,
	
			 CONCAT(RTRIM(IFNULL(C.Ape_CP,'')) , ' ' , RTRIM(IFNULL(C.Nom_CP,''))) AS Nom_CP,
			C.Cod_Doc AS Cod_Doc_CP,C.Tip_Doc AS Tip_Doc_CP,C.Num_Doc AS Num_Doc_CP,
			C.Dir_CP,C.Tel_CP, C.Fax_CP, C.Cel_CP,C.Persona,DS.Cod_Dis,DS.Nom_Dis,
			PR.Cod_Pro,PR.Nom_Pro,DP.Cod_Dep,DP.Nom_Dep,PA.Cod_Pais,PA.Nom_Pais,
			MO.Nom_Mon,MO.Tip_Mon, MO.Cod_Alf,
			 CONCAT(RTrim(P.Pat_Per) ,' ',rtrim(P.Mat_Per),' ',rtrim(P.Nom_Per)) As Vendedor,
			T.Nom_Tip_Est,E.Nom_Error,
	
			EM.Nom_Emp,EM.RUC_EMP,EM.Cta_Detraccion,EM.DIR_EMP,
			EM.Cod_Dis AS COD_DIS_EMP, DE.Nom_Dis AS NOM_DIS_EMP,
			EM.Cod_Pro AS COD_PRO_EMP, PE.Nom_Pro AS NOM_PRO_EMP,
			EM.Cod_Dep AS COD_DEP_EMP, DPE.Nom_Dep AS NOM_DEP_EMP,
			EM.Cod_Pais AS COD_PAIS_EMP, PAE.Nom_Pais AS NOM_PAIS_EMP
	From	ventas_resumen AS V
	LEFT OUTER JOIN ventas_detalle AS DV ON	DV.Cod_Emp =V.Cod_Emp AND DV.Cod_Loc =V.Cod_Loc 
										AND	DV.Anno =V.Anno AND DV.Num_Vnt =V.Num_Vnt
										AND	DV.Cod_Doc =V.Cod_Doc AND DV.Operacion <>'E'
	LEFT OUTER JOIN personal_maestro P ON	P.Cod_EMP=V.Cod_EMP AND P.Cod_Per=V.Cod_Per 
										And RTRIM(P.Cod_Per)<>'000000' And P.Operacion<>'E'
	LEFT OUTER JOIN ventas_tipos_estados T ON T.COD_TIP_EST=V.ESTADO
	LEFT OUTER JOIN sunat_envios_errores E ON E.COD_ERROR=V.COD_ERROR
	LEFT OUTER JOIN monedas_maestro MO ON MO.Cod_Mon=V.Cod_Mon AND MO.Cod_Mon <>'0'	
	LEFT OUTER JOIN empresas_maestro EM ON	EM.Cod_EMP=V.Cod_EMP AND EM.Cod_EMP <>'00' AND EM.ESTADO=1 
	LEFT OUTER JOIN ubigeo_distritos DE ON	DE.Cod_Dis=EM.Cod_Dis And DE.Cod_Pro=EM.Cod_Pro
									AND DE.Cod_Dep=EM.Cod_Dep And DE.Cod_Pais=EM.Cod_Pais
	LEFT OUTER JOIN ubigeo_provincias PE ON PE.Cod_Pro=EM.Cod_Pro And PE.Cod_Dep=EM.Cod_Dep 
										And PE.Cod_Pais=EM.Cod_Pais
	LEFT OUTER JOIN ubigeo_departamentos DPE ON DPE.Cod_Dep=EM.Cod_Dep And DPE.Cod_Pais=EM.Cod_Pais
	LEFT OUTER JOIN ubigeo_paises PAE ON PAE.Cod_Pais=EM.Cod_Pais AND PAE.Cod_Pais <>'00'
	LEFT OUTER JOIN clienprov_maestro C ON	C.Cod_EMP=V.Cod_EMP AND C.Cod_CP=V.Cod_CP And C.Tip_CP=V.Tip_CP	
	LEFT OUTER JOIN ubigeo_distritos DS ON	DS.Cod_Dis=C.Cod_Dis And DS.Cod_Pro=C.Cod_Pro
									AND DS.Cod_Dep=C.Cod_Dep And DS.Cod_Pais=C.Cod_Pais
	LEFT OUTER JOIN ubigeo_provincias PR ON PR.Cod_Pro=C.Cod_Pro And PR.Cod_Dep=C.Cod_Dep 
									And PR.Cod_Pais=C.Cod_Pais
	LEFT OUTER JOIN ubigeo_departamentos DP ON DP.Cod_Dep=C.Cod_Dep And DP.Cod_Pais=C.Cod_Pais
	LEFT OUTER JOIN ubigeo_paises PA ON PA.Cod_Pais=C.Cod_Pais AND PA.Cod_Pais <>'00'	
		
	Where	V.Cod_Emp='01' And V.Cod_Loc='01'
		AND RTRIM(V.Ser_Doc)=RTRIM('$cSerDoc') And RTRIM(V.Num_Doc)=RTRIM('$cNumDoc')
		And V.Estado='P' And V.Operacion<>'E'
	ORDER BY V.Cod_Doc,V.Ser_Doc,V.Num_Doc,V.Fec_Doc;";
  $List_Result=mysqli_query($conexion,$sql);

  if (mysqli_num_rows($List_Result) > 0) {
  
    $p=0; $i=0;
    while($row = mysqli_fetch_array($List_Result)) {
      
   
     $p+=1;
     
     // echo "XML creado corectamente ";
     $cNumVnt=$row["Num_Vnt"];
      $cCodDoc=$row["Cod_Doc"];
      $cTipDoc=$row["Tip_Doc"];
      $cSerDoc=$row["Ser_Doc"];
      $cNumDoc=$row["Num_Doc"];
      $cFecDoc=$row["Fec_Doc"];
      $cFecDoc=$row["Fec_Doc"];
      
      
      $cSerGuia=$row["Ser_Guia"];
      $cNumGuia=$row["Num_Guia"];
      
      
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
      
      
      $cIgvImp=$row["Tas_Imp"];
      $cTipMon=$row["Cod_Alf"];
      $cCodMon=$row["Cod_Mon"];
      $cNomMon=$row["Nom_Mon"];
      //$cCalculo=$row["Calculo"];
      
      if($cCodMon=="S"){
        
        $cValVnt=$row["Val_Vta_MN"];
        $cIgvVnt=$row["Igv_Vta_MN"];
        $cTotVnt=$row["Tot_Vta_MN"];
      }else{
        $cValVnt=$row["Val_Vta_ME"];
        $cIgvVnt=$row["Igv_Vta_ME"];
        $cTotVnt=$row["Tot_Vta_ME"];
      }
      //---------------------------------------
      $cTotVtaLetra=$row["Tot_Vta_Letra"];
      
$xml = new DomDocument('1.0', 'ISO-8859-1');

$xml->standalone         = false;
$xml->preserveWhiteSpace = false;

$Invoice = $xml->createElement('Invoice');
$Invoice = $xml->appendChild($Invoice);
// Set the attributes.
$Invoice->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
$Invoice->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$Invoice->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$Invoice->setAttribute('xmlns:ccts', "urn:un:unece:uncefact:documentation:2");
$Invoice->setAttribute('xmlns:ds', "http://www.w3.org/2000/09/xmldsig#");
$Invoice->setAttribute('xmlns:ext', "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
$Invoice->setAttribute('xmlns:qdt', "urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2");
$Invoice->setAttribute('xmlns:sac', "urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
//$Invoice->setAttribute('xmlns:schemaLocation', "urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 ../xsd/maindoc/UBLPE-Invoice-1.0.xsd");
$Invoice->setAttribute('xmlns:udt', "urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2");

$UBLExtension = $xml->createElement('ext:UBLExtensions');
$UBLExtension = $Invoice->appendChild($UBLExtension);

$ext = $xml->createElement('ext:UBLExtension');
$ext = $UBLExtension->appendChild($ext);

$contents = $xml->createElement('ext:ExtensionContent');
$contents = $ext->appendChild($contents);

$sac = $xml->createElement('sac:AdditionalInformation');
$sac = $contents->appendChild($sac);

$monetary = $xml->createElement('sac:AdditionalMonetaryTotal');
$monetary = $sac->appendChild($monetary);

$cbc = $xml->createElement('cbc:ID', '1001');
$cbc = $monetary->appendChild($cbc);

$cbc = $xml->createElement('cbc:PayableAmount', $cValVnt);
$cbc = $monetary->appendChild($cbc);
$cbc->setAttribute('currencyID', $cTipMon);


$aditional = $xml->createElement('sac:AdditionalProperty');
$aditional = $sac->appendChild($aditional);

$cbc = $xml->createElement('cbc:ID', '1000');
$cbc = $aditional->appendChild($cbc);

$cbc = $xml->createElement('cbc:Value', $cTotVtaLetra);
$cbc = $aditional->appendChild($cbc);

    // Podria no Pertenecer
$sunat = $xml->createElement('sac:SUNATTransaction');
$sunat = $sac->appendChild($sunat);
      
      

$cbc = $xml->createElement('cbc:ID', '1');
$cbc = $sunat->appendChild($cbc);

$ext = $xml->createElement('ext:UBLExtension');
$ext = $UBLExtension->appendChild($ext);

$contents = $xml->createElement('ext:ExtensionContent', ' ');
$contents = $ext->appendChild($contents);

$cbc = $xml->createElement('cbc:UBLVersionID', '2.0');
$cbc = $Invoice->appendChild($cbc);

$cbc = $xml->createElement('cbc:CustomizationID', '1.0');
$cbc = $Invoice->appendChild($cbc);

$cbc = $xml->createElement('cbc:ID', $cSerDoc."-".$cNumDoc);
$cbc = $Invoice->appendChild($cbc);

$cbc = $xml->createElement('cbc:IssueDate', $cFecDoc);
$cbc = $Invoice->appendChild($cbc);

$cbc = $xml->createElement('cbc:InvoiceTypeCode', '01');
$cbc = $Invoice->appendChild($cbc);

$cbc = $xml->createElement('cbc:DocumentCurrencyCode', $cTipMon);
$cbc = $Invoice->appendChild($cbc);

$cac_signature = $xml->createElement('cac:Signature');
$cac_signature = $Invoice->appendChild($cac_signature);

$cbc = $xml->createElement('cbc:ID', $cRucEmp);
$cbc = $cac_signature->appendChild($cbc);



$cac_signatory = $xml->createElement('cac:SignatoryParty');
$cac_signatory = $cac_signature->appendChild($cac_signatory);

$cac = $xml->createElement('cac:PartyIdentification');
$cac = $cac_signatory->appendChild($cac);

$cbc = $xml->createElement('cbc:ID', $cRucEmp);
$cbc = $cac->appendChild($cbc);

$cac = $xml->createElement('cac:PartyName');
$cac = $cac_signatory->appendChild($cac);

$cbc = $xml->createElement('cbc:Name', $cNomEmp);
$cbc = $cac->appendChild($cbc);



$cac_digital = $xml->createElement('cac:DigitalSignatureAttachment');
$cac_digital = $cac_signature->appendChild($cac_digital);

$cac = $xml->createElement('cac:ExternalReference');
$cac = $cac_digital->appendChild($cac);

$cbc = $xml->createElement('cbc:URI', $cRucEmp);
$cbc = $cac->appendChild($cbc);

$cac_accounting = $xml->createElement('cac:AccountingSupplierParty');
$cac_accounting = $Invoice->appendChild($cac_accounting);

$cbc = $xml->createElement('cbc:CustomerAssignedAccountID', $cRucEmp);
$cbc = $cac_accounting->appendChild($cbc);

$cbc = $xml->createElement('cbc:AdditionalAccountID', '6'); //Ruc //dni
$cbc = $cac_accounting->appendChild($cbc);

$cac_party = $xml->createElement('cac:Party');
$cac_party = $cac_accounting->appendChild($cac_party);

$cac = $xml->createElement('cac:PartyName');
$cac = $cac_party->appendChild($cac);

$cbc = $xml->createElement('cbc:Name', $cNomEmp);
$cbc = $cac->appendChild($cbc);
      
$address = $xml->createElement('cac:PostalAddress');
$address = $cac_party->appendChild($address);
      
$cbc = $xml->createElement('cbc:ID', $cCodDepEmp.$cCodProEmp.$cCodDisEmp);
$cbc = $address->appendChild($cbc);

$cbc = $xml->createElement('cbc:StreetName', 'PJ. ADAN MEJÍA Nº 182');
$cbc = $address->appendChild($cbc);
      
$country = $xml->createElement('cac:Country');
$country = $address->appendChild($country);
      
$cbc = $xml->createElement('cbc:IdentificationCode', 'PE');
$cbc = $country->appendChild($cbc);
    
$legal = $xml->createElement('cac:PartyLegalEntity');
$legal = $cac_party->appendChild($legal);

$cbc = $xml->createElement('cbc:RegistrationName', $cNomEmp);
$cbc = $legal->appendChild($cbc);

$cac_accounting = $xml->createElement('cac:AccountingCustomerParty');
$cac_accounting = $Invoice->appendChild($cac_accounting);

$cbc = $xml->createElement('cbc:CustomerAssignedAccountID', $cNumDocCP);
$cbc = $cac_accounting->appendChild($cbc);

$cbc = $xml->createElement('cbc:AdditionalAccountID', '1');
$cbc = $cac_accounting->appendChild($cbc);

$cac_party = $xml->createElement('cac:Party');
$cac_party = $cac_accounting->appendChild($cac_party);

$legal = $xml->createElement('cac:PartyLegalEntity');
$legal = $cac_party->appendChild($legal);

$cbc = $xml->createElement('cbc:RegistrationName', strtoupper($cNomCP));
$cbc = $legal->appendChild($cbc);


$taxtotal = $xml->createElement('cac:TaxTotal');
$taxtotal = $Invoice->appendChild($taxtotal);

$cbc = $xml->createElement('cbc:TaxAmount', $cIgvVnt);
$cbc = $taxtotal->appendChild($cbc);
$cbc->setAttribute('currencyID', $cTipMon);

$taxtsubtotal = $xml->createElement('cac:TaxSubtotal');
$taxtsubtotal = $taxtotal->appendChild($taxtsubtotal);

$cbc = $xml->createElement('cbc:TaxAmount', $cIgvVnt);
$cbc = $taxtsubtotal->appendChild($cbc);
$cbc->setAttribute('currencyID', $cTipMon);

$taxtcategory = $xml->createElement('cac:TaxCategory');
$taxtcategory = $taxtsubtotal->appendChild($taxtcategory);

$taxscheme = $xml->createElement('cac:TaxScheme');
$taxscheme = $taxtcategory->appendChild($taxscheme);

$cbc = $xml->createElement('cbc:ID', '1000');
$cbc = $taxscheme->appendChild($cbc);

$cbc = $xml->createElement('cbc:Name', 'IGV');
$cbc = $taxscheme->appendChild($cbc);

$cbc = $xml->createElement('cbc:TaxTypeCode', 'VAT');
$cbc = $taxscheme->appendChild($cbc);

$legal = $xml->createElement('cac:LegalMonetaryTotal');
$legal = $Invoice->appendChild($legal);

$cbc = $xml->createElement('cbc:PayableAmount', $cTotVnt);
$cbc = $legal->appendChild($cbc);
$cbc->setAttribute('currencyID', $cTipMon);
    
      
      
      
        $i +=1;
      $cCodArt=$row["Cod_Art"];
      $cNomArt=$row["Nom_Art"];
      $cCanArt=$row["Can_Art"];
      
     $cCodMon=$row["Cod_Mon"];
    
         if($cCodMon=="S"){
        
        $cPreArt=$row["Pre_Art_MN"];
        $cValArt=$row["Val_Art_MN"];
        $cIgvArt=$row["Igv_Art_MN"];
        $cPreVnt=$row["Pre_Vnt_MN"];
        $cVtaArt=$row["Vta_Art_MN"];
      }else{
        $cPreArt=$row["Pre_Art_ME"];
        $cValArt=$row["Val_Art_ME"];
        $cIgvArt=$row["Igv_Art_ME"];
        $cPreVnt=$row["Pre_Vnt_ME"];
        $cVtaArt=$row["Vta_Art_ME"];
      }
     
      
  // detalle de la factura
  $InvoiceLine = $xml->createElement('cac:InvoiceLine'); 
  $InvoiceLine = $Invoice->appendChild($InvoiceLine);
  // id del item
  $cbc = $xml->createElement('cbc:ID', $i);
  $cbc = $InvoiceLine->appendChild($cbc);
   // cantidad
  $cbc = $xml->createElement('cbc:InvoicedQuantity',  $cCanArt); 
  $cbc = $InvoiceLine->appendChild($cbc);
  $cbc->setAttribute('unitCode', "ZZ");
  // valor venta con descuento
   $cbc = $xml->createElement('cbc:LineExtensionAmount',$cValArt); 
  $cbc = $InvoiceLine->appendChild($cbc); 
  $cbc->setAttribute('currencyID', "$cTipMon");
  // precio unitario del producto con igv
  $pricing = $xml->createElement('cac:PricingReference'); 
  $pricing = $InvoiceLine->appendChild($pricing);
   $cac = $xml->createElement('cac:AlternativeConditionPrice'); 
  $cac = $pricing->appendChild($cac);
  // precio unitario con igv
  $cbc = $xml->createElement('cbc:PriceAmount',$cPreVnt); 
  $cbc = $cac->appendChild($cbc);
  $cbc->setAttribute('currencyID', "$cTipMon");
   // 01 con igv, 02 operaciones no onerosas
  $cbc = $xml->createElement('cbc:PriceTypeCode', '01'); 
  $cbc = $cac->appendChild($cbc);
  $allowance = $xml->createElement('cac:AllowanceCharge'); 
  $allowance = $InvoiceLine->appendChild($allowance);
                    // false para descuento
  $cbc = $xml->createElement('cbc:ChargeIndicator', 'true'); 
  $cbc = $allowance->appendChild($cbc);
  // descuento
  $cbc = $xml->createElement('cbc:Amount', "0.0"); 
  $cbc = $allowance->appendChild($cbc);
  $cbc->setAttribute('currencyID', $cTipMon);

 // igv del total del producto aplicado ya el descuento *0.18
  $taxtotal = $xml->createElement('cac:TaxTotal');
  $taxtotal = $InvoiceLine->appendChild($taxtotal);
  $cbc = $xml->createElement('cbc:TaxAmount', $cIgvArt); 
  $cbc = $taxtotal->appendChild($cbc); 
  $cbc->setAttribute('currencyID', $cTipMon);
      
  $taxtsubtotal = $xml->createElement('cac:TaxSubtotal'); 
  $taxtsubtotal = $taxtotal->appendChild($taxtsubtotal);
  
   $cbc = $xml->createElement('cbc:TaxableAmount',$cValArt); 
  $cbc = $taxtsubtotal->appendChild($cbc); 
  $cbc->setAttribute('currencyID', $cTipMon);
     
  $cbc = $xml->createElement('cbc:TaxAmount',$cIgvArt); 
  $cbc = $taxtsubtotal->appendChild($cbc); 
  $cbc->setAttribute('currencyID', $cTipMon);
      
  $taxtcategory = $xml->createElement('cac:TaxCategory'); 
  $taxtcategory = $taxtsubtotal->appendChild($taxtcategory);
  $cbc = $xml->createElement('cbc:TaxExemptionReasonCode', '10');
  $cbc = $taxtcategory->appendChild($cbc);
      
  $taxscheme = $xml->createElement('cac:TaxScheme');
  $taxscheme = $taxtcategory->appendChild($taxscheme);

  $cbc = $xml->createElement('cbc:ID', '1000');
  $cbc = $taxscheme->appendChild($cbc);
      
  $cbc = $xml->createElement('cbc:Name', 'IGV'); 
  $cbc = $taxscheme->appendChild($cbc);
                               
  $cbc = $xml->createElement('cbc:TaxTypeCode', 'VAT');
  $cbc = $taxscheme->appendChild($cbc);
      
   $item = $xml->createElement('cac:Item'); 
   $item = $InvoiceLine->appendChild($item);
      
   $cbc = $xml->createElement('cbc:Description', $cNomArt); 
   $cbc = $item->appendChild($cbc);
      
   $sellers = $xml->createElement('cac:SellersItemIdentification');
   $sellers = $item->appendChild($sellers);
      
   $cbc = $xml->createElement('cbc:ID', $cCodArt); 
   $cbc = $sellers->appendChild($cbc);
      
                // precio sin igv ejm 83.05
   $price = $xml->createElement('cac:Price');
   $price = $InvoiceLine->appendChild($price);
      
   $cbc = $xml->createElement('cbc:PriceAmount', $cPreArt); 
   $cbc = $price->appendChild($cbc); 
    $cbc->setAttribute('currencyID', $cTipMon);

  }
    $xml->formatOutput = true;
    $strings_xml       = $xml->saveXML();
   $xml->save('Documentos_Sin_Firma/'.$cRucEmp.'-'.$cCodDoc.'-'.$cSerDoc.'-'. $cNumDoc.'.xml');

    chmod('Documentos_Sin_Firma/'.$cRucEmp.'-'.$cCodDoc.'-'.$cSerDoc.'-'. $cNumDoc.'.xml', 0777);
 $Nombre= $cRucEmp.'-'.$cCodDoc.'-'.$cSerDoc.'-'. $cNumDoc;
    
   echo "   <td colspan='4'> <label >XML Generado</label><br> $Nombre </td> <br>";
    header("Location:03_firmarFactura.php?Nombre=$Nombre");
    
 echo "<div class='alert  alert-confirmar'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Accion Correcta!</strong> La Factura F001-00001 ha sido enviada correctamente</div>";

    
      
    
} else {
     echo "<div class='alert  alert-confirmar'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Accion Correcta!</strong> No existen documentos pendientes por enviar</div>";
}

  mysqli_close($conexion);
?>