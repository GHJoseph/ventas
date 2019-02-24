<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('main');
});*/

// ------------------  Login  ----------------------------------
Route::get('login/index', 'LoginController@index')->name('index');
Route::post('validador', 'LoginController@login')->name('validador');
Route::get('/cambio', 'TipoCambioController@obtenerTC')->name('obtenerTC');
Route::post('/locales', array('as' => 'locales', 'uses' => 'UbigeoController@locales'));
Route::group(['middleware' => ['logged']], function () {
//Test
    Route::resource('almacen/test', 'TestController');
    Route::post('almacen/test', 'TestController@ajaxRequestPost');

//Home
    Route::resource('almacen/home', 'HomeController');
    Route::resource('almacen/pdf', 'PdfController');
//Listar 
//Articulo
    Route::resource('almacen/articulo', 'ArticuloController');
    Route::resource('almacen/articulo/pdf', 'ArticuloController@index');
//Servicio
    Route::resource('almacen/servicio', 'ServicioController');
//Paciente
    Route::resource('almacen/paciente', 'PacienteController');
//Proveedor
    Route::resource('almacen/proveedor', 'ProveedorController');
//Cliente
    Route::resource('almacen/cliente', 'ClientesController');
//Personal
    Route::resource('almacen/personal', 'PersonalController');
//Categoria
    Route::resource('almacen/categoria', 'CategoriaController');
//Agenda
    Route::resource('almacen/agenda', 'AgendaController');
//Citas
    Route::resource('almacen/citas', 'CitasController');

//Agenda
    Route::get('almacen/agenda/crearAgenda/{codEmp}/{codLoc}/{usuario}/{fecha}', 'AgendaController@crearAgenda');
    Route::post('almacen/agenda/crearAgenda', 'AgendaController@postCrearAgenda');
    Route::post('almacen/agenda', 'AgendaController@postCrearCita');
//Route::post('almacen/agenda', 'AgendaController@postEliminar');

//Facturacion
    Route::resource('almacen/facturacion', 'FacturacionController');

    Route::post('almacen/facturacion', 'FacturacionController@MandadatosFactEletronica')->name('enviadatosfact');


//Editar
//Articulo
    Route::get('almacen/articulo/edit/{codEmp}/{codALM}/{codArt}/{nomArt}/{pmin}/{pventa}', 'ArticuloController@edit');
    Route::post('/almacen/articulo/edit', 'ArticuloController@postEdit');

//Servicio
    Route::get('almacen/servicio/edit/{codEmp}/{codServ}/{nomServ}', 'ServicioController@edit');
    Route::post('/almacen/servicio/edit', 'ServicioController@postEdit');

//Paciente
    Route::get('almacen/paciente/edit/{codEmp}/{codLoc}/{codPac}/{NomPac}', 'PacienteController@edit');
    Route::post('/almacen/paciente/edit', 'PacienteController@postEdit');

//Proveedor
    Route::get('almacen/proveedor/edit/{codEmp}/{CodCP}/{TipCP}/{NomCP}', 'ProveedorController@edit');
    Route::post('/almacen/proveedor/edit', 'ProveedorController@postEdit');
//Cliente
    Route::get('almacen/cliente/edit/{codEmp}/{CodCP}/{TipCP}/{NomCP}', 'ClientesController@edit');
    Route::post('/almacen/cliente/edit', 'ClientesController@postEdit');
//Personal
    Route::get('almacen/personal/edit/{codEmp}/{CodPer}/{NomPer}', 'PersonalController@edit');
    Route::post('/almacen/personal/edit', 'PersonalController@postEdit');

//Facturacion
    Route::get('almacen/personal/edit', 'PersonalController@edit');

//Registrar
//Articulo
    Route::get('almacen/articulo/create', 'ArticuloController@create');
    Route::post('almacen/articulo/create', 'ArticuloController@postCreate');

//Servicio
    Route::get('almacen/servicio/create', 'ServicioController@create');
    Route::post('almacen/servicio/create', 'ServicioController@postCreate');

//Paciente
    Route::get('almacen/paciente/create', 'PacienteController@create');
    Route::post('almacen/paciente/create', 'PacienteController@postCreate');
    Route::get('BuscaClientes', 'ClienteController@FiltraClientes')->name('BuscaClientes');
    Route::get('BuscaPacientes', 'ClienteController@FiltraPacientes')->name('BuscaPacientes');


//Proveedor
    Route::get('almacen/proveedor/create', 'ProveedorController@create');
    Route::post('almacen/proveedor/create', 'ProveedorController@postCreate');

//Cliente
    Route::get('almacen/cliente/create', 'ClientesController@create');
    Route::post('almacen/cliente/create', 'ClientesController@postCreate');

//Personal
    Route::get('almacen/personal/create', 'PersonalController@create');
    Route::post('almacen/personal/create', 'PersonalController@postCreate');

//Facturacion
    Route::get('almacen/facturacion/create', 'FacturacionController@create');
    Route::post('GrabaTemporal', 'FacturacionController@postCreate')->name('GrabaTemporal');
    Route::post('almacen/facturacion/eliminar', 'FacturacionController@DeletedetalleTemp')->name('EliminarDetalleTemporal');

    Route::post('updatemodaldetalletemp', 'FacturacionController@edit')->name('updatemodaldetalletemp');

    Route::get('tipodecambio', 'TipodecambioController@tipodecambio')->name('tipodecambio');

    Route::post('MandaDatoDetalleEdit', 'FacturacionController@MandaDatoDetalle_Edit')->name('MandaDatoDetalleEdit');


//Home
    Route::get('almacen/home/agendaIntervalo/{intervalo}', 'HomeController@agendaIntervalo');
    Route::post('almacen/home', 'HomeController@postIndex');

//Eliminar 
//Articulo
//Route::get('/almacen/articulo/eliminar/{CodEmp}/{CodArt}/{Usuario}/{Fecha}/{Operacion}', 'ArticuloController@eliminar');
    Route::get('/almacen/articulo/eliminar/{CodArt}', 'ArticuloController@eliminar');
//Servicio
    Route::get('/almacen/servicio/eliminar/{CodEmp}/{CodServ}/{Usuario}/{Fecha}/{Operacion}', 'ServicioController@eliminar');
//Paciente
    Route::get('/almacen/paciente/eliminar/{CodEmp}/{CodPac}/{UsuarioMod}/{FechaMod}/{Operacion}', 'PacienteController@eliminar');
//Proveedor
    Route::get('/almacen/proveedor/eliminar/{CodEmp}/{CodProv}/{Usuario}/{Fecha}/{Operacion}', 'ProveedorController@eliminar');
//Personal
    Route::get('/almacen/personal/eliminar/{CodEmp}/{CodPer}/{Usuario}/{Fecha}/{Operacion}', 'PersonalController@eliminar');
//Proveedor
    Route::get('/almacen/cliente/eliminar/{CodEmp}/{CodProv}/{Usuario}/{Fecha}/{Operacion}', 'ClientesController@eliminar');
    Route::get('almacen/EnvioSunat/enviar_sunat','EnvioSunatController@enviar_sunat')->name('enviar_sunat');
Route::get('almacen/EnvioSunat/crear_xml','EnvioSunatController@crear_xml')->name('crear_xml');
Route::resource('almacen/EnvioSunat','EnvioSunatController');



// Ruta para Productos
    Route::get('Buscaproductos', 'ProductoController@BuscaProducto')->name('Buscaproductos');

// Ruta para MandaDatosdeCliente en select
    Route::post('MandaDatosClientes', 'ClienteController@show')->name('MandaDatosClientes');
// Ruta para MandaDatosdeProducto en select
    Route::post('MandaDatosProducto', 'ProductoController@enviadatoproduct')->name('MandaDatosProducto');

// Ruta para MandaDatosdeProducto en select
    Route::post('MandaDatosTipoFactura', 'FacturacionController@MandaDatosTipoFactura')->name('MandaDatosTipoFactura');

// Ruta para mandar simbolo segun el tipo seleccionado
    Route::post('DevuelvesimboloDinero', 'FacturacionController@DevuelvesimboloDinero')->name('DevuelvesimboloDinero');

// Ruta para cargar los datos del temporal de detalle
    Route::post('Devuelvesdatosdetalletemp', 'FacturacionController@cargadatosgrilla')->name('Devuelvesdatosdetalletemp');

    Route::post('CalculaTotal', 'FacturacionController@CalculaTotal')->name('CalculaTotal');
// Me guarda los detalles y la cabecera
    Route::post('almacen/facturacion/create', 'FacturacionController@cargar')->name('Submitbutton');


// Graba los campos a ventas_detalle_tmp
    Route::post('GrabaDetallesVentaTemp', 'FacturacionController@GrabaDetallesVentaTemp')->name('GrabaDetallesVentaTemp');

// Ruta para cargar de NumeroaLetras
    Route::post('devuelveNumeroaLetras', 'FacturacionController@devuelveNumeroaLetras')->name('devuelveNumeroaLetras');

    Route::post('BuscaClientexDocumento', 'FacturacionController@BuscaClientexDocumento')->name('BuscaClientexDocumento');

    Route::get('Reportes/reporteventa/{NumVnt?}', 'FacturacionController@pdfventa')->name('ventapdf');
    Route::get('Reportes/reportenota/{NumNota?}', 'NotasController@pdfnota')->name('pdfnota');

    Route::get('facturacion/edit/{Num_Vnt?}', 'FacturacionController@editventa')->name('editaventa');
    Route::get('facturacion/cancelar', 'FacturacionController@cancelarVenta')->name('cancelarVenta');

    Route::post('savedit', 'FacturacionController@MandaDatoDetalle_SaveEdit')->name('savedit');

    Route::post('savetempaDetalle', 'FacturacionController@GrabaTempaDetalle')->name('savetempaDetalle');

    Route::get('formNotaVenta', 'NotasController@formNotaVenta')->name('formNotaVenta');

    Route::post('MuestraMontos', 'NotasController@MuestraMontos')->name('MuestraMontos');


// ------------------   Notas de  Credito ----------------------------------
    Route::get('notas/index', 'NotasController@create')->name('notas/index');
    Route::get('notas/edit/{Num_Vnt?}', 'NotasController@edit')->name('editanota');
//Reportes
    Route::resource('reportes', 'ReporteController');
//Roles
    Route::resource('roles', 'RolesController');
    Route::resource('tipos', 'TipoCambioController');
    Route::get('tipos/edit/{NumDia}/{NumMes}/{Anno}', 'TipoCambioController@edit')->name('editTipoCambio');

    Route::post('retornadatoscombos', 'NotasController@retornadatoscombos')->name('retornadatoscombos');

    Route::post('grabanotadeventas', 'NotasController@store')->name('grabanotadeventas');
    Route::post('updatenotadeventas', 'NotasController@update')->name('updatenotadeventas');
    Route::post('ListResumenNota', 'NotasController@ListResumenNota')->name('ListResumenNota');

    Route::get('BuscaPersonal', 'PersonalController@FiltraPersonal')->name('BuscaPersonal');

// ----------------------------  Usuarios ------------------------------------------------

    Route::resource('usuarios', 'UsuarioController');


    Route::get('/Firmar', function () {
        return view('almacen.EnvioSunat.03_firmarFactura');
    });


    Route::get('/Enviar', function () {
        return view('almacen.EnvioSunat.04_enviarFactura');
    });
//
    Route::post('/departamento', array('as' => 'departamento', 'uses' => 'UbigeoController@departamento'));
    Route::post('/provincia', array('as' => 'provincia', 'uses' => 'UbigeoController@provincia'));
    Route::post('/provincia/buscar', array('as' => 'provincia.buscar', 'uses' => 'UbigeoController@provinciaBuscar'));
    Route::post('/distrito', array('as' => 'distrito', 'uses' => 'UbigeoController@distrito'));
    Route::post('/distrito/buscar', array('as' => 'distrito.buscar', 'uses' => 'UbigeoController@distritoBuscar'));


    Route::post('/ventasresumen', array('as' => 'ventas.resumen', 'uses' => 'FacturacionController@ventasResumen'));

    Route::get('ventas/excel/{desde}/{hasta}', 'ReporteController@ventasExcel')->name('ventas.excel');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::post('detalleVenta', 'FacturacionController@detalleVenta')->name('detalleVenta');
    Route::get('notas/reporte/{NumVta}', 'NotasController@reporte')->name('notas.reporte');
    Route::get('venta/reporte/{NumVta}', 'FacturacionController@reporte')->name('ventas.reporte');
    Route::get('venta/reporte/imprimir/{NumVta}', 'FacturacionController@reporte_imprimir')->name('ventas.reporte.imprimir');
    Route::get('venta/reporte/impresora/{NumVta}', 'FacturacionController@reporte_impresora')->name('ventas.reporte.impresora');
    //Enviar Correo
    Route::get('enviar/{NumVta}','EnviarCorreo@enviar')->name('enviarCorreo');

});





