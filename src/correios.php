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

    public function item($largura, $altura, $comprimento, $peso, $quantidade = 1)
    {
        $this->items[] = compact('largura', 'altura', 'comprimento', 'peso', 'quantidade');
        $this->payload['nVlLargura'] = $this->items[0]['largura'];
        $this->payload['nVlAltura'] = $this->items[0]['altura'];
        $this->payload['nVlComprimento'] = $this->items[0]['comprimento'];
        $this->payload['nVlPeso'] = $this->items[0]['peso'];
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
