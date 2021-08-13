<?php

namespace Mola\Common\Domain\Fila\Adapters;

use Mola\Common\Domain\Fila\FilaService;

/**
 * Class FilaServiceFactory
 * @package Mola\Common\Domain\Fila\Adapters
 * @author Diego Ananias <diego.ananias@molacorban.com.br>
 * @copyright Mola Corban
 */
class FilaServiceFactory
{
    const NAMESPACE_ADAPTER = 'Mola\\Common\\Domain\\Fila\\Adapters';

    public function __invoke()
    {
        $adapter = env('FILA_ADAPTER', 'rabbit');
        $adapter = app(self::NAMESPACE_ADAPTER . ucfirst($adapter)."Adapter");

        return new FilaService($adapter);
    }
}