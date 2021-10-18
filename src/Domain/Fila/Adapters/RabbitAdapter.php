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

    public function __construct()
    {
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
        $this->canal->queue_declare($fila, false, true, false, false);

        $callback = function($msg) {
            echo " Mensagem Recebida [x] ", $msg->body, "\n";
        };

        $this->canal->basic_consume(
            $fila,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while(count($this->canal->callbacks)) {
            $this->canal->wait();
        }
    }

    public function enviarMensagem(string $fila, string $mensagem, string $exchange = ''): void
    {
        $this->canal->queue_declare(
            $fila,
            false,
            true,
            false,
            false
        );

        $mensagemAEnviar = new AMQPMessage($mensagem, [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $this->canal->queue_bind($fila, $exchange);

        $this->canal->basic_publish($mensagemAEnviar, $exchange);
        $this->desligar();
    }

    public function desligar(): void
    {
        $this->canal->close();
        $this->conexao->close();
    }
}