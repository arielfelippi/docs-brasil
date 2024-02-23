<?php

declare(strict_types=1);

namespace DocsBrasil\Traits;

trait MaskTraits
{
    /**
     * function addMask
     *
     * @param string $value
     * @param string $mask
     * @return string $maskared
     */
    final public static function addMaskToValue(string $value, string $mask): string
    {
        $maskared = '';

        for ($i = 0, $j = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] === '#' && isset($value[$j])) {
                $maskared .= $value[$j];
                $j++;

                continue;
            }

            if (isset($mask[$i])) {
                $maskared .= $mask[$i];
            }
        }

        return $maskared;
    }
}
