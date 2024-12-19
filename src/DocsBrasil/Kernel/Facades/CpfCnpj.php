<?php

namespace DocsBrasil\Kernel\Facades;

use DocsBrasil\Kernel\Support\Facade;

class CpfCnpj extends Facade
{
    /**
     * Retorna o identificador do serviço subjacente no container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cpfCnpj';
    }
}
