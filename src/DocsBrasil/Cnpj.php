<?php

declare(strict_types=1);

namespace DocsBrasil;

use DocsBrasil\Masks\Masks;
use DocsBrasil\Traits\MaskTraits;

class Cnpj
{
    use MaskTraits;
    private static $cnpj = '';

    public function __construct(string $cnpj = '')
    {
        self::setCnpj($cnpj);
    }

    public function __toString(): string
    {
        return self::$cnpj;
    }

    public static function init(string $cnpj = ''): Cnpj
    {
        return new self($cnpj);
    }

    public static function addMask(): string
    {
        $cnpjString = self::$cnpj;

        if (empty($cnpjString)) {
            $cnpjString = self::removeMask(self::$cnpj);
        }

        return self::addMaskToValue($cnpjString, Masks::CNPJ);
    }

    public static function validate(): bool
    {
        return self::validateInternal(self::$cnpj);
    }

    private static function setCnpj(string $cnpj): void
    {
        self::$cnpj = self::removeMask($cnpj);
    }

    private static function removeMask(string $cnpj): string
    {
        $cnpj = trim(preg_replace('/[^0-9]/is', '', $cnpj));

        return str_pad($cnpj, 14, '0', STR_PAD_LEFT);
    }

    private static function validateInternal(string $cnpj): bool
    {
        // Verifica o tamanho ou se todos os digitos são iguais
        $isInvalidCnpj = (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj));

        if ($isInvalidCnpj) {
            return false;
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += (int) $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += (int) $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
}
