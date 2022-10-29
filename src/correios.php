<?php

namespace Lazarini\CorreiosFrete;

class CORREIOS
{
    const SEDEX = '04014';
    const PAC   = '04510';
    const SEDEX_10 = '04510';

    const CAIXA = 1;
    const ROLO = 2;
    const ENVELOPE = 3;

    protected $payload = [];

    protected $items = [];

    public function credenciais($code, $password)
    {
        $this->payload['nCdEmpresa'] = $code;
        $this->payload['sDsSenha'] = $password;

        return $this;
    }

    public function service($service)
    {
        $this->payload['nCdServico'] = $service;
        return $this;
    }

    public function origem($cep)
    {
        $this->payload['sCepOrigem'] = preg_replace('/[^0-9]/', null, $cep);
        return $this;
    }

    public function destino($cep)
    {
        $this->payload['sCepDestino'] = preg_replace('/[^0-9]/', null, $cep);
        return $this;
    }

    public function formato($formato)
    {
        $this->payload['nCdFormato'] = $formato;
        return $this;
    }

    public function item($largura, $altura, $comprimento, $peso, $quantidade)
    {

        $pesoTotal = $quantidade * $peso;

        $cmCubicoTotal = $largura * $altura* $comprimento * $quantidade;

        $raiz_cubica = round(pow($cmCubicoTotal, 1/3), 2);
        
        $largura = $raiz_cubica < 11 ? 11 : $raiz_cubica;
        $altura = $raiz_cubica < 2 ? 2 : $raiz_cubica;
        $comprimento =  $raiz_cubica < 16 ? 16 : $raiz_cubica;
        $pesoFinal = $pesoTotal < 0.3 ? 0.3 : $pesoTotal;

        $this->payload['nVlLargura'] = $largura;
        $this->payload['nVlAltura'] = $altura;
        $this->payload['nVlComprimento'] = $comprimento;
        $this->payload['nVlPeso'] = $pesoFinal;
        $this->payload['nVlDiametro'] = 0;
        return $this;
    }

    public function maoPropria($maoPropria)
    {
        $this->payload['sCdMaoPropria'] = (bool) $maoPropria ? 'S' : 'N';
        return $this;
    }

    public function valorDeclarado($value)
    {
        $this->payload['nVlValorDeclarado'] = floatval($value);
        return $this;
    }

    public function avisoRecebimento($value)
    {
        $this->payload['sCdAvisoRecebimento'] = (bool) $value ? 'S' : 'N';
        return $this;
    }

    public function calc()
    {
        $this->payload['StrRetorno'] = 'xml';
        $xml_string = file_get_contents('http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?' . http_build_query($this->payload));
        $xml = simplexml_load_string($xml_string);
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }
}