<?php

require '../../vendor/autoload.php';

use Lazarini\CorreiosFrete\CORREIOS;

$instance = new CORREIOS();

$x = $instance
    ->service(CORREIOS::PAC)
    ->origem('04474340')
    ->destino('01001000')
    ->formato(CORREIOS::CAIXA)
    ->maoPropria(false)
    ->item('30', '30', '30', '0.5')
    ->valorDeclarado(0)
    ->avisoRecebimento(false)
    ->calc();

print_r($x);