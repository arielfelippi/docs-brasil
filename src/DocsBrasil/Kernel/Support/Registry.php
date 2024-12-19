<?php

namespace DocsBrasil\Kernel\Support;

class Registry
{
    /**
     * Lista de serviços a serem registrados no container.
     *
     * @return array
     */
    protected static function services(): array
    {
        return [
            'cpf',
            'cnpj',
            'CnpjAlfa',
            'anyCnpj',
        ];
    }

    /**
     * Registra serviços no container.
     *
     * @param Container $container Instância do container.
     * @return void
     */
    public static function register(Container $container): void
    {
        $services = self::services();

        foreach($services as $service) {
            $container->bind($service, function () use ($service) {
                return ServiceFactory::create($service);
            });
        }
    }
}
