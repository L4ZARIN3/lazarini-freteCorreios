# PHP CORREIOS WEB SERVICE

SIMPLES INTEGRAÇÃO COM WEBSERVICE DOS CORREIOS

## INSTALAÇÃO

```shell
composer require lazarini/frete
```


## UTILIZAÇÃO

PARA USAR ESTE PACOTE BASTA SERGUIR O EXEMPLO A BAIXO

```php

<?php

require __DIR__.'vendor/autoload';
use Lazarini\CorreiosFrete\CORREIOS;

$instance = new CORREIOS();

$frete = $instance
    ->credenciais('teste', 'teste') // OPCIONAL
    ->service([CORREIOS::SEDEX]) // OBRIGATORIO PASSE UM OBJETO USE: CORREIOS::SEDEX, CORREIOS::PAC, CORREIOS::SEDEX_10
    ->origem('04474340') // OBRIGATORIO
    ->destino('06803440') // OBRIGATORIO
    ->formato(CORREIOS::CAIXA) // OBRIGATORIO USE: CORREIOS::CAIXA, CORREIOS::ROLO, CORREIOS::ENVELOPE
    ->maoPropria(false) // OBRIGATORIO
    ->item('30', '30', '30', '0.05', 2) // OBRIGATORIO USE: LARGURA, ALTURA, COMPRIMENTO, PESO, QUANTIDADE
    ->valorDeclarado(0) // OBRIGATORIO caso não tenha setar 0
    ->avisoRecebimento(false) // OBRIGATORIO passar true ou false
    ->calc();

print_r($frete);
```

## CONSULTANDO MULTIPLOS SERVIÇOS

PARA CONSULTA MULTIPLOS SERVIÇOS FAÇA DA SEGUINTE FORMA

```php
<?php

require __DIR__.'vendor/autoload';
use Lazarini\CorreiosFrete\CORREIOS;

$instance = new CORREIOS();
$frete = $instance
    ->service([CORREIOS::SEDEX, CORREIOS::PAC, CORREIOS::SEDEX_HOJE])
    ->origem('04474340')
    ->destino('01001000')
    ->formato(CORREIOS::CAIXA)
    ->maoPropria(false)
    ->item('30', '30', '30', '1.00', 2)
    ->valorDeclarado(0)
    ->avisoRecebimento(false)
    ->calc();

print_r($frete);
```
