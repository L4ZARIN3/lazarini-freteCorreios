# PHP CORREIOS WEB SERVICE

SIMPLES INTEGRAÇÃO COM WEBSERVICE DOS CORREIOS

## UTILIZAÇÃO

PARA USAR ESTE PACOTE BASTA SERGUIR O EXEMPLO A BAIXO

```php

<?php

require __DIR__.'vendor/autoload';
use Lazarini\CorreiosFrete\CORREIOS;

$instance = new CORREIOS();

$frete = $instance
    ->service(CORREIOS::PAC) // OBRIGATORIO USE: CORREIOS::SEDEX, CORREIOS::PAC, CORREIOS::SEDEX_10
    ->origem('04474340') // OBRIGATORIO
    ->destino('01001000') // OBRIGATORIO
    ->formato(CORREIOS::CAIXA) // OBRIGATORIO USE: CORREIOS::CAIXA, CORREIOS::ROLO, CORREIOS::ENVELOPE
    ->maoPropria(false) // OBRIGATORIO
    ->item('30', '30', '30', '0.5') // OBRIGATORIO USE: LARGURA, ALTURA, COMPRIMENTO, PESO
    ->valorDeclarado(0) // OBRIGATORIO caso não tenha setar 0
    ->avisoRecebimento(false) // OBRIGATORIO passar true ou false
    ->calc();

print_r($frete);
```
