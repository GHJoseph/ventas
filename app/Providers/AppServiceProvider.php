<?php

namespace SisVentas\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $usuario_opciones = DB::table('usuarios_opciones')
                ->join('sistemas_menus', 'usuarios_opciones.Cod_Men', '=', 'sistemas_menus.Cod_Men')
                ->where('usuarios_opciones.Cod_Emp', '=', session('key')['CodEmp'])
                ->where('usuarios_opciones.Cod_Usu', '=', session('key')['CodUsu'])
                ->orderBy('usuarios_opciones.Cod_Men')
                ->get();
            $TipoCambioActual = DB::table('monedas_tipos_cambios')
                ->orderBy('Fecha', '=', 'DESC')
                ->first();

            $view->with(['usuario_opciones' => $usuario_opciones, 'tipoCambio' => $TipoCambioActual]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . './../helpers/Helpers.php';


    }
}
