<?php

namespace Mola\Common\Domain\Fila\Adapters;

use Mola\Common\Domain\Fila\FilaServiceInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class ServiceBusAdapter
 * @package Mola\Common\Domain\Fila\Adapters
 * @author Diego Ananias <diego.ananias@molacorban.com.br>
 * @copyright Mola Corban
 */
final class RabbitAdapter implements FilaServiceInterface
{
    private AMQPStreamConnection $conexao;
    private $canal;
    private $exchange;

    /**
     * @return mixed
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * @param mixed $exchange
     * @return RabbitAdapter
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;
        return $this;
    }

    public function __construct($exchange)
    {
        $this->setExchange($exchange);
        $this->conexao = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD')
        );

        $this->canal = $this->conexao->channel();
    }
    
    public function consumir(string $fila): void
    {
        $this->conexao->queue_declare($fila, false, false, false, false);

        $callback = function($msg) {
            echo " Mensagem Recebida [x] ", $msg->body, "\n";
        };

        $this->canal->basic_consume($fila, '', false, true, false, false, $callback);

        while(count($this->canal->callbacks)) {
            $this->canal->wait();
        }
    }

    public function enviarMensagem(string $fila, string $mensagem): void
    {
        $this->canal->queue_declare(
            $fila,
            false
            ,true,
            false,
            false
        );
        $this->canal->exchange_declare(
            $this->getExchange(),
            'direct',
            false,
            true,
            false
        );
        $this->canal->queue_bind($fila, $this->getExchange());
        $mensagemAEnviar = new AMQPMessage($mensagem, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $this->canal->basic_publish($mensagemAEnviar, $this->getExchange());
        $this->desligar();
    }

    public function desligar(): void
    {
        $this->canal->close();
        $this->conexao->close();
    }
}