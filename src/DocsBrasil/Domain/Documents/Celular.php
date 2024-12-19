<?php

declare(strict_types=1);

namespace DocsBrasil\Domain\Documents;

class Celular
{
    private const PREFIXO_BRASIL = 55;

    private string $numero = '';

    public function __construct(string $numero)
    {
        $this->numero = $this->removeMask($numero);
        $this->buildCellphone();
    }

    private function removeMask(string $numero)
    {
        $numero = trim(preg_replace('/\D/', '', $numero));

        if (empty($numero)) {
            $numero = str_pad($numero, 9, '0', STR_PAD_LEFT);
        }

        return $numero;
    }

    private function getSizeNumber()
    {
        return strlen($this->numero);
    }

    /**
     * function validateDDD
     *
     * Valida os prefixos(DDD).
     *
     * @return boolean
     */
    public function validateDDD(): bool
    {
        $validPrefixes = [
            11, 12, 13, 14, 15, 16, 17, 18, 19,
            21, 22, 24, 27, 28,
            31, 32, 33, 34, 35, 37, 38,
            41, 42, 43, 44, 45, 46, 47, 48, 49,
            51, 53, 54, 55,
            61, 62, 63, 64, 65, 66, 67, 68, 69,
            71, 73, 74, 75, 77, 79,
            81, 82, 83, 84, 85, 86, 87, 88, 89,
            91, 92, 93, 94, 95, 96, 97, 98, 99,
        ];

        $prefix = substr($this->numero, 0, 2);

        $isValid = in_array($prefix, $validPrefixes);

        return $isValid;
    }

    /**
     * function validateCellphone
     *
     * Valida numero de celular, inibe números repetidos Ex.: 11111111111.
     *
     * @return boolean
     */
    public function validateCellphone(): bool
    {
        $cellphone = substr($this->numero, -9);

        if (preg_match('/^(\d)\1{8}$/', $cellphone)) {
            return false;
        }

        return true;
    }

    /**
     * function nineDigitCellphone
     * Ajusta o numero do telefone para 9 dígitos.
     * Entrada: 96912345|5496912345|555496912345.
     * Saída: 996912345|54996912345|5554996912345
     *
     * @return void
     */
    private function addNineDigitCellphone()
    {
        if ($this->getSizeNumber() < 9) {
            $cellphone = "9{$this->numero}";

            $this->numero = $cellphone;
        }
    }

    private function formatCell()
    {
        $sizeCellphone = $this->getSizeNumber();

        if ($sizeCellphone < 8) {
            $cellphone = str_pad($this->numero, 8, '0', STR_PAD_LEFT);

            $this->numero = $cellphone;
        }

        if ($sizeCellphone > 13) {
            $this->formatCellPrefixPais();
            $cellphone = substr($this->numero, 0, 13);

            $this->numero = $cellphone;
        }

        $this->addNineDigitCellphone();
    }

    private function formatCellPrefix()
    {
        $prefix_ddd = substr($this->numero, 0, 2);
        $cellphone = substr($this->numero, 2);
        $this->numero = $cellphone;
        $this->formatCell();
        $this->numero = "{$prefix_ddd}{$this->numero}";
    }

    private function formatCellPrefixPais()
    {
        $prefix_pais = substr($this->numero, 0, 2);
        $cellphone_prefix_ddd = substr($this->numero, 2);
        $this->numero = $cellphone_prefix_ddd;
        $this->formatCellPrefix();
        $this->numero = "{$prefix_pais}{$this->numero}";
    }

    private function buildCellphone()
    {
        $sizeCellphone = $this->getSizeNumber();
        $formatCorrect = [9, 11, 13];

        if (in_array($sizeCellphone, $formatCorrect)) {
            return $this->numero;
        }

        if ($sizeCellphone === 8) {
            return $this->formatCell();
        }

        if ($sizeCellphone === 10) {
            return $this->formatCellPrefix();
        }

        if ($sizeCellphone === 12) {
            return $this->formatCellPrefixPais();
        }

        return $this->formatCell();
    }

    public function addPrefixDDD(string $prefixDDD = '')
    {
        $this->numero = trim($prefixDDD . $this->numero);
    }

    public function addPrefixPais(string $prefixPais = self::PREFIXO_BRASIL)
    {
        $this->numero = trim($prefixPais . $this->numero);
    }

    public function __toString()
    {
        return  $this->numero;
    }
}
