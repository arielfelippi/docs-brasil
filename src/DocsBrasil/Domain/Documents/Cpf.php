<?php

declare(strict_types=1);

namespace DocsBrasil\Domain\Documents;

use DocsBrasil\Traits\MaskTraits;
use DocsBrasil\Domain\Masks\Masks;

class Cpf
{
    use MaskTraits;

    private static $cpf = '';

    /**
     * __construct
     *
     * @param  string $cpf
     * @return void
     */
    public function __construct(string $cpf = '')
    {
        self::setCpf($cpf);
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString(): string
    {
        return self::$cpf;
    }

    /**
     * init
     *
     * @param  string $cpf
     * @return Cpf
     */
    public static function init(string $cpf = ''): Cpf
    {
        return new self($cpf);
    }

    /**
     * addMask
     *
     * @return string $cpf
     */
    public static function addMask(): string
    {
        $cpfString = self::$cpf;

        if (empty($cpfString)) {
            $cpfString = self::removeMask(self::$cpf);
        }

        return self::addMaskToValue($cpfString, Masks::CPF);
    }

    /**
     * validate
     *
     * @return bool
     */
    public static function validate(): bool
    {
        return self::validateInternal(self::$cpf);
    }

    /**
     * setCpf
     *
     * @param  string $cpf
     * @return void
     */
    private static function setCpf(string $cpf): void
    {
        self::$cpf = self::removeMask($cpf);
    }

    /**
     * removeMask
     *
     * @param  string $cpf
     * @return string
     */
    private static function removeMask(string $cpf): string
    {
        $cpf = trim(preg_replace('/[^0-9]/', '', $cpf));

        return str_pad($cpf, 11, '0', STR_PAD_LEFT);
    }

    /**
     * validateInternal
     *
     * @param  string $cpf
     * @return bool
     */
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

    /**
     * fakeCpf
     *
     * @param  bool $withMask
     * @return string
     */
    public static function fakeCpf(bool $withMask = false): string
    {
        $cpf = '';

        for ($i = 0; $i < 9; $i++) {
            $cpf .= random_int(0, 9);
        }

        // Calcula os dígitos verificadores
        $cpf .= self::calculateDigit(substr($cpf, 0, 9));
        $cpf .= self::calculateDigit(substr($cpf, 0, 10));

        self::setCpf($cpf);

        return $withMask ? self::addMask() : $cpf;
    }

    /**
     * calculateDigit
     *
     * @param  string $base
     * @return int
     */
    private static function calculateDigit(string $base): int
    {
        $sum = 0;
        $length = strlen($base);

        for ($i = 0; $i < $length; $i++) {
            $sum += $base[$i] * (($length + 1) - $i);
        }

        $remainder = $sum % 11;

        return $remainder < 2 ? 0 : 11 - $remainder;
    }
}
