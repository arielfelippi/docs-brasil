<?php

declare(strict_types=1);

namespace DocsBrasil\Domain\Documents\Cnpj;

use DocsBrasil\Traits\MaskTraits;
use DocsBrasil\Domain\Masks\Masks;

class Cnpj
{
    use MaskTraits;

    private static $cnpj = '';

    /**
     * __construct
     *
     * @param  string $cnpj
     * @return void
     */
    public function __construct(string $cnpj = '')
    {
        self::setCnpj($cnpj);
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString(): string
    {
        return self::$cnpj;
    }

    /**
     * init
     *
     * @param  string $cnpj
     * @return Cnpj
     */
    public static function init(string $cnpj = ''): Cnpj
    {
        return new self($cnpj);
    }

    /**
     * addMask
     *
     * @return string $cnpj
     */
    public static function addMask(): string
    {
        $cnpjString = self::$cnpj;

        if (empty($cnpjString)) {
            $cnpjString = self::removeMask(self::$cnpj);
        }

        return self::addMaskToValue($cnpjString, Masks::CNPJ);
    }

    /**
     * validate
     *
     * @return bool
     */
    public static function validate(): bool
    {
        return self::validateInternal(self::$cnpj);
    }

    /**
     * setCnpj
     *
     * @param  string $cnpj
     * @return void
     */
    private static function setCnpj(string $cnpj): void
    {
        self::$cnpj = self::removeMask($cnpj);
    }

    /**
     * removeMask
     *
     * @param  string $cnpj
     * @return string
     */
    private static function removeMask(string $cnpj): string
    {
        $cnpj = trim(preg_replace('/[^0-9]/', '', $cnpj));

        return str_pad($cnpj, 14, '0', STR_PAD_LEFT);
    }

    /**
     * validateInternal
     *
     * @param  string $cnpj
     * @return bool
     */
    private static function validateInternal(string $cnpj): bool
    {
        // Verifica o tamanho ou se todos os dígitos são iguais
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

    /**
     * fakeCnpj
     *
     * @param  bool $withMask
     * @return string
     */
    public static function fakeCnpj(bool $withMask = false): string
    {
        $cnpj = '';

        for ($i = 0; $i < 8; $i++) {
            $cnpj .= random_int(0, 9);
        }

        $cnpj .= '0001'; // Fixa a base do CNPJ

        // Calcula os dígitos verificadores
        $cnpj .= self::calculateDigit(substr($cnpj, 0, 12));
        $cnpj .= self::calculateDigit(substr($cnpj, 0, 13));

        self::setCnpj($cnpj);

        return $withMask ? self::addMask() : $cnpj;
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

        $weights = self::getWeightsForBaseLength(strlen($base));

        foreach (str_split($base) as $i => $digit) {
            $sum += $digit * $weights[$i];
        }

        $remainder = $sum % 11;

        return $remainder < 2 ? 0 : 11 - $remainder;
    }

    /**
     * getWeightsForBaseLength
     *
     * @param  int $base
     * @return array
     */
    private static function getWeightsForBaseLength(int $base): array {
        $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        if ($base === 12) {
            $weights =  [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        }

        return $weights;
    }
}
