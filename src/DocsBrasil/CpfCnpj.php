<?php

declare(strict_types=1);

namespace DocsBrasil;

class CpfCnpj
{
    private static $value = '';
    private static $instance;

    public function __construct(string $value = '')
    {
        self::init($value);
    }

    public function __toString(): string
    {
        return self::$value;
    }

    public static function init(string $value = ''): CpfCnpj
    {
        self::setValue($value);

        if (strlen(self::$value) <= 11 || empty(self::$value)) {
            return self::$instance = new Cpf(self::$value);
        }

        if (strlen(self::$value) <= 14) {
            return self::$instance = new Cnpj(self::$value);
        }

        self::setValue(substr(self::$value, 0, 14));
        self::$instance = new CpfCnpj(self::$value);

        return self::$instance;
    }

    public static function addMask(): string
    {
        return self::$instance->addMask();
    }

    public static function validate(): bool
    {
        return self::$instance->validate();
    }

    private static function setValue(string $value): void
    {
        self::$value = self::removeMask($value);
    }

    private static function removeMask(string $value): string
    {
        return trim(preg_replace('/[^0-9]/is', '', $value));
    }
}
