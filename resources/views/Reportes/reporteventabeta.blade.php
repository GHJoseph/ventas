 
  $selectVD="SELECT * FROM ventas_detalle where Num_Vnt='$NumVnt'";
$resultVD = mysqli_query($conexion, $selectVD);
  $selectV="SELECT * FROM ventas_resumen where Num_Vnt='$NumVnt'";
$resultV = mysqli_query($conexion, $selectV);

 $selectR="SELECT * FROM ventas_resumen where Num_Vnt='$NumVnt'";
$resultR = mysqli_query($conexion, $selectR);



 <section class="invoice">
    <style>
      .logo {
        width: 15%;
      }
    </style>
    <div class="row">
      <div class="col-sm-12">
        <h1 class="page-header">
           <!-- <i class="fa fa-globe"></i> AdminLTE, Inc.-->
            <img class="logo" src="images/logo-quirovida.jpg" alt="">
            <small class="pull-right">Fecha:  <?php echo $FechHoy= date("Y-m-d");?></small>
          </h1> </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col"> De<address>
            <strong>Quirovida,  Rehabilitación Integral S.A.C.</strong><br>
           Calle. Las Águilas 263 <br>
            Lima - Perú<br>
            Cel: (804) 123-5432<br>
            Email: info@almasaeedstudio.com
          </address> </div>
      <!-- /.col -->
      <div class="col-sm-5 invoice-col"> A <address>
            <strong>Señor(es): JOMAN S.A.C</strong><br>
            R.U.C. : 20538533239<br>
            Av Los Salmos- LIMA - LIMA<br>
            Cel: (555) 539-1037<br>
        
          </address> </div>
      <!-- /.col -->
      <div class="col-sm-3 invoice-col">
        <table class="table" border="1">
          <?php while ($user=$resultR->fetch_assoc()) { 
              if($user['Ser_Doc']=="F001"){
                 $nombre="FACTURA";
              }else{
                $nombre="BOLETA";
              }
          
          ?>
            <tr>
              <td align="center"><b> R.U.C.: 20504068146 <br>  <?php  echo $nombre; ?> DE VENTA
            <br> ELECTRÓNICA</b>
                <br>
                <?php  echo $user['Ser_Doc']; ?> N°
                  <?php  echo $user['Num_Doc']; ?>
              </td>
            </tr>
            <?php }?>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr style="border-top: 1px solid #000">
              <th>Cantidad</th>
              <th>Codigo</th>
              <th>Descripción</th>
              <th>Unidad</th>
              <th>Valor Unitario</th>
              <th>Valor Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
           while ($user=$resultVD->fetch_assoc()) { ?>
              <tr>
                <td>
                  <?php  echo $user['Can_Art']; ?>
                </td>
                <td>
                  <?php  echo $user['Cod_Art']; ?>
                </td>
                <td>
                  <?php  echo $user['Nom_Art']; ?>
                </td>
                <td>
                  <?php  echo $user['Pre_Art_MN']; ?>
                </td>
                <td>
                  <?php  echo $user['Vta_Art_MN']; ?>
                </td>
              </tr>
              <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <br>
    <!-- /.row -->
    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-7">
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> Representación Impresa de la FACTURA DE VENTA ELECTRÓNICA, consultar documentos visitando la gágina www.facttron.com/20123964579 Autorizado mediante Resolución de Superintendencia N°155-2017/Sunat. </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-1"></div>
      <div class="col-xs-4">
        <!--<p class="lead">Totales</p>-->
        <div class="table-responsive">
          <table class="table ">
            <?php
               while ($use=$resultV->fetch_assoc()) { 
           ?>
              <tr>
                <th style="width:50%">Valor Venta :</th>
                <td>S/</td>
                <td align="right">
                  <?php echo $use['Val_Vta_MN']; ?>
                </td>
              </tr>
              <tr>
                <th>Igv (18%):</th>
                <td>S/</td>
                <td align="right">
                  <?php  echo $use['Igv_Vta_MN']; ?>
                </td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>S/</td>
                <td align="right">
                  <?php  echo $use['Tot_Vta_MN']; ?>
                </td>
              </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- this row will not appear when printing -->
    <div class="row no-print">
      <div class="col-xs-12"><a href="Inicio.php?VentaResumen" class="btn btn-default"><i class="fa fa-mail-reply"></i> Salir</a> <a href="Reportes1/Ticket.php?NumVnt=<?php echo $use['Num_Vnt']; ?>" class="btn btn-success  pull-right"><i class="fa fa-print"></i> Imprimir</a>
        <label for="" class="pull-right">&#124; </label> <a href="Reportes1/ReportArt.php?NumVnt=<?php echo $use['Num_Vnt']; ?>" class="btn btn-primary pull-right"><i class="fa fa-download"></i> Descargar PDF</a> </div>
    </div>
    <?php } ?>
  </section>
  <!-- /.content -->
  <div class="clearfix"></div>