<?php

declare(strict_types=1);

namespace DocsBrasil;

class Cnpj
{
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

    public static function removeMask(string $cnpj): string
    {
        $cnpj = trim(preg_replace('/[^0-9]/is', '', $cnpj));

        return str_pad($cnpj, 14, '0', STR_PAD_LEFT);
    }

    public static function addMask(): string
    {
        $cnpjString = self::$cnpj;

        if (empty($cnpjString)) {
            $cnpjString = self::removeMask(self::$cnpj);
        }

        $bloco_1 = substr($cnpjString, 0, 2);
        $bloco_2 = substr($cnpjString, 2, 3);
        $bloco_3 = substr($cnpjString, 5, 3);
        $bloco_4 = substr($cnpjString, 8, 4);
        $blocoVerificador = substr($cnpjString, -2);

        return "{$bloco_1}.{$bloco_2}.{$bloco_3}/{$bloco_4}-{$blocoVerificador}";
    }

    public static function validate(): bool
    {
        return self::validateInternal(self::$cnpj);
    }

    private static function setCnpj(string $cnpj): void
    {
        self::$cnpj = self::removeMask($cnpj);
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
