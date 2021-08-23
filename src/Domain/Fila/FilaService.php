<?php

namespace Mola\Common\Domain\Fila;

/**
 * Class FilaService
 * @package Mola\Common\Domain\Fila
 * @author Diego Ananias <diego.ananias@molacorban.com.br>
 * @copyright Mola Corban
 */
class FilaService implements FilaServiceInterface
{
    private FilaServiceInterface $adapter;

    public function __construct(FilaServiceInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function consumir(string $fila): void
    {
        $this->adapter->consumir($fila);
    }

    public function enviarMensagem(string $fila, string $mensagem): void
    {
        $this->adapter->enviarMensagem($fila, $mensagem);
    }

    public function desligar(): void
    {
        $this->adapter->desligar();
    }
}