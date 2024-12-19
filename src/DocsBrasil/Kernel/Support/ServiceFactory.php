<?php

namespace DocsBrasil\Kernel\Support;

class ServiceFactory
{
    /**
     * Cria uma instância de um serviço com base no nome.
     *
     * @param string $service Nome do serviço.
     * @return mixed
     */
    public static function create(string $service)
    {
        return match ($service) {
            'cpf' => new \DocsBrasil\Domain\Documents\Cpf(),
            'cnpj' => new \DocsBrasil\Domain\Documents\Cnpj\Cnpj(),
            'cnpjAlfa' => new \DocsBrasil\Domain\Documents\Cnpj\CnpjAlfa(),
            'cpfCnpj' => new \DocsBrasil\Domain\Documents\CpfCnpj(),
            'anyCnpj' => new \DocsBrasil\Domain\Documents\AnyCnpj(),
            default => throw new \InvalidArgumentException("Service {$service} not found."),
        };
    }
}
