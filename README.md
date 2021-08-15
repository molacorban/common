# Common

Esse é um pacote escrito para servir de de base comum a todas as aplicações do Mola Corban.

## Estrutura

```
src/
tests/
vendor/
```


## Instalação

Via Composer

``` bash
$ composer require mola/common
```
## Configuração

``` 
MENSAGERIA_HOST=host.amqp.rabbitmq.com.br (Mudar)
MENSAGERIA_PORT=5672 (Mudar)
MENSAGERIA_USUARIO=guest (Mudar)
MENSAGERIA_SENHA=guest (Mudar)
MENSAGERIA_VHOST=guest (Mudar)
```

## Testes

``` bash
$ composer test
```

## Segurança

Se você descobrir algum problema relacionado à segurança, envie um e-mail para diego.ananias@molacorban.com.br em vez de usar o rastreador de problemas.

## Creditos

- [Diego Ananias][link-author]

## Licença

Todos os direitos são reservados a Mola Corban - 2021

[link-author]: https://github.com/dhsaMolaCorban
