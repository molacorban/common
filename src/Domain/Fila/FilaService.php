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
    private $exchange;

    /**
     * @return FilaServiceInterface
     */
    public function getAdapter(): FilaServiceInterface
    {
        return $this->adapter;
    }

    /**
     * @param FilaServiceInterface $adapter
     * @return FilaService
     */
    public function setAdapter(FilaServiceInterface $adapter): FilaService
    {
        $this->adapter = $adapter;
        return $this;
    }

    public function __construct(FilaServiceInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function consumir(string $fila): void
    {
        $this->adapter->consumir($fila);
    }

    public function enviarMensagem(string $fila, string $mensagem, string $exchange = ''): void
    {
        $this->adapter->enviarMensagem($fila, $mensagem, $exchange);
    }

    public function desligar(): void
    {
        $this->adapter->desligar();
    }
}