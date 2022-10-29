<?php

require '../../vendor/autoload.php';

use Lazarini\CorreiosFrete\CORREIOS;

$instance = new CORREIOS();

$frete = $instance
    ->service(CORREIOS::SEDEX)
    ->origem('04474340')
    ->destino('01001000')
    ->formato(CORREIOS::CAIXA)
    ->maoPropria(false)
    ->item('30', '30', '30', '1.00', 2)
    ->valorDeclarado(0)
    ->avisoRecebimento(false)
    ->calc();

print_r($frete);