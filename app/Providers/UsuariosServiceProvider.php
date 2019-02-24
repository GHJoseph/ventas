<?php

namespace SisVentas\Providers;

use Illuminate\Support\ServiceProvider;

class UsuariosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path().'/helpers/userdat.php';
    }
}
