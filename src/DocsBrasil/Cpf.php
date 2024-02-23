<?php

declare(strict_types=1);

namespace DocsBrasil;

use DocsBrasil\Masks\Masks;
use DocsBrasil\Traits\MaskTraits;

class Cpf
{
    use MaskTraits;

    private static $cpf = '';

    public function __construct(string $cpf = '')
    {
        self::setCpf($cpf);
    }

    public function __toString(): string
    {
        return self::$cpf;
    }

    public static function init(string $cpf = ''): Cpf
    {
        return new self($cpf);
    }

    public static function addMask(): string
    {
        $cpfString = self::$cpf;

        if (empty($cpfString)) {
            $cpfString = self::removeMask(self::$cpf);
        }

        return self::addMaskToValue($cpfString, Masks::CPF);
    }

    public static function validate(): bool
    {
        return self::validateInternal(self::$cpf);
    }

    private static function setCpf(string $cpf): void
    {
        self::$cpf = self::removeMask($cpf);
    }

    private static function removeMask(string $cpf): string
    {
        $cpf = trim(preg_replace('/[^0-9]/is', '', $cpf));

        return str_pad($cpf, 11, '0', STR_PAD_LEFT);
    }

    private static function validateInternal(string $cpf): bool
    {
        // Verifica o tamanho ou se todos os digitos são iguais
        $isInvalidCpf = (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf));

        if ($isInvalidCpf) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
