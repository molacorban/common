<?php

namespace Mola\Common\Providers;

use Illuminate\Support\ServiceProvider;
use Mola\Common\Domain\Armazenamento\ArmazenamentoService;
use Mola\Common\Domain\Armazenamento\ArmazenamentoServiceInterface;
use Mola\Common\Domain\Criptografia\CriptografiaService;
use Mola\Common\Domain\Criptografia\CriptografiaServiceInterface;
use Mola\Common\Domain\Fila\Adapters\FilaServiceFactory;
use Mola\Common\Domain\Fila\FilaService;
use Mola\Common\Domain\Fila\FilaServiceInterface;
use Mola\Common\Domain\HttpClient\HttpClientService;
use Mola\Common\Domain\HttpClient\HttpClientServiceInterface;
use Mola\Common\Domain\Log\LogService;
use Mola\Common\Domain\Log\LogServiceInterface;

/**
 * Class CommonServiceProvider
 * @package Mola\Common\Providers
 * @author Diego Ananias <diego.ananias@molacorban.com.br>
 * @copyright Mola Corban
 */
class CommonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/package.php' => config_path('package.php')
        ], 'mola-rabbit ');
    }

    public function register()
    {
        $this->app->bind(ArmazenamentoServiceInterface::class, ArmazenamentoService::class);
        $this->app->bind(CriptografiaServiceInterface::class, CriptografiaService::class);
        $this->app->bind(FilaServiceInterface::class, FilaServiceFactory::class);
        $this->app->bind(HttpClientServiceInterface::class, HttpClientService::class);
        $this->app->bind(LogServiceInterface::class, LogService::class);
    }
}