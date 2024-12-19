<?php

namespace Tests\Unit;

use DocsBrasil\Kernel\Facades\Cpf;

it('validates CPF', function () {
    $validCpf = '529.982.247-25';
    $invalidCpf = '111.111.111-11';

    expect(Cpf::init($validCpf)->validate())->toBeTrue();
    expect(Cpf::init($invalidCpf)->validate())->toBeFalse();
});

it('adds mask to CPF', function () {
    $cpf = '52998224725';
    $maskedCpf = '529.982.247-25';

    expect(Cpf::init($cpf)->addMask())->toBe($maskedCpf);
});
