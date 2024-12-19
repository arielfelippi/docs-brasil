<?php

declare(strict_types=1);

namespace DocsBrasil\Domain\Documents;

class CpfCnpj
{
    private static $value = '';
    private static $instance = null;

    public function __construct(string $value = '')
    {
        self::init($value);
    }

    public function __toString(): string
    {
        return self::$value;
    }

    public static function init(string $value = '')
    {
        self::$instance = null;
        self::setValue($value);

        if (self::isCpf()) {
            return self::createInstance(new Cpf(self::$value));
        }

        if (self::isCnpj()) {
            return self::createInstance(new Cnpj(self::$value));
        }

        self::setValue(substr(self::$value, 0, 14));

        return self::createInstance(new Cnpj(self::$value));
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

    private static function isCpf(): bool
    {
        return strlen(self::$value) <= 11 && !empty(self::$value);
    }

    private static function isCnpj(): bool
    {
        return strlen(self::$value) > 11 && strlen(self::$value) <= 14;
    }

    private static function createInstance($instance)
    {
        return self::$instance = $instance;
    }
}
