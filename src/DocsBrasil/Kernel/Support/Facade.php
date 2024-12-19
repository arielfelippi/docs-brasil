<?php

namespace DocsBrasil\Kernel\Support;

abstract class Facade
{
    /**
     * Retorna a instância subjacente do container.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        throw new \RuntimeException('Facade accessor has not been defined.');
    }

    /**
     * Manipula chamadas estáticas para a instância subjacente.
     *
     * @param string $method Nome do método chamado.
     * @param array $args Argumentos passados.
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::resolveFacadeInstance(static::getFacadeAccessor());

        if (! $instance) {
            throw new \RuntimeException('A facade root instance has not been resolved.');
        }

        return $instance->$method(...$args);
    }

    /**
     * Resolve a instância subjacente do container.
     *
     * @param string $name Nome do serviço no container.
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        return Container::getInstance()->make($name);
    }
}
