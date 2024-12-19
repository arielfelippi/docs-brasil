<?php

namespace DocsBrasil\Domain\Documents;

use DocsBrasil\Domain\Documents\Cnpj\Cnpj;
use DocsBrasil\Domain\Documents\CnpjAlfa\CnpjAlfa;

class AnyCnpj
{
    /**
     * Detecta se o CNPJ é numérico ou alfanumérico.
     *
     * @param string $cnpj CNPJ para detectar.
     * @return string Retorna "numeric" para CNPJ numérico e "alphanumeric" para CNPJ alfanumérico.
     */
    public static function detectType(string $cnpj): string
    {
        $cnpj = preg_replace('/[^a-zA-Z0-9]/', '', $cnpj); // Remove máscara

        if (ctype_digit($cnpj) && strlen($cnpj) === 14) {
            return 'numeric';
        }

        if (preg_match('/^\d{8}[A-Za-z]{4}\d{2}$/', $cnpj)) {
            return 'alphanumeric';
        }

        throw new \InvalidArgumentException("Invalid CNPJ format.");
    }

    /**
     * Valida um CNPJ (numérico ou alfanumérico).
     *
     * @param string $cnpj CNPJ para validar.
     * @return bool True se for válido, false caso contrário.
     */
    public static function validate(string $cnpj): bool
    {
        $type = self::detectType($cnpj);

        return match ($type) {
            'numeric' => Cnpj::validate($cnpj),
            'alphanumeric' => CnpjAlfa::validate($cnpj),
        };
    }

    /**
     * Adiciona máscara ao CNPJ.
     *
     * @param string $cnpj CNPJ sem máscara.
     * @return string CNPJ formatado.
     */
    public static function addMask(string $cnpj): string
    {
        $type = self::detectType($cnpj);

        return match ($type) {
            'numeric' => Cnpj::addMask(),
            'alphanumeric' => CnpjAlfa::addMask(),
        };
    }

    /**
     * Remove a máscara de um CNPJ.
     *
     * @param string $cnpj CNPJ mascarado.
     * @return string CNPJ sem máscara.
     */
    public static function removeMask(string $cnpj): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $cnpj);
    }

    /**
     * Gera um CNPJ válido (numérico ou alfanumérico).
     *
     * @param string $type Tipo de CNPJ a ser gerado ("numeric" ou "alphanumeric").
     * @param bool $withMask Define se o CNPJ será retornado com máscara.
     * @return string CNPJ gerado.
     */
    public static function fakeAnyCnpj(string $type = 'numeric', bool $withMask = false): string
    {
        return match ($type) {
            'numeric' => Cnpj::fakeCnpj($withMask),
            'alphanumeric' => CnpjAlfa::fakeCnpjAlfa($withMask),
            default => throw new \InvalidArgumentException("Invalid type. Use 'numeric' or 'alphanumeric'."),
        };
    }
}
