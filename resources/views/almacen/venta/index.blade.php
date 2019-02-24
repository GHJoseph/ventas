@extends('layouts.admin') @section('contenido')
<div class="panel">

  <div class="panel-heading">
    <table class="" border="0" white="100%">
      <tr style="width:100%;">
        <td style="width:30%;">
          <h2 class="panel-title"><span class="glyphicon glyphicon-list"></span> Venta Resumen - Facturación Electrónica</h2>
        </td>
        <td style="width:10%;" align="right">
          <h2 class="panel-title"><span class="fa fa-filter"></span> Filtro :</h2>
        </td>
        <td style="width:25%">
          <input type="text" class="filter" id="kwd_search" placeholder="Filtro general de datos" /> </td>
        <td style="width:10%">
          <h2 class="panel-title"><span class="fa fa-calendar"></span> Periodo:</h2>
        </td>
        <td align="center" style="width:20%">
          <select name="dia" id="dia" class="ano">
                  <?php $dia = date("d");
                   echo '<option selected value="'. $dia .'">'. $dia .'</option>';
        for ($i=1; $i<=30; $i++){
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
  ?>
                </select>
          <style>
            .ano {
              color: blue;
              border-radius: 10px;
              width: 60px;
            }

            .mes {
              color: blue;
              border-radius: 10px;
              width: 80px;
            }

            .filter {
              color: black;
              width: 200px;
              border-radius: 10px;
              padding-left: 10px;
              padding-right: 10px;
            }

          </style>
          <select id="mes" class="mes" name="mes">
                  <?php 
                  
            function nombremes($mes){
                    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'Junio', 'Julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                    return $mes[date('m')-1];
                    }
                 echo $mes=nombremes(date("m"));
                  $meses = date("m");
       
            echo '<option selected value="'. $meses .'">'. $mes .'</option>';
         ?>
                </select>
          <select name="ano" id="ano" class="ano" leng></select>
          <script>
            function ComboAno() {
              var n = (new Date()).getFullYear()
              var select = document.getElementById("ano");
              for (var i = n; i >= 2010; i--) select.options.add(new Option(i, i));
            };
            window.onload = ComboAno;

          </script>
          <script>
            var mes = {
              '01': 'Enero',
              '02': 'Febrero',
              '03': 'Marzo',
              '04': 'Abril',
              '05': 'Mayo',
              '06': 'Junio',
              '07': 'Julio',
              '08': 'Agosto',
              '09': 'Setiembre',
              '10': 'Octubre',
              '11': 'Noviembre',
              '12': 'Diciembre'
            };
            var select = document.getElementById("mes");
            for (index in mes) {
              select.options[select.options.length] = new Option(mes[index], index);
            }

          </script>
        </td>
      </tr>
    </table>
  </div>

  <div class="table-responsive">
    <script>


    </script>
    <style>
      .points_table {
        border: 34px;
        border-bottom-color: blue;
      }

      .points_table thead {
        width: 100%;
      }

      .points_table tbody {
        height: 400px;
        overflow-y: 26px;
        width: 100%;
      }

      .points_table thead tr {
        width: 99%;
      }

      .points_table tr {
        width: 100%;
      }

      .points_table thead,
      .points_table tbody,
      .points_table tr,
      .points_table td,
      .points_table th {
        display: inline-block;
      }

      .points_table thead {
        background: #d9edf7;
        color: #000;
      }

      .points_table tbody td,
      .points_table thead>tr>th {
        float: left;
        border-bottom-width: 0;
      }

      .points_table>tbody>tr>td,
      .points_table>tbody>tr>th,
      .points_table>tfoot>tr>td,
      .points_table>tfoot>tr>th,
      .points_table>thead>tr>td,
      .points_table>thead>tr>th {
        padding: 3px;
        height: 50px;
        text-align: center;
        line-height: 20px;
      }

      .odd {
        background: #ffffff;
        color: #000;
      }

      .even {
        background: #efefef;
        color: #000;
      }

      .points_table_scrollbar {
        height: 2px;
        overflow-y: scroll;
      }

      .points_table_scrollbar::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.9);
        border-radius: 10px;
        background-color: #444444;
      }

      .points_table_scrollbar::-webkit-scrollbar {
        width: 1.1%;
        min-width: 10px;
        background-color: #F5F5F5;
      }

      .points_table_scrollbar::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background-color: #D62929;
        background-image: -webkit-linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.4) 50%, transparent, transparent)
      }

    </style>
    <script>
      $(document).ready(function() {
        $("#ano").change(function() {
          var url = "VentaResumenFiltro.php";
          var Vntano = $(this).val();
          var Ano = "Ano";
          $.ajax({
            type: "POST",
            url: url,
            data: {
              "Vntano": Vntano,
              "Ano": Ano
            },
            success: function(data) {
              $('#CargarTabla').html(data);
            }
          });
          $('.points_table').remove();
          //$('.tablaedi').attr("disabled", true);
        });
      });

    </script>
    <script>
      $(document).ready(function() {
        $("#mes").change(function() {
          var url = "VentaResumenFiltro.php";
          var Vntmes = $(this).val();
          var Vntano = $("#ano").val();
          var Mes = "Mes";
          $.ajax({
            type: "POST",
            url: url,
            data: {
              "Vntmes": Vntmes,
              "Vntano": Vntano,
              "Mes": Mes
            },
            success: function(data) {
              $('#CargarTabla').html(data);
            }
          });
          $('.points_table').remove();
          //$('.tablaedi').attr("disabled", true);
        });
      });

    </script>
    <script>
      $(document).ready(function() {
        $("#dia").change(function() {
          var url = "VentaResumenFiltro.php";
          var Vntdia = $(this).val();
          var Vntmes = $("#mes").val();
          var Vntano = $("#ano").val();
          var Dia = "Dia";
          $.ajax({
            type: "POST",
            url: url,
            data: {
              "Vntdia": Vntdia,
              "Vntmes": Vntmes,
              "Vntano": Vntano,
              "Dia": Dia
            },
            success: function(data) {
              $('#CargarTabla').html(data);
            }
          });
          $('.points_table').remove();
          //$('.tablaedi').attr("disabled", true);
        });
      });

    </script>
    <table class="points_table table table-bordered table-hover" id="my-table">
      <thead>
        <tr class="info">
          <th style="width:8%;">N° Venta</th>
          <th style="width:7%;"> Fecha
            <br> de Venta</th>
          <th style="width:4%;">Doc </th>
          <th style="width:6%;">Serie</th>
          <th style="width:6%;">Numero</th>
          <th style="width:8%;">Fecha
            <br> de Docum</th>
          <th style="width:13%;">Cliente</th>
          <th style="width:6%;">Total
            <br> S/</th>
          <th style="width:6%;">Total
            <br> $US</th>
          <th style="width:6%;">Moneda</th>
          <th style="width:5%;">PDF</th>
          <th style="width:5%;">CDR</th>
          <th style="width:8%;">ESTADO
            <br> SUNAT</th>
          <th style="width:6%;">
            <a href="www.facebook.com?1" class="btn btn-primary " data-toggle="tooltip" data-placement="top" title="Generar Nueva Venta"> <span class="glyphicon glyphicon-plus"></span></a>
          </th>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
          <th style="width:6%;">
            <button type="button" class="sunatb btn-primary" data-toggle="modal" data-target="#modal1" data-toggle="tooltip" data-placement="top" title="Envio Sunat"><img class="sunat" src="{{asset('Imagenes/sunatlogo.png')}}" alt=""> </button>
            <!--<a href="#" id="sunat" class="sunatb btn-primary"> <img class="sunat" src="Imagenes/sunatlogo.png" alt=""></a>--></th>
          <script>
            $(document).on('ready', function() {
              $('.sunat').click(function() {
                var url = "ProcesoSunatConsulta.php";
                $.ajax({
                  type: "POST",
                  url: url,
                  data: $("#f").serialize(),
                  success: function(data) {
                    $('#cargartablaPR').html(data);
                  }
                });
              });
            });

          </script>
          <style>
            .sunatb {
              display: inline-block;
              padding: 2px 6px;
              margin-bottom: 0;
              font-size: 14px;
              font-weight: 400;
              line-height: 1.42857143;
              text-align: center;
              white-space: nowrap;
              vertical-align: middle;
              -ms-touch-action: manipulation;
              touch-action: manipulation;
              cursor: pointer;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
              background-image: none;
              border: 1px solid transparent;
              border-radius: 4px;
            }

            .sunat {
              width: 30px;
              heigth: 40px;
            }

          </style>
        </tr>
      </thead>
      <div id="CargarTabla"></div>
      <tbody class="points_table_scrollbar">
       @foreach($ventas as $venta)
       <tr>
        
       
       </tr>
        
       @endforeach
      </tbody>

    </table>
    <script>
      $(document).ready(function() {
        // Write on keyup event of keyword input element
        $("#kwd_search").keyup(function() {
          // When value of the input is not blank
          if ($(this).val() != "") {
            // Show only matching TR, hide rest of them
            $("#my-table tbody>tr").hide();
            $("#my-table td:contains-ci('" + $(this).val() + "')").parent("tr").show();
          } else {
            // When there is no input or clean again, show everything back
            $("#my-table tbody>tr").show();
          }
        });
      });
      // jQuery expression for case-insensitive filter
      $.extend($.expr[":"], {li, match, array) {
          return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
      });

    </script>
    <br>
    <style>
      .TablaTotales {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0px;
        padding: 8px;
      }

      @import url("http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css");
      .panel-pricing {
        -moz-transition: all .3s ease;
        -o-transition: all .3s ease;
        -webkit-transition: all .3s ease;
      }

      .panel-pricing:hover {
        box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2);
      }

      .panel-pricing .panel-heading {
        padding: 20px 10px;
      }

      .panel-pricing .panel-heading .fa {
        margin-top: 10px;
        font-size: 30px;
      }

      .panel-pricing .list-group-item {
        color: #565656;
        border-bottom: 1px solid rgba(250, 250, 250, 0.5);
      }

      .panel-pricing .list-group-item:last-child {
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
      }

      .panel-pricing .list-group-item:first-child {
        border-top-right-radius: 0px;
        border-top-left-radius: 0px;
      }

      .panel-pricing .panel-body {
        background-color: #f0f0f0;
        font-size: 16px;
        color: #565656;
        padding: 3px;
        margin: 0px;
      }

    </style>

    <!--================================================-->
  </div>


</div>
</div>


@endsection
