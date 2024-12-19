<?php

namespace DocsBrasil\Kernel\Facades;

use DocsBrasil\Kernel\Support\Facade;

class Cpf extends Facade
{
    /**
     * Retorna o identificador do serviço subjacente no container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cpf';
    }
}
