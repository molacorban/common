<?php

namespace Mola\Common\Domain\Fila;

/**
 * Interface FilaServiceInterface
 * @package Mola\Common\Domain\Fila
 * @author Diego Ananias <diego.ananias@molacorban.com.br>
 * @copyright Mola Corban
 */
interface FilaServiceInterface
{
    public function consumir(string $fila);
    public function enviarMensagem(string $fila, string $mensagem);
    public function desligar();
}