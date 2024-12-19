<?php

namespace Tests\Unit;

use DocsBrasil\Domain\Documents\CpfCnpj;

it('validates CPF and adds mask', function () {
    $cpf = '52998224725'; // CPF válido sem máscara
    $maskedCpf = '529.982.247-25'; // CPF válido com máscara

    // Verifica se o CPF é validado corretamente
    expect(CpfCnpj::init($cpf)->validate())->toBeTrue();

    // Verifica se a máscara é adicionada corretamente
    expect(CpfCnpj::init($cpf)->addMask())->toBe($maskedCpf);
});

it('validates CNPJ and adds mask', function () {
    $cnpj = '19228187000103'; // CNPJ válido sem máscara
    $maskedCnpj = '19.228.187/0001-03'; // CNPJ válido com máscara

    // Verifica se o CNPJ é validado corretamente
    expect(CpfCnpj::init($cnpj)->validate())->toBeTrue();

    // Verifica se a máscara é adicionada corretamente
    expect(CpfCnpj::init($cnpj)->addMask())->toBe($maskedCnpj);
});

it('identifies and validates mixed input as CNPJ', function () {
    $mixedInput = '19228187000103'; // CNPJ válido sem máscara
    $maskedCnpj = '19.228.187/0001-03'; // CNPJ válido com máscara

    // Verifica se o input misto é identificado como CNPJ e validado corretamente
    expect(CpfCnpj::init($mixedInput)->validate())->toBeTrue();

    // Verifica se a máscara é adicionada corretamente
    expect(CpfCnpj::init($mixedInput)->addMask())->toBe($maskedCnpj);
});

it('identifies and validates mixed input as CPF', function () {
    $mixedInput = '52998224725'; // CPF válido sem máscara
    $maskedCpf = '529.982.247-25'; // CPF válido com máscara

    // Verifica se o input misto é identificado como CPF e validado corretamente
    expect(CpfCnpj::init($mixedInput)->validate())->toBeTrue();

    // Verifica se a máscara é adicionada corretamente
    expect(CpfCnpj::init($mixedInput)->addMask())->toBe($maskedCpf);
});
