<?php

namespace DocsBrasil\Domain\Documents\Cnpj;

use DocsBrasil\Domain\Masks\Masks;
use DocsBrasil\Traits\MaskTraits;

class CnpjAlfa
{
	use MaskTraits;

	private static $cnpjAlfa = '';

	/**
     * __construct
     *
     * @param  string $cnpjAlfa
     * @return void
     */
    public function __construct(string $cnpjAlfa = '')
    {
        self::setCnpj($cnpjAlfa);
    }

	/**
     * __toString
     *
     * @return string
     */
    public function __toString(): string
    {
        return self::$cnpjAlfa;
    }

    /**
     * init
     *
     * @param  string $cnpjAlfa
     * @return Cnpj
     */
    public static function init(string $cnpjAlfa = ''): CnpjAlfa
    {
        return new self($cnpjAlfa);
    }

    /**
     * addMask
     *
     * @return string $cnpjAlfa
     */
    public static function addMask(): string
    {
        $cnpjString = self::$cnpjAlfa;

        if (empty($cnpjString)) {
            $cnpjString = self::removeMask(self::$cnpjAlfa);
        }

        return self::addMaskToValue($cnpjString, Masks::CNPJ);
    }

    /**
     * removeMask
     *
     * @param  string $cnpjAlfa
     * @return string $cnpjAlfa
     */
    private static function removeMask(string $cnpjAlfa): string
    {
        $cnpjAlfa = trim(preg_replace('/[^a-zA-Z0-9]/', '', $cnpjAlfa));

        return str_pad($cnpjAlfa, 16, '0', STR_PAD_LEFT);
    }

	/**
     * setCnpj
     *
     * @param  string $cnpj
     * @return void
     */
    private static function setCnpj(string $cnpj): void
    {
        self::$cnpjAlfa = self::removeMask($cnpj);
    }

    /**
     * Gera um CNPJ alfanumérico válido.
     *
     * @param bool $withMask Define se o CNPJ será retornado com máscara.
     * @return string CNPJ alfanumérico gerado.
     */
    public static function fakeCnpjAlfa(bool $withMask = false): string
    {
        // Gera a base com 8 dígitos numéricos + 4 caracteres alfabéticos
        $numericPart = '';

        for ($i = 0; $i < 8; $i++) {
            $numericPart .= random_int(0, 9);
        }

        $alphaPart = self::generateRandomAlpha(4);

        $base = $numericPart . $alphaPart;

        // Calcula os dígitos verificadores
        $dv1 = self::calculateDigit(substr($base, 0, 12));
        $dv2 = self::calculateDigit(substr($base, 0, 13));

        $cnpjAlfa = $base . $dv1 . $dv2;

		self::setCnpj($cnpjAlfa);

        return $withMask ? self::addMask() : $cnpjAlfa;
    }

    /**
     * Valida um CNPJ alfanumérico.
     *
     * @param string $cnpjAlfa CNPJ alfanumérico para validar.
     * @return bool True se o CNPJ for válido, false caso contrário.
     */
    public static function validate(string $cnpjAlfa): bool
    {
        // Remove máscara
        $cnpjAlfa = preg_replace('/[^a-zA-Z0-9]/', '', $cnpjAlfa);

        // Verifica o tamanho
        if (strlen($cnpjAlfa) !== 16) {
            return false;
        }

        // Verifica os dígitos verificadores
        $dv1 = self::calculateDigit(substr($cnpjAlfa, 0, 12));
        $dv2 = self::calculateDigit(substr($cnpjAlfa, 0, 13));

        return $dv1 == $cnpjAlfa[12] && $dv2 == $cnpjAlfa[13];
    }

    /**
     * Formata um CNPJ alfanumérico.
     *
     * @param string $cnpjAlfa CNPJ não formatado.
     * @return string CNPJ formatado no padrão XX.XXX.XXX/XXXX-XX.
     */
    public static function format(string $cnpjAlfa): string
    {
        return preg_replace(
            '/(\d{2})(\d{3})(\d{3})([a-zA-Z]{4})(\d{2})(\d{2})/',
            '$1.$2.$3/$4-$5$6',
            $cnpjAlfa
        );
    }

    /**
     * Gera caracteres alfabéticos aleatórios.
     *
     * @param int $length Quantidade de caracteres.
     * @return string String gerada.
     */
    private static function generateRandomAlpha(int $length): string
    {
        $result = '';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $result;
    }

    /**
     * Calcula um dígito verificador para o CNPJ.
     *
     * @param string $base Base do CNPJ (12 ou 13 caracteres).
     * @return int Dígito calculado.
     */
    private static function calculateDigit(string $base): int
    {
        $sum = 0;
		$weights = self::getWeightsForBaseLength(strlen($base));

        foreach (str_split($base) as $i => $char) {
            $value = is_numeric($char) ? (int) $char : (ord(strtoupper($char)) - 55); // Converte A-Z para 10-35
            $sum += $value * $weights[$i];
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
