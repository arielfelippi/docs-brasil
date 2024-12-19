<?php

namespace DocsBrasil\Kernel\Support;

class Container
{
    protected static $instance;

    protected $bindings = [];

    /**
     * Obtém a instância do container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (! static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Registra um serviço no container.
     *
     * @param string $abstract Nome do serviço.
     * @param callable|object|string $concrete Implementação do serviço.
     */
    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Resolve um serviço do container.
     *
     * @param string $abstract Nome do serviço.
     * @return mixed
     */
    public function make($abstract)
    {
        if (! isset($this->bindings[$abstract])) {
            throw new \RuntimeException("Service {$abstract} is not bound.");
        }

        $concrete = $this->bindings[$abstract];

        if (is_callable($concrete)) {
            return $concrete();
        }

        if (is_string($concrete)) {
            return new $concrete;
        }

        return $concrete;
    }

	public function bootRegistry()
	{
		Registry::register($this);
	}

}
